<?php
session_start();
require_once __DIR__ . '/../src/database/database.php';
require_once __DIR__ . '/../src/properties/nustatymai.php';

include("../src/Properties/meniu.php");

if (!isset($_SESSION['userid'])) {
    header("Location: Login.php");
    exit;
}

$db = Database::getInstance();
$userid = $_SESSION['userid'];

$user = $db->select('vartotojas', ['id' => $userid])[0];
$passLength = strlen($user['slaptazodis']);
$user
    ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">


    <!--<link rel="stylesheet" href="../CSSStyles/style.css">-->
    <link rel="stylesheet" href="css/style.css">

    <script>
        function openModal(field, label, value) {
            document.getElementById('modal').style.display = 'block';
            document.getElementById('field').value = field;
            document.getElementById('modal-label').innerText = label;
            document.getElementById('modal-input').value = value;
        }
        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</head>

<body>

    <div class="info">
        <h2>Edit account</h2>

        <div class="profile-row">
            <span class="label">Username</span>
            <span><?= htmlspecialchars($user['vartotojo_vardas']) ?></span>
            <span></span>
        </div>

        <div class="profile-row">
            <span class="label">ID number</span>
            <span><?= htmlspecialchars($user['asmens_kodas']) ?></span>
            <span></span>
        </div>


        <div class="profile-row">
            <span class="label">Name</span>
            <span><?= htmlspecialchars($user['vardas']) ?></span>
            <button class="edit-btn"
                onclick="openModal('vardas','Name','<?= htmlspecialchars($user['vardas'], ENT_QUOTES) ?>')">
                Edit
            </button>
        </div>

        <div class="profile-row">
            <span class="label">Surname</span>
            <span><?= htmlspecialchars($user['pavarde']) ?></span>
            <button class="edit-btn"
                onclick="openModal('pavarde','Surname','<?= htmlspecialchars($user['pavarde'], ENT_QUOTES) ?>')">
                Edit
            </button>
        </div>


        <div class="profile-row">
            <span class="label">Email</span>
            <span><?= htmlspecialchars($user['el_pastas']) ?></span>
            <button class="edit-btn"
                onclick="openModal('el_pastas','Email','<?= htmlspecialchars($user['el_pastas'], ENT_QUOTES) ?>')">
                Edit
            </button>
        </div>


        <div class="profile-row">
            <span class="label">Password</span>
            <span>**************</span>
            <button class="edit-btn" onclick="openModal('password','Password','')">
                Edit
            </button>
        </div>
    </div>

    <!-- MODAL -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h3 class="display_name" id="modal-label"></h3>

            <form method="POST" action="../src/useredit_update.php">
                <input  type="hidden" name="field" id="field">

                <p>Current password</p>    
                <input class="input_field" type="text" name="value" id="modal-input" style="width:100%" required>

                <br><br>
                <button class="update_btn" type="submit">Save</button>
                <button class="update_btn_cancle" type="button" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>

</body>

</html>
