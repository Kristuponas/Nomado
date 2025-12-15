<?php
session_start();
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../src/database/database.php";
use PragmaRX\Google2FA\Google2FA;

if (!isset($_SESSION['2fa_user_id'])) {
    header("Location: login.php");
    exit;
}

$db = Database::getInstance();
$user = $db->select('vartotojas', ['id' => $_SESSION['2fa_user_id']])[0];
$google2fa = new Google2FA();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code']);
    if ($google2fa->verifyKey($user['twofa_secret'], $code, 2)) {
        $_SESSION['user_id'] = $user['id'];
        unset($_SESSION['2fa_user_id']);
        session_regenerate_id(true);
        header("Location: /home.php");
        exit;
    } else {
        $error = "Neteisingas 2FA kodas";
    }
}
?>
<head>
    <link rel="stylesheet" href="css/TFA.css">
</head>
<div class="box">

    <h2>Įveskite Google Authenticator kodą</h2>
    <p>Jei neturite Google Authenticator programėlės, <a href="enable_2fa.php">nuskanuokite QR kodą čia</a></p>
    <div class="input">
        <form method="POST">
            <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
            <input class="input-box" type="text" name="code" pattern="\d{6}" maxlength="6" required>
            <button class="input-button" type="submit">Patvirtinti</button>
        </form>
    </div>
</div>