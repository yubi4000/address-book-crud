<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';
require_once __DIR__ . '/partials/csrf.php';

// konekcija ka bazi
$db = (new Database())->getConnection();

// kreiramo model
$personModel = new Person($db);

$search = $_GET['search'] ?? '';

$allowedSorts = [
    'first_name',
    'last_name',
    'nickname',
    'city',
    'email'
];

$sort = $_GET['sort'] ?? 'first_name';
$dir  = $_GET['dir'] ?? 'asc';

if (!in_array($sort, $allowedSorts)) {
    $sort = 'first_name';
}

$dir = strtolower($dir) === 'desc' ? 'desc' : 'asc';

$nextDir = $dir === 'asc' ? 'desc' : 'asc';

$perPage = 5; // koliko kontakata po stranici
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$totalRows = $personModel->getCountWithSearch($search);
$totalPages = (int) ceil($totalRows / $perPage);

$offset = ($currentPage - 1) * $perPage;

$persons = $personModel->getPaginatedWithDetailsAndSearch(
    $search,
    $perPage,
    $offset,
    $sort,
    $dir
);

?>

<?php
$pageTitle = 'Address Book';
$activePage = 'index';
$showSearch = true;
require __DIR__ . '/partials/header.php';
require __DIR__ . '/partials/pagination.php';
?>

    <div class="container">
        <div class="row col-md-12 col-md-offset-0">
            <table class="table table-hover">
                <tr id="table-header">
                    <th><a href="?page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=first_name&dir=<?= $sort === 'first_name' ? $nextDir : 'asc' ?>">First Name</a></th>
                    <th><a href="?page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=last_name&dir=<?= $sort === 'last_name' ? $nextDir : 'asc' ?>">Last Name</a></th>
                    <th><a href="?page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=nickname&dir=<?= $sort === 'nickname' ? $nextDir : 'asc' ?>">Nickname</a></th>
                    <th><a href="?page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=city&dir=<?= $sort === 'city' ? $nextDir : 'asc' ?>">City</a></th>
                    <th><a href="?page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=email&dir=<?= $sort === 'email' ? $nextDir : 'asc' ?>">Email</a></th>
                    <th id="details_button" class="col-md-1">Actions</th>
                </tr>

                <?php foreach ($persons as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['first_name']) ?></td>
                    <td><?= htmlspecialchars($p['last_name']) ?></td>
                    <td><?= htmlspecialchars($p['nickname']) ?></td>
                    <td><?= htmlspecialchars($p['city'] ?? '') ?></td>
                    <td><?= htmlspecialchars(strtolower($p['email'] ?? '')) ?></td>
                    <td>
                        <a href="view.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">See More</a>
                        <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-default btn-sm">Edit</a>
                        <form method="post" action="delete.php" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <?php render_pagination($currentPage, $totalPages, $search, $sort, $dir); ?>

<?php require __DIR__ . '/partials/footer.php'; ?>
