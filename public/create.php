<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';
require_once __DIR__ . '/../classes/PersonDetails.php';

$db = (new Database())->getConnection();

$personModel = new Person($db);
$detailsModel = new PersonDetails($db);

$errors = [];
$insertedData = [];

// ako je forma submitovana
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $insertedData = $_POST;

    // required fields error messages
    if (empty($_POST['first_name'])) {
        $errors['first_name'] = 'First name is required';
    }

    if (empty($_POST['last_name'])) {
        $errors['last_name'] = 'Last name is required';
    }

    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if (empty($errors)) {

        $personId = $personModel->create([

            'first_name' => $_POST['first_name'],
            'last_name'  => $_POST['last_name'],
            'nickname'   => $_POST['nickname'] ?? ''

        ]);

        $detailsModel->create($personId, [
            
            'street'   => $_POST['street'] ?? '',
            'number'   => $_POST['number'] ?? '',
            'city'     => $_POST['city'] ?? '',
            'zip_code' => $_POST['zip_code'] ?? '',
            'country'  => $_POST['country'] ?? '',
            'email'    => $_POST['email'],
            'phone_1'  => $_POST['phone_1'] ?? '',
            'phone_2'  => $_POST['phone_2'] ?? ''

        ]);

        header('Location: index.php');
        exit;
    }
}

?>

<h1>Add New Person</h1>
<form method="post">
    <label>First Name:<span style="color:red">*</span></label><br>
    <input type="text" name="first_name" value="<?= htmlspecialchars($insertedData['first_name'] ?? '') ?>"><br><br>
    <?php if (isset($errors['first_name'])): ?>
        <div style="color:red">
            <?= $errors['first_name'] ?>
        </div>
    <?php endif; ?>


    <label>Last Name:<span style="color:red">*</span></label><br>
    <input type="text" name="last_name" value="<?= htmlspecialchars($insertedData['last_name'] ?? '') ?>"><br><br>
        <?php if (isset($errors['last_name'])): ?>
        <div style="color:red">
            <?= $errors['last_name'] ?>
        </div>
    <?php endif; ?>

    <label>Nickname:</label><br>
    <input type="text" name="nickname" value="<?= htmlspecialchars($insertedData['nickname'] ?? '') ?>"><br><br>

    <label>Street:</label><br>
    <input type="text" name="street" value="<?= htmlspecialchars($insertedData['street'] ?? '') ?>"><br><br>

    <label>Number:</label><br>
    <input type="text" name="number" value="<?= htmlspecialchars($insertedData['number'] ?? '') ?>"><br><br>

    <label>City:</label><br>
    <input type="text" name="city" value="<?= htmlspecialchars($insertedData['city'] ?? '') ?>"><br><br>

    <label>Zip Code:</label><br>
    <input type="text" name="zip_code" value="<?= htmlspecialchars($insertedData['zip_code'] ?? '') ?>"><br><br>

    <label>Country:</label><br>
    <input type="text" name="country" value="<?= htmlspecialchars($insertedData['country'] ?? '') ?>"><br><br>

    <label>Email:<span style="color:red">*</span></label><br>
    <input type="text" name="email" value="<?= htmlspecialchars($insertedData['email'] ?? '') ?>"><br><br>
    <?php if (isset($errors['email'])): ?>
        <div style="color:red">
            <?= $errors['email'] ?>
        </div>
    <?php endif; ?>        

    <label>Phone 1:</label><br>
    <input type="text" name="phone_1" value="<?= htmlspecialchars($insertedData['phone_1'] ?? '') ?>"><br><br>

    <label>Phone 2:</label><br>
    <input type="text" name="phone_2" value="<?= htmlspecialchars($insertedData['phone_2'] ?? '') ?>"><br><br>

    <button type="submit">Save</button>
</form>

<a href="index.php">Back to list</a>