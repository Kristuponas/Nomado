<?php session_start();
require_once __DIR__ . "/../src/database/database.php";
require __DIR__ . '/../templates/navbar.php';
if ($_SESSION['ulevel'] !== 1) {
    http_response_code(403);
    exit('Access denied');
}
$db = Database::getInstance();
$users = $db->select('vartotojas');
$roles = $db->select('vartotoju_tipas');
$rolemap = [];
foreach ($roles as $role) {
    $rolemap[$role['id']] = $role['name'];
} 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'update') {
        $db->update(
            'vartotojas',
            [
                'vartotojo_vardas' => $_POST['username'],
                'vardas' => $_POST['vardas'],
                'pavarde' => $_POST['pavarde'],
                'el_pastas' => $_POST['el_pastas'],
                'tipas' => $_POST['tipas']
            ],
            ['id' => $_POST['user_id']]
        );
    }

    if ($_POST['action'] === 'delete') {
        $db->delete('vartotojas', ['id' => $_POST['user_id']]);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>User management</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/user_managment.css">
</head>

<body>
    <h1>User management</h1>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>ID number</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Role</th>
                <th></th>
            </tr>
        </thead>
        <tbody> <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['vartotojo_vardas']) ?></td>
                    <td><?= htmlspecialchars($u['asmens_kodas']) ?></td>
                    <td><?= htmlspecialchars($u['vardas']) ?></td>
                    <td><?= htmlspecialchars($u['pavarde']) ?></td>
                    <td><?= htmlspecialchars($u['el_pastas']) ?></td>
                    <td><?= $rolemap[$u['tipas']] ?? 'unknown' ?></td>
                    <td class="no-bg"> 
                        <button class="edit-btn" data-id="<?= $u['id'] ?>" onclick="openModal(this)">Edit</button>
                    </td>
                </tr> <?php endforeach; ?>
        </tbody>
    </table> 
   
            <div id="userModal" class="modal">
    <div class="modal-content">
        <h3>Edit user</h3>

        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="user_id" id="user_id">

            <label>Username</label>
            <input type="text" name="username" id="username" required>

            <label>Name</label>
            <input type="text" name="vardas" id="name" required>

            <label>Surname</label>
            <input type="text" name="pavarde" id="surname" required>

            <label>Email</label>
            <input type="email" name="el_pastas" id="email" required>

            <label>Role</label>
            <select name="tipas" id="role">
                <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id'] ?>">
                        <?= htmlspecialchars($r['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <br><br>
            <button type="submit">Save</button>
            <button type="submit" name="action" value="delete" class="danger">Delete</button>
            <button type="button" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>


        <script>
function openModal(btn) {
    const row = btn.closest('tr');

    document.getElementById('user_id').value = btn.dataset.id;
    document.getElementById('username').value = row.children[0].innerText;
    document.getElementById('name').value = row.children[2].innerText;
    document.getElementById('surname').value = row.children[3].innerText;
    document.getElementById('email').value = row.children[4].innerText;

    document.getElementById('userModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('userModal').style.display = 'none';
}
</script>


</body>

</html>