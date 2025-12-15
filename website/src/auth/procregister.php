<?php


require_once __DIR__ . "/../functions.php";
require_once __DIR__ . "/../database/database.php";
require __DIR__ . "/../settings.php";




$db = Database::getInstance();

if (!isset($_POST['user_reg'])) {
    header("Location: /login.php");
    exit;
}

// GAUNAM DUOMENIS
$name = strtolower(trim($_POST['name_reg']));
$surname = strtolower(trim($_POST['surname_reg']));
$user = strtolower(trim($_POST['user_reg']));
$pass = trim($_POST['pass_reg']);
$mail = trim($_POST['mail_reg']);
$ID_number = trim($_POST['ID_reg']);

$_SESSION['user_reg'] = $user;
$_SESSION['mail_reg'] = $mail;

// VALIDACIJA
if (!checkname($user)) {
    $_SESSION['name_error'] = "Bad username";
    header("Location: /login.php");
    exit;
}

list($dbuname) = checkdb($user);
if ($dbuname) {
    $_SESSION['name_error'] = "Username already exists";
    header("Location: /login.php");
    exit;
}

if (!checkmail($mail) || !checkpassformat($pass)) {
    $_SESSION['pass_error'] = "Password or email invalid";
    header("Location: /login.php");
    exit;
}

// REGISTRACIJA DB
$passHash = password_hash($pass, PASSWORD_DEFAULT);
$ulevel = $user_roles[DEFAULT_LEVEL];

$data = [
	'vartotojo_vardas' => $user, 
	'asmens_kodas' => $ID_number, 
	'vardas' => $name, 
	'pavarde' => $surname, 
	'el_pastas' => $mail,
	'slaptazodis' => $passHash,
	'tipas' => $ulevel
	];

try {
    $db->insert('vartotojas', $data);
    $_SESSION['message'] = "Registracija sėkminga!";
} catch (Exception $e) {
    $_SESSION['message'] = "SQL ERROR " . $e->getMessage();
}

header("Location: /login.php");
exit;
