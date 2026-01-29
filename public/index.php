<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';
require_once __DIR__ . '/../classes/PersonDetails.php';

// konekcija ka bazi
$db = (new Database())->getConnection();

// kreiramo model
$personModel = new Person($db);

$detailsModel = new PersonDetails($db);

$rowsPerPage = 5; // koliko kontakata po stranici
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$totalRows = $personModel->getCount();
$totalPages = ceil($totalRows / $rowsPerPage);

$offset = ($currentPage - 1) * $rowsPerPage;
$persons = $personModel->getPaginatedWithDetails($rowsPerPage, $offset);

?>



<h1>All Persons</h1>
<a href="create.php">Add New Person</a>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Nickname</th>
        <th>City</th>
        <th>Email</th>
        <th>Actions</th> <!-- samo za person CRUD -->
    </tr>

    <?php foreach ($persons as $p):
        $details = $detailsModel->getByPersonId($p['id']);
    ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['first_name']) ?></td>
        <td><?= htmlspecialchars($p['last_name']) ?></td>
        <td><?= htmlspecialchars($p['nickname']) ?></td>
        <td><?= htmlspecialchars($p['city'] ?? '') ?></td>
        <td><?= htmlspecialchars($p['email'] ?? '') ?></td>
        <td>
            <a href="view.php?id=<?= $p['id'] ?>">See More</a>
            <a href="edit.php?id=<?= $p['id'] ?>">Edit</a>
            <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<div>
    <?php if ($currentPage > 1): ?>
        <a href="?page=<?= $currentPage - 1 ?>">&laquo; Previous</a>
    <?php endif; ?>

    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
        <?php if ($p === $currentPage): ?>
            <strong><?= $p ?></strong>
        <?php else: ?>
            <a href="?page=<?= $p ?>"><?= $p ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="?page=<?= $currentPage + 1 ?>">Next &raquo;</a>
    <?php endif; ?>
</div>