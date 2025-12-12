<?php

session_start();
if (!isset($_SESSION)) {
    session_start();
}
$_SESSION['prev'] = "register";


include("../src/Properties/nustatymai.php");
include("../src/Properties/functions.php");
if ($_SESSION['prev'] != "procregister")  inisession("part"); 
$_SESSION['prev']="register";
?>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomado - Luxury Hotel Booking</title>
    <link rel="stylesheet" href="../CSSStyles/style.css">
    <link rel="stylesheet" href="../CSSStyles/Login_stilius.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <h1>Nomado</h1>
                <p>Where comfort meets luxury</p>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="Home.html">Home</a></li>
                    <li><a href="deals.html">Deals</a></li>
                    <li><a href="About_Us.html">About us</a></li>
                </ul>
            </nav>
    </div>
    </header>    
        <div class = "login-wrap">
            <div class="login-html">
                <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
                <label for="tab-1" class="tab">Sign In</label>
                <input id="tab-2" type="radio" name="tab" class="sign-up">
                <label for="tab-2" class="tab">Sign Up</label>                <div class = "login-form">
                    <div class="sign-in-htm">
                        <form action="proclogin.php" method="POST">

                            <div class="group">
                                <label for="user" class="label">Username</label>
                                <input id="user" type ="text" class="input" name="name_login">
                            </div>
                            <div class = "group">
                                <label for ="pass" class="label">Password</label>
                                <input id="pass" type="password" class="input" data-type ="password" name="pass_login">
                            </div>
                            <div class="group">
                                <input type="submit" class ="button" value="Sign In">
                            </div>
                            <div class="hr"></div>
                            <div class ="foot-lnk">
                                <a href="#forgot">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                    <div class="sign-up-htm">
                        <form action="../src/procregister.php" method="POST">
                            <div class ="group">
                                <label for ="user" class="label">Name</label>
                                <input id="user" type="text" class="input" name="name_reg">
                            </div>
                            <div class ="group">
                                <label for ="user" class="label">Surname</label>
                                <input id="user" type="text" class="input" name="surname_reg">
                            </div>
                            <div class ="group">
                                <label for ="user" class="label">Username</label>
                                <input id="user" type="text" class="input" name="user_reg">
                            </div>
                            <div class ="group">
                                <label for="pass" class="label">Password</label>
                                <input id="pass" type="password" class="input" data-type="password" name="pass_reg">
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Email Address</label>
                                <input id="pass" type="text" class="input" name="mail_reg">
                            </div>
                             <div class="group">
                                <label for="pass" class="label">Personal ID number</label>
                                <input id="ID" type="number" class="input" name="ID_reg">
                            </div>
                            <div class="group signup_btn">
                                <input type="submit" class="button" value="Sign Up">
                            </div>
                        </form>
                        <div class="hr"></div>
                    </div>
                </div> 
            </div>
        </div>

    </body>
</html>