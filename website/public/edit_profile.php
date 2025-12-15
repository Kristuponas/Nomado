<?php
session_start();
require_once __DIR__ . '/../src/database/database.php';

require __DIR__ . '/../templates/navbar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit;
}

$db = Database::getInstance();
$userid = $_SESSION['user_id'];

$user = $db->select('vartotojas', ['id' => $userid])[0];
$passLength = strlen($user['slaptazodis']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'save':
            require_once __DIR__ . '/../src/user_edit/useredit_update.php';
            break;
        }
    }
    ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">


    <!--<link rel="stylesheet" href="../CSSStyles/style.css">-->
    <link rel="stylesheet" href="../css/edit_profile.css">

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
            <button class="edit-btn" onclick="document.getElementById('password_Modal').style.display='block'">
                Edit
            </button>
        </div>
    </div>
    <div class="TFA">
        <button onclick="window.location.href='enable_2fa.php'">Enable Two-Factor Authentication</button>
    </div>

    <!-- MODAL -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h3 class="display_name" id="modal-label"></h3>

            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                <input type="hidden" name="action" value="save">
                <input  type="hidden" name="field" id="field">

                    
                <input class="input_field" type="text" name="value" id="modal-input" style="width:100%" required>

                <br><br>
                <button class="update_btn" type="submit">Save</button>
                <button class="update_btn_cancle" type="button" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>
    <div id="password_Modal" class="modal">
        <div class="modal-content">
            <h2 class="display_name">Change pasword</h2>
            <p><?= $_SESSION['message'] ?? ''?></p>
            <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="field" value="password">
                
                <label class="display_name" for="current_password">Current Password</label>
                <input  class="input_field" type="password" id="current_password" name="current_password"required>
                <br>
                <label class="display_name" for="new_password">New Password</label>
                <input class="input_field" type="password" id="new_password" name="new_password" required>

                <br><br>
                <button class="update_btn" type="submit">Save</button>
                <button class="update_btn_cancle" type="button" onclick="document.getElementById('password_Modal').style.display='none'">Cancel</button>

            </form> 
        </div>

    </div>

</body>

</html>