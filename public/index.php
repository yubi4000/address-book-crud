<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';

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

$sort = $_GET['sort'] ?? 'last_name';
$dir  = $_GET['dir'] ?? 'asc';

if (!in_array($sort, $allowedSorts)) {
    $sort = 'last_name';
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Address Book</title>

    <!-- Bootstrap 3 (CDN) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Address Book</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-main">
                <ul class="nav navbar-nav">
                    <li><a href="create.php">Add New Person</a></li>
                </ul>
                <form class="navbar-form navbar-left pull-right" method="get" action="" role="search">
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                    <input type="hidden" name="dir" value="<?= htmlspecialchars($dir) ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by name, email, city...">
                    </div>
                    <button type="submit" class="btn btn-warning">Search</button>
                </form>
            </div>
        </div>
    </nav>

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
                    <td><?= htmlspecialchars($p['email'] ?? '') ?></td>
                    <td>
                        <a href="view.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">See More</a>
                        <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-default btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <ul class="pager">
        <?php if ($currentPage > 1): ?>
            <li><a href="?page=<?= $currentPage - 1 ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>">&laquo; Prev</a></li>
        <?php endif; ?>

        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <?php if ($p === $currentPage): ?>
                <li class="active"><a href="#"><?= $p ?></a></li>
            <?php else: ?>
                <li><a href="?page=<?= $p ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>"><?= $p ?></a></li>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <li><a href="?page=<?= $currentPage + 1 ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>"> Next &raquo;</a></li>
        <?php endif; ?>
    </ul>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
