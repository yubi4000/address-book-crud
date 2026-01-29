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

<h1>Edit Person</h1>
<form method="post">
    <label>First Name:</label><br>
    <input type="text" name="first_name" value="<?= htmlspecialchars($person['first_name']) ?>" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" value="<?= htmlspecialchars($person['last_name']) ?>" required><br><br>

    <label>Nickname:</label><br>
    <input type="text" name="nickname" value="<?= htmlspecialchars($person['nickname']) ?>"><br><br>

    <h3>Contact Details</h3>
    <label>Street:</label><br>
    <input type="text" name="street" value="<?= htmlspecialchars($details['street'] ?? '') ?>"><br><br>

    <label>Number:</label><br>
    <input type="text" name="number" value="<?= htmlspecialchars($details['number'] ?? '') ?>"><br><br>

    <label>City:</label><br>
    <input type="text" name="city" value="<?= htmlspecialchars($details['city'] ?? '') ?>"><br><br>

    <label>Zip Code:</label><br>
    <input type="text" name="zip_code" value="<?= htmlspecialchars($details['zip_code'] ?? '') ?>"><br><br>

    <label>Country:</label><br>
    <input type="text" name="country" value="<?= htmlspecialchars($details['country'] ?? '') ?>"><br><br>

    <label>Email:</label><br>
    <input type="text" name="email" value="<?= htmlspecialchars($details['email'] ?? '') ?>"><br><br>

    <label>Phone 1:</label><br>
    <input type="text" name="phone_1" value="<?= htmlspecialchars($details['phone_1'] ?? '') ?>"><br><br>

    <label>Phone 2:</label><br>
    <input type="text" name="phone_2" value="<?= htmlspecialchars($details['phone_2'] ?? '') ?>"><br><br>
    
    <button type="submit">Update</button>
</form>

<a href="index.php">Back to list</a>