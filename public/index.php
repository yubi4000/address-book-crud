<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';

// konekcija ka bazi
$db = (new Database())->getConnection();

// kreiramo model
$personModel = new Person($db);

// dohvat svih osoba
$persons = $personModel->getAll();
?>

<h1>All Persons</h1>
<a href="create.php">Add New Person</a>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Nickname</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($persons as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['first_name']) ?></td>
            <td><?= htmlspecialchars($p['last_name']) ?></td>
            <td><?= htmlspecialchars($p['nickname']) ?></td>
            <td>
                <a href="edit.php?id=<?= $p['id'] ?>">Edit</a>
                <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>