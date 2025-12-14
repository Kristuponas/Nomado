<?php
require_once __DIR__ . "/../../src/database/database.php";
require_once __DIR__ . "/../../src/api/comments.php";
$db = Database::getInstance();

$count = isset($_GET['count']) ? (int)$_GET['count'] : 10;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

if (isset($_GET['hotel_id'])) {
   $comments = get_comments($db, $count, $offset, (int)$_GET['hotel_id']);
} else { 
   $comments = get_comments($db, $count, $offset);
}

echo json_encode($comments);
