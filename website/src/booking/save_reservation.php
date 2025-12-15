<?php
require_once __DIR__ . '/../database/database.php';

$check_in  = $_POST['from_date'] . ' 14:00:00';
$check_out = $_POST['to_date']   . ' 11:00:00';
$hotel_id = $_GET['hotel_id'];

if (strtotime($check_out) <= strtotime($check_in)) {
    die('Invalid date range');
}

$db = Database::getInstance();

$data = [
    'pradzios_data' => $check_in, 
    'pabaigos_data' => $check_out, 
    'fk_Vartotojas' => $_SESSION['user_id'], 
    'fk_Viesbutis' => $hotel_id,
    'busena' => 3,
];

$db->insert('rezervacija', $data);

header("Location: /hotel_details.php?hotel_id=$hotel_id");
