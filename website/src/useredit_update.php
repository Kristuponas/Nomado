<?php
session_start();
require_once __DIR__ . '/../database.php';

if (!isset($_SESSION['userid'])) {
    exit;
}

$field = $_POST['field'] ?? '';
$value = trim($_POST['value'] ?? '');

$allowed = [
    'vardas',
    'pavarde',
    'el_pastas'
];

$db = Database::getInstance();

if ($field === 'password') {
    $hash = password_hash($value, PASSWORD_DEFAULT);
    $db->update('vartotojas',
        ['slaptazodis' => $hash],
        ['id' => $_SESSION['userid']]
    );
} elseif (in_array($field, $allowed)) {
    $db->update('vartotojas',
        [$field => $value],
        ['id' => $_SESSION['userid']]
    );
}

header("Location: ../public/edit_profile.php");
exit;
