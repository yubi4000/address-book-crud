<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';
require_once __DIR__ . '/../classes/PersonDetails.php';

$db = (new Database())->getConnection();

$personModel = new Person($db);
$detailsModel = new PersonDetails($db);

// proveri da li imamo ID u GET
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];

// POST: update osobe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $data = [
        'first_name' => $_POST['first_name'] ?? '',
        'last_name'  => $_POST['last_name'] ?? '',
        'nickname'   => $_POST['nickname'] ?? '',
    ];

    $personModel->update($id, $data);

    $detailsData = [
        'street'   => $_POST['street'] ?? '',
        'number'   => $_POST['number'] ?? '',
        'city'     => $_POST['city'] ?? '',
        'zip_code' => $_POST['zip_code'] ?? '',
        'country'  => $_POST['country'] ?? '',
        'email'    => $_POST['email'] ?? '',
        'phone_1'  => $_POST['phone_1'] ?? '',
        'phone_2'  => $_POST['phone_2'] ?? '',
    ];

    $detailsModel->update($id, $detailsData);

    header('Location: index.php');
    exit;
}

    // GET: učitaj podatke osobe
    $person = $personModel->getById($id);
    if (!$person) {
        echo "Person not found";
        exit;
    }

$details = $detailsModel->getByPersonId($id);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Person</title>

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
            <h1>Edit Person</h1>
            <form method="post">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($person['first_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($person['last_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Nickname:</label>
                    <input type="text" class="form-control" name="nickname" value="<?= htmlspecialchars($person['nickname']) ?>">
                </div>

                <h3>Contact Details</h3>
                <div class="form-group">
                    <label>Street:</label>
                    <input type="text" class="form-control" name="street" value="<?= htmlspecialchars($details['street'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Number:</label>
                    <input type="text" class="form-control" name="number" value="<?= htmlspecialchars($details['number'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>City:</label>
                    <input type="text" class="form-control" name="city" value="<?= htmlspecialchars($details['city'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Zip Code:</label>
                    <input type="text" class="form-control" name="zip_code" value="<?= htmlspecialchars($details['zip_code'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Country:</label>
                    <input type="text" class="form-control" name="country" value="<?= htmlspecialchars($details['country'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" class="form-control" name="email" value="<?= htmlspecialchars($details['email'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Phone 1:</label>
                    <input type="text" class="form-control" name="phone_1" value="<?= htmlspecialchars($details['phone_1'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Phone 2:</label>
                    <input type="text" class="form-control" name="phone_2" value="<?= htmlspecialchars($details['phone_2'] ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-warning">Update</button>
                <a href="index.php" class="btn btn-default">Back to list</a>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
