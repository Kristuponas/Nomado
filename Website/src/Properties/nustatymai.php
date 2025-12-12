<?php
//nustatymai.php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "booking");
define("TBL_USERS", "vartotojas");

// Vartotojų profiliai
$user_roles=array(      // vartotojų rolių vardai ir  atitinkamos userlevel reikšmės
	"admin"=>"1",
	"user"=>"2",
    "unverified"=>"3");   
// automatiškai galioja ir vartotojas "guest",rolė "Svečias",  userlevel=0
//   jam irgi galima nurodyti leidžiamas operacijas

define("DEFAULT_LEVEL","unverified");  // kokia rolė priskiriama kai registruojasi
define("ADMIN_LEVEL","admin");  // jis turi vartotojų valdymo teisę per "Administratoriaus sąsaja"

$uregister="self";  // kaip registruojami vartotojai:
					// self - pats registruojasi, admin - tik ADMIN_LEVEL, both - abu atvejai
