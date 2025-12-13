<?php
// funkcijos  include/functions.php
require_once "nustatymai.php";

function inisession($arg) { 
            if($arg =="full"){
                $_SESSION['message']="";
                $_SESSION['user']="";
	       		$_SESSION['ulevel']=0;
				$_SESSION['userid']=0;
				$_SESSION['umail']=0;
            }			    	 
		$_SESSION['name_login']="";
		$_SESSION['pass_login']="";
		$_SESSION['name_reg']="";
		$_SESSION['pass_reg']="";
		$_SESSION['mail_reg']="";
		$_SESSION['name_error']="";
      	$_SESSION['pass_error']="";
		$_SESSION['mail_error']=""; 
        }
function checkname ($username){ 
	   if (!$username || strlen($username = trim($username)) == 0) 
        {
            $_SESSION['name_error']=
				 "<font size=\"2\" color=\"#ff0000\">* Neįvestas vartotojo vardas</font>";
			 "";
			return false;
        }
        elseif (!preg_match("/^([0-9a-zA-Z])*$/", $username))
		{
            $_SESSION['name_error']=
				"<font size=\"2\" color=\"#ff0000\">* Vartotojo vardas gali būti sudarytas<br>
				&nbsp;&nbsp;tik iš raidžių ir skaičių</font>";
		     return false;
        }
	        else return true;
   }
function checkpassformat($pwd) {
    if (!$pwd || strlen(trim($pwd)) == 0) {
        $_SESSION['pass_error'] = "<font size=\"2\" color=\"#ff0000\">* Neįvestas slaptažodis</font>";
        return false;
    }
    elseif (!preg_match("/^[0-9a-zA-Z]*$/", $pwd)) {
        $_SESSION['pass_error'] = "* Slaptažodis gali būti sudarytas tik iš raidžių ir skaičių";
        return false;
    }
    elseif (strlen($pwd) < 4) {
        $_SESSION['pass_error'] = "<font size=\"2\" color=\"#ff0000\">* Slaptažodžio ilgis <4 simbolių</font>";
        return false;
    }
    return true;
}

function checkdb($username) {  
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    $sql = "SELECT * FROM vartotojas WHERE vartotojo_vardas = '$username'";
    $result = mysqli_query($db, $sql);

    $uname = $upass = $ulevel = $uid = $umail = $uPersonalID = null;

    if ($result && mysqli_num_rows($result) == 1) {  
        $row = mysqli_fetch_assoc($result); 
        $uname = $row["vartotojo_vardas"];
        $upass = $row["slaptazodis"];
        $ulevel = $row["tipas"];
        $uid = $row["id"];
        $umail = $row["el_pastas"];
        $uPersonalID = $row["asmens_kodas"];
    }

    return array($uname, $upass, $ulevel, $uid, $umail, $uPersonalID);
}


function checkmail($mail) {    
	   if (!$mail || strlen($mail = trim($mail)) == 0) 
			{
                $_SESSION['mail_error']=
				"<font size=\"2\" color=\"#ff0000\">* Neįvestas e-pašto adresas</font>";
			   return false;
            }
            elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) 
	        {
                  $_SESSION['mail_error']=
			   "<font size=\"2\" color=\"#ff0000\">* Neteisingas e-pašto adreso formatas</font>";
                  return false;
            }
	        else return true;
   }
