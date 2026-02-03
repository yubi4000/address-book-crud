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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Details</title>

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
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row col-md-12 col-md-offset-0">
            <h1>Contact Details</h1>
            <p>
                <a href="index.php" class="btn btn-default btn-sm">Back to list</a>
                <a href="edit.php?id=<?= $person['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
            </p>

            <div class="well">
                <h2><?= htmlspecialchars($person['first_name'] . ' ' . $person['last_name']) ?></h2>
                <p><strong>Nickname:</strong> <?= htmlspecialchars($person['nickname']) ?></p>

                <?php if ($details): ?>
                    <p><strong>Street:</strong> <?= htmlspecialchars($details['street']) ?></p>
                    <p><strong>Number:</strong> <?= htmlspecialchars($details['number']) ?></p>
                    <p><strong>City:</strong> <?= htmlspecialchars($details['city']) ?></p>
                    <p><strong>Zip Code:</strong> <?= htmlspecialchars($details['zip_code']) ?></p>
                    <p><strong>Country:</strong> <?= htmlspecialchars($details['country']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($details['email']) ?></p>
                    <p><strong>Phone 1:</strong> <?= htmlspecialchars($details['phone_1']) ?></p>
                    <p><strong>Phone 2:</strong> <?= htmlspecialchars($details['phone_2']) ?></p>
                <?php else: ?>
                    <p>No additional details available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
