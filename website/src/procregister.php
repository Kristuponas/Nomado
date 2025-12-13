<?php
session_start();

include("Properties/nustatymai.php");
include("Properties/functions.php");

if (!isset($_POST['user_reg'])) {
    header("Location: ../Public/Login.php");
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
    header("Location: ../Public/Login.php");
    exit;
}

list($dbuname) = checkdb($user);
if ($dbuname) {
    $_SESSION['name_error'] = "Username already exists";
    header("Location: ../Public/Login.php");
    exit;
}

if (!checkmail($mail) || !checkpassformat($pass)) {
    $_SESSION['pass_error'] = "Password or email invalid";
    header("Location: ../Public/Login.php");
    exit;
}

// REGISTRACIJA DB
$passHash = password_hash($pass, PASSWORD_DEFAULT);
$ulevel = $user_roles[DEFAULT_LEVEL];

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

$sql = "INSERT INTO vartotojas 
(vartotojo_vardas, asmens_kodas, vardas, pavarde, el_pastas, slaptazodis, tipas)
VALUES ('$user', '$ID_number', '$name', '$surname', '$mail', '$passHash', '$ulevel')";

if (!mysqli_query($db, $sql)) {
    $_SESSION['message'] = "SQL ERROR: " . mysqli_error($db);
} else {
    $_SESSION['message'] = "Registracija sėkminga!";
}

header("Location: ../Public/Login.php");
exit;
