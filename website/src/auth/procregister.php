<?php


require_once __DIR__ . '/../database/database.php';
require_once __DIR__ . '/../functions.php';
require_once __DIR__ . '/../settings.php';

$db = Database::getInstance();

// Patikrinam, ar POST užklausa
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['action']) || $_POST['action'] !== 'register') {
    header("Location: /login.php");
    exit;
}

// Gauti duomenis iš formos
$name      = trim($_POST['name_reg'] ?? '');
$surname   = trim($_POST['surname_reg'] ?? '');
$username  = trim($_POST['user_reg'] ?? '');
$password  = trim($_POST['pass_reg'] ?? '');
$email     = trim($_POST['mail_reg'] ?? '');
$ID_number = trim($_POST['ID_reg'] ?? '');

// Išvalome sesiją klaidoms
$_SESSION['name_error'] = '';
$_SESSION['pass_error'] = '';
$_SESSION['message'] = '';

// Paprasta validacija
if (empty($name) || empty($surname) || empty($username) || empty($password) || empty($email) || empty($ID_number)) {
    $_SESSION['message'] = "Visi laukai privalomi!";
    header("Location: /login.php");
    exit;
}

if (!checkname($username)) {
    $_SESSION['name_error'] = "Netinkamas vartotojo vardas!";
    header("Location: /login.php");
    exit;
}

if (!checkmail($email)) {
    $_SESSION['pass_error'] = "Netinkamas el. paštas!";
    header("Location: /login.php");
    exit;
}

if (!checkpassformat($password)) {
    $_SESSION['pass_error'] = "Slaptažodis netinkamas!";
    header("Location: /login.php");
    exit;
}


// Hashinam slaptažodį
$passHash = password_hash($password, PASSWORD_DEFAULT);

// Nustatome vartotojo tipą
$ulevel = $user_roles[DEFAULT_LEVEL] ?? 3; // Jei nenurodyta, default į 2 (user)

// Duomenys į DB
$data = [
    'vartotojo_vardas' => $username,
    'asmens_kodas'     => $ID_number,
    'vardas'           => $name,
    'pavarde'          => $surname,
    'el_pastas'        => $email,
    'slaptazodis'      => $passHash,
    'tipas'            => $ulevel,
    'twofa_secret'     => null,
    'twofa_enabled'    => 0
];

try {
    $db->insert('vartotojas', $data);
    $_SESSION['message'] = "Registracija sėkminga!";
} catch (Exception $e) {
    $_SESSION['message'] = "SQL klaida: " . $e->getMessage();
}

// Nukreipiame atgal į login.php
header("Location: /login.php");
exit;
