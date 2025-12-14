<?php
require_once 'config.php';

class Database
{
    private $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;
    private $dbName = DB_NAME;

    private $dbHandler;
    private $error;

    private static $instance;

    private function __construct()
    {
        $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
	    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        );

        try {
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object();
        }
        return self::$instance;
    }


    public function select(
        string $table,
        array $conditions = [],
        $columns = '*',
        ?int $limit = null,
        ?int $offset = null
    ) {
        if (is_array($columns)) {
            $columns = implode(', ', array_map(fn ($col) => "`$col`", $columns));
        }

        $sql = "SELECT $columns FROM `$table`";

        if (!empty($conditions)) {
            $whereClauses = [];

            foreach ($conditions as $field => $value) {
                if (is_null($value)) {
                    $whereClauses[] = "`$field` IS NULL";
                } else {
                    $whereClauses[] = "`$field` = :$field";
                }
            }

            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }

        if ($limit !== null) {
            $sql .= " LIMIT :limit";

            if ($offset !== null) {
                $sql .= " OFFSET :offset";
            }
        }

        $stmt = $this->dbHandler->prepare($sql);

        foreach ($conditions as $field => $value) {
            if (!is_null($value)) {
                $stmt->bindValue(":$field", $value);
            }
        }

        if ($limit !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        }

        if ($offset !== null) {
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function insert($table, $data)
    {
        $fields = array_keys($data);
        $placeholders = ':' . implode(', :', $fields);

        $sql = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES ($placeholders)";

        try {
            $stmt = $this->dbHandler->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new Exception('already exists');
            }

            throw $e;
        }
    }

    public function count($table, $conditions = [])
    {
        $sql = "SELECT COUNT(*) as cnt FROM `$table`";

        if (!empty($conditions)) {
            $whereClauses = [];
            foreach ($conditions as $field => $value) {
                if (is_null($value)) {
                    $whereClauses[] = "`$field` IS NULL";
                } else {
                    $whereClauses[] = "`$field` = :$field";
                }
            }
            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }

        $stmt = $this->dbHandler->prepare($sql);

        foreach ($conditions as $field => $value) {
            if (!is_null($value)) {
                $stmt->bindValue(":$field", $value);
            }
        }

        $stmt->execute();
        $result = $stmt->fetch();
        return $result['cnt'] ?? 0;
    }

    public function delete($table, $conditions)
    {
        if (empty($conditions)) {
            throw new Exception("Delete operation requires at least one condition to prevent full table wipe.");
        }

        $whereClauses = [];

        foreach ($conditions as $field => $value) {
            if (is_null($value)) {
                $whereClauses[] = "`$field` IS NULL";
            } else {
                $whereClauses[] = "`$field` = :$field";
            }
        }

        $sql = "DELETE FROM `$table` WHERE " . implode(' AND ', $whereClauses);

        $stmt = $this->dbHandler->prepare($sql);

        foreach ($conditions as $field => $value) {
            if (!is_null($value)) {
                $stmt->bindValue(":$field", $value);
            }
        }

        return $stmt->execute();
    }

    public function update($table, $data, $conditions)
    {
        if (empty($data)) {
            throw new Exception("Update operation requires at least one field to update.");
        }

        if (empty($conditions)) {
            throw new Exception("Update operation requires at least one condition to prevent full table update.");
        }

        $setClauses = [];
        foreach ($data as $field => $value) {
            $setClauses[] = "`$field` = :set_$field";
        }

        $whereClauses = [];
        foreach ($conditions as $field => $value) {
            if (is_null($value)) {
                $whereClauses[] = "`$field` IS NULL";
            } else {
                $whereClauses[] = "`$field` = :cond_$field";
            }
        }

        $sql = "UPDATE `$table` SET " . implode(', ', $setClauses)
             . " WHERE " . implode(' AND ', $whereClauses);

        $stmt = $this->dbHandler->prepare($sql);

        foreach ($data as $field => $value) {
            $stmt->bindValue(":set_$field", $value);
        }

        foreach ($conditions as $field => $value) {
            if (!is_null($value)) {
                $stmt->bindValue(":cond_$field", $value);
            }
        }

        return $stmt->execute();
    }

}
