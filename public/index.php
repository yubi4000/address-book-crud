<?php
require_once __DIR__ . '/../bootstrap.php';


// konekcija ka bazi
$db = (new Database())->getConnection();

// kreiramo model
$personModel = new Person($db);

$search = $_GET['search'] ?? '';

$allowedSorts = [
    'first_name',
    'last_name',
    'email',
    'phone_1'
];

$sort = $_GET['sort'] ?? 'first_name';
$dir  = $_GET['dir'] ?? 'asc';

if (!in_array($sort, $allowedSorts)) {
    $sort = 'first_name';
}

$dir = strtolower($dir) === 'desc' ? 'desc' : 'asc';

$nextDir = $dir === 'asc' ? 'desc' : 'asc';

$perPage = 10; // hits per page
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
$sortIcon = function (string $column) use ($sort, $dir): string {
    if ($sort !== $column) {
        return '';
    }

    $icon = $dir === 'asc' ? 'glyphicon-triangle-top' : 'glyphicon-triangle-bottom';
    return ' <span class="glyphicon ' . $icon . '"></span>';
};

require __DIR__ . '/partials/header.php';

?>

    <div class="container">
        <div class="row col-md-12 col-md-offset-0 mt-50">
            <?php $flash = flash_get('status'); ?>
            <?php if ($flash): ?>
                <div class="alert alert-<?= esc($flash['type']) ?>">
                    <?= esc($flash['message']) ?>
                </div>
            <?php endif; ?>
            <table class="table table-hover">
                <tr id="table-header">
                    <th><a href="?page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=first_name&dir=<?= $sort === 'first_name' ? $nextDir : 'asc' ?>">First Name<?= $sortIcon('first_name') ?></a></th>
                    <th><a href="?page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=last_name&dir=<?= $sort === 'last_name' ? $nextDir : 'asc' ?>">Last Name<?= $sortIcon('last_name') ?></a></th>
                    <th><a href="?page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=email&dir=<?= $sort === 'email' ? $nextDir : 'asc' ?>">Email<?= $sortIcon('email') ?></a></th>
                    <th><a href="?page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=phone_1&dir=<?= $sort === 'phone_1' ? $nextDir : 'asc' ?>">Phone<?= $sortIcon('phone_1') ?></a></th>
                    <th id="details_button" class="col-md-1"></th>
                </tr>

                <?php if (empty($persons)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No results found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($persons as $p): ?>
                    <tr>
                        <td><?= esc($p['first_name']) ?></td>
                        <td><?= esc($p['last_name']) ?></td>          
                        <td><?= esc(strtolower($p['email'] ?? '')) ?></td>
                        <td><?= esc($p['phone_1'] ?? '') ?></td>
                        <td class="text-center actions-inline">   
                            <a href="view.php?id=<?= $p['id'] ?>&page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>" class="btn btn-warning btn-sm">More Details</a>
                            <a href="edit.php?id=<?= $p['id'] ?>&page=<?= $currentPage ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>&dir=<?= urlencode($dir) ?>" class="btn btn-primary btn-sm">Edit</a>
                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                data-toggle="modal"
                                data-target="#deleteModal"
                                data-person-id="<?= (int) $p['id'] ?>"
                                data-person-name="<?= esc($p['first_name'] . ' ' . $p['last_name']) ?>"
                            >Delete</button>                           
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <?php render_pagination($currentPage, $totalPages, $search, $sort, $dir); ?>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="delete.php">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="deleteModalLabel">Delete Contact</h4>
                    </div>
                    <div class="modal-body">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" id="delete-person-id" value="">
                        <input type="hidden" name="page" value="<?= esc((string) $currentPage) ?>">
                        <input type="hidden" name="search" value="<?= esc((string) $search) ?>">
                        <input type="hidden" name="sort" value="<?= esc((string) $sort) ?>">
                        <input type="hidden" name="dir" value="<?= esc((string) $dir) ?>">
                        <p>Are you sure you want to delete <strong id="delete-person-name">this contact</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/partials/footer.php'; ?>
