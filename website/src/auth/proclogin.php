<?php
require_once(__DIR__ . "/../functions.php");
require_once(__DIR__ . "/../database/database.php");


$_SESSION['name_error'] = "";
$_SESSION['pass_error'] = "";

$user = strtolower(trim($_POST['name_login']));
$pass = trim($_POST['pass_login']);

$_SESSION['name_login'] = $user;


if (!checkname($user)) {
    return;
}
$db = $db = Database::getInstance();

$where = ['vartotojo_vardas' => $user];
$row = $db->select('vartotojas', $where)[0];

// Jei vartotojo nėra
if (empty($row)) {
    $_SESSION['name_error'] = "<font color='red'>* Tokio vartotojo nėra</font>";
    return;
}

if (!password_verify($pass, $row['slaptazodis'])) {
    $_SESSION['pass_error'] = "<font color='red'>* Neteisingas slaptažodis</font>";
    return;
}
$_SESSION['user_id'] = $row['id'];

session_regenerate_id(false);

header("Location: /home.php");
exit;
