<?php
session_start();
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../src/database/database.php";

use PragmaRX\Google2FA\Google2FA;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = Database::getInstance();
$google2fa = new Google2FA();

// jei dar neturim laikino secret – sugeneruojam
if (!isset($_SESSION['2fa_secret_tmp'])) {
    $_SESSION['2fa_secret_tmp'] = $google2fa->generateSecretKey();
}

$secret = $_SESSION['2fa_secret_tmp'];

$user = $db->select('vartotojas', ['id' => $_SESSION['user_id']])[0];

$qrCodeUrl = $google2fa->getQRCodeUrl(
    'Nomado',
    $user['el_pastas'],
    $secret
);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code']);

    // PATIKRINAM KODĄ
    if ($google2fa->verifyKey($secret, $code)) {

        // tik dabar saugom DB
        $db->update('vartotojas', [
            'twofa_secret' => $secret,
            'twofa_enabled' => 1
        ], ['id' => $_SESSION['user_id']]);

        unset($_SESSION['2fa_secret_tmp']);
        header("Location: home.php");
        exit;

    } else {
        $error = "Neteisingas kodas, bandykite dar kartą";
    }
}
?>
<head>
    <link rel="stylesheet" href="css/TFA.css">
</head>
<h2>Įjunkite 2FA</h2>
<p>Nuskanuokite QR kodą ir įveskite kodą iš programėlės:</p>

<img class="QR" src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($qrCodeUrl) ?>">

<div class="input">
    <form method="POST">
        <?php if ($error): ?>
            <p style="color:red"><?= $error ?></p>
            <?php endif; ?>
            <input class="input-box" type="text" name="code" pattern="\d{6}" maxlength="6" required>
            <button class="input-button" type="submit">Patvirtinti</button>
    </form>
</div>
