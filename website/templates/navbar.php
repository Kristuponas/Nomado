<?php
    require __DIR__ . '/../src/settings.php';

    $userlevel = $_SESSION['ulevel'] ?? $user_roles['guest'];


    // Nustatome rolę
    $role = ($userlevel == 4) ? "guest" : "";

    foreach($user_roles as $name => $level){
        if($level == $userlevel) 
            $role = $name;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_POST['action'] ?? '') === 'logout') {
        require __DIR__ .'/../src/auth/logout.php';
    }
?>


<head>
    <link rel="stylesheet" href="../css/style.css">
    
   
</head>
<header class="header">
    <div class="container">
        <div class="logo">
            <h1>Nomado</h1>
            <p>Where comfort meets luxury</p>
        </div>
        <nav class="main-nav">
	    <ul>
                <li><a href="/">Home</a></li>
                <?php if($userlevel !== $user_roles['guest'] || isset($_SESSION['user_id'])): ?>
                    <li><a href="favorites.php">Favorites</a></li>
                <?php endif; ?>
                <?php if($userlevel === $user_roles['admin']): ?>
                     <li><a href="user_managment.php">User managment</a></li>
                     <?php endif; ?>
                <li><a href="/about_us.php">About us</a></li>
            </ul>
            </nav>
        <div class="auth-buttons">
            <?php if ($userlevel === $user_roles['guest']): ?>
                <a href="/login.php" class="btn btn-primary">Sign Up</a>
            <?php else: ?>
                <a href="/edit_profile.php" class="btn btn-outline-light me-2">Edit profile</a>
                <?php if($userlevel !== $user_roles['guest'] || isset($_SESSION['user_id'])): ?>
                <form method="POST">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="btn btn-light me-2" style="font-size: 16px">Log out</button>
                </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </div>
</header>
