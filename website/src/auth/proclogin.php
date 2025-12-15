<?php
require_once __DIR__ . "/../functions.php";
require_once __DIR__ . "/../database/database.php";
require_once __DIR__ . "/../../vendor/autoload.php";

use PragmaRX\Google2FA\Google2FA;

// Išvalome klaidas
$_SESSION['name_error'] = "";
$_SESSION['pass_error'] = "";

// Gauti formos duomenis
$user = strtolower(trim($_POST['name_login'] ?? ""));
$pass = trim($_POST['pass_login'] ?? "");

$_SESSION['name_login'] = $user;

// Tikriname username formatą
if (!checkname($user)) {
    $_SESSION['name_error'] = "Neteisingas vartotojo vardas";
    header("Location: /login.php");
    exit;
}

// Prisijungiame prie DB
$db = Database::getInstance();
$where = ['vartotojo_vardas' => $user];
$row = $db->select('vartotojas', $where)[0] ?? null;

// Jei vartotojo nėra
if (!$row) {
    $_SESSION['name_error'] = "* Tokio vartotojo nėra";
    header("Location: /login.php");
    exit;
}

// Patikriname slaptažodį
if (!password_verify($pass, $row['slaptazodis'])) {
    $_SESSION['pass_error'] = "* Neteisingas slaptažodis";
    header("Location: /login.php");
    exit;
}

// Username ir password teisingi
$_SESSION['user_id_temp'] = $row['id']; // Laikinai, kol patikrinsime 2FA

$google2fa = new Google2FA();

// Jei vartotojas turi 2FA įjungtą
if (!empty($row['twofa_secret'])) {
    $_SESSION['2fa_user_id'] = $row['id'];
    $_SESSION['ulevel'] = $row['tipas'];
    unset($_SESSION['user_id_temp']); // Laikinas vartotojas nebebus reikalingas
    header("Location: /confirm2fa.php");
    exit;
}

// Jei vartotojas neturi 2FA
$_SESSION['user_id'] = $row['id']; // Prisijungimo sesija
header("Location: /enable_2fa.php");
exit;
