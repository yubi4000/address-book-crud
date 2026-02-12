<?php

require_once __DIR__ . '/../bootstrap.php';

$db = (new Database())->getConnection();
$personModel = new Person($db);
$detailsModel = new PersonDetails($db);

// Proveri ID
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];

// fetch the Person data
$person = $personModel->getById($id);

if (!$person) {
    echo "Person not found";
    exit;
}

// fetch the details
$details = $detailsModel->getByPersonId($id);

$backParams = [];
if (isset($_GET['page'])) {
    $backParams['page'] = (int) $_GET['page'];
}
if (isset($_GET['search'])) {
    $backParams['search'] = (string) $_GET['search'];
}
if (isset($_GET['sort'])) {
    $backParams['sort'] = (string) $_GET['sort'];
}
if (isset($_GET['dir'])) {
    $backParams['dir'] = (string) $_GET['dir'];
}
$backUrl = 'index.php' . (!empty($backParams) ? ('?' . http_build_query($backParams)) : '');
$editUrl = 'edit.php?id=' . $person['id'] . (!empty($backParams) ? ('&' . http_build_query($backParams)) : '');

?>
<?php
$pageTitle = 'Contact Details';
$activePage = 'view';
require __DIR__ . '/partials/header.php';
?>

    <div class="container">
        <div class="row col-md-10 col-md-offset-1 text-center">
            <div id="single-body" class="col-md-8 col-md-offset-2 mt-50">	
                <h3><?= esc($person['first_name'] . ' ' . $person['last_name']);
                    if(!empty($person['nickname'])) {
                        echo " (" . $person['nickname'] . ")";
                    }?>
                </h3>

                <?php if ($details): ?>
                    <div class="col-md-8 col-md-offset-2">
                        <hr>
                        <h4>Address:</h4>
                        <?= esc($details['street'] . ' ' . $details['number']) ?></p>
                        <?= esc($details['city'] . ' ' . $details['zip_code']) ?></p>
                        <?= esc($details['country']) ?></p>
                        <hr>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <h4>Email and Phone(s):</h4>
                    <?= esc(strtolower($details['email'])) ?></p>
                    <?= esc($details['phone_1']) ?></p>
                    <?= esc($details['phone_2']) ?></p>
                    </div>
                    
                <?php else: ?>
                    <p>No additional details available.</p>
                <?php endif; ?>
                                              
            </div><!-- single-body -->   
            <div class="row col-md-8 col-md-offset-2">
                <p>
                    <a href="<?= esc($backUrl) ?>" class="btn btn-danger col-md-2 pull-left">Back</a>
                    <a href="<?= esc($editUrl) ?>" class="btn btn-success col-md-2 pull-right">Edit</a>
                </p>
            </div>

        </div><!-- row -->
    </div><!-- container -->	

<?php require __DIR__ . '/partials/footer.php'; ?>
