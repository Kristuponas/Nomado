<?php
function get_comments($db, $count, $offset) {
    $count = isset($_GET['count']) ? (int)$_GET['count'] : 10;
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

    return $db->select('komentaras', [], '*', $count, $offset);
}
