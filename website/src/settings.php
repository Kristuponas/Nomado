<?php

// Vartotojų profiliai
$user_roles = [
    "admin"      => 1,
    "user"       => 2,
    "unverified" => 3,
    "guest"      => 4
];

// Konstantoje laikom SKAIČIŲ, ne string
define("DEFAULT_LEVEL", $user_roles['unverified']);
define("ADMIN_LEVEL",   $user_roles['admin']);

$uregister = "self";
