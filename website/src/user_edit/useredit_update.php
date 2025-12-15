<?php
session_start();
require_once __DIR__ . '/../database/database.php';

if (!isset($_SESSION['user_id'])) {
    exit;
}

$field = $_POST['field'] ?? '';
$value = trim($_POST['value'] ?? '');
$userid = $_SESSION['user_id'];
$allowed = [
    'vardas',
    'pavarde',
    'el_pastas'
];

$db = Database::getInstance();

if ($field === 'password') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';

    $user = $db->select('vartotojas', ['id' => $userid])[0];
    if(password_verify($current, $user['slaptazodis'])) {
        $newHash = password_hash($new, PASSWORD_DEFAULT);
        $db->update('vartotojas',['slaptazodis' => $newHash],['id' => $userid]);
        $_SESSION['message'] = "Password updated successfully!";
    } else {
        $_SESSION['message'] = "Current password is incorrect!";
    } 
}

header("Location: /edit_profile.php");
exit;
