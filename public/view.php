<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';
require_once __DIR__ . '/../classes/PersonDetails.php';

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

?>
<?php
$pageTitle = 'Contact Details';
$activePage = 'view';
require __DIR__ . '/partials/header.php';
?>

    <div class="container">
        <div class="row col-md-10 col-md-offset-1 text-center">
            <div id="single-body" class="col-md-8 col-md-offset-2">	
                <h3><?= htmlspecialchars($person['first_name'] . ' ' . $person['last_name']) . ' (' . $person['nickname'] . ')'?></h3>

                <?php if ($details): ?>
                    <div class="col-md-8 col-md-offset-2">
                        <hr>
                        <h4>Address:</h4>
                        <?= htmlspecialchars($details['street'] . ' ' . $details['number']) ?></p>
                        <?= htmlspecialchars($details['city'] . ' ' . $details['zip_code']) ?></p>
                        <?= htmlspecialchars($details['country']) ?></p>
                        <hr>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <h4>Phone(s) and Email:</h4>
                    <?= htmlspecialchars(strtolower($details['email'])) ?></p>
                    <?= htmlspecialchars($details['phone_1']) ?></p>
                    <?= htmlspecialchars($details['phone_2']) ?></p>
                    </div>
                    
                <?php else: ?>
                    <p>No additional details available.</p>
                <?php endif; ?>
                                              
            </div><!-- single-body -->   
            <div class="row col-md-8 col-md-offset-2">
                <p>
                    <a href="index.php" class="btn btn-danger col-md-2 pull-left">Back</a>
                    <a href="edit.php?id=<?= $person['id'] ?>" class="btn btn-success col-md-2 pull-right">Edit</a>
                </p>
            </div>

        </div><!-- row -->
    </div><!-- container -->	

<?php require __DIR__ . '/partials/footer.php'; ?>
