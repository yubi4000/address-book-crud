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
<?php
$pageTitle = 'Add New Person';
$activePage = 'create';
require __DIR__ . '/partials/header.php';
?>

    <div class="container">
        <div class="row col-md-12 col-md-offset-0">
            <h1>Add New Person</h1>
            <form method="post">
                <div class="form-group">
                    <label>First Name: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($insertedData['first_name'] ?? '') ?>">
                    <?php if (isset($errors['first_name'])): ?>
                        <p class="text-danger"><?= $errors['first_name'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Last Name: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($insertedData['last_name'] ?? '') ?>">
                    <?php if (isset($errors['last_name'])): ?>
                        <p class="text-danger"><?= $errors['last_name'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Nickname:</label>
                    <input type="text" class="form-control" name="nickname" value="<?= htmlspecialchars($insertedData['nickname'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Street:</label>
                    <input type="text" class="form-control" name="street" value="<?= htmlspecialchars($insertedData['street'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Number:</label>
                    <input type="text" class="form-control" name="number" value="<?= htmlspecialchars($insertedData['number'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>City:</label>
                    <input type="text" class="form-control" name="city" value="<?= htmlspecialchars($insertedData['city'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Zip Code:</label>
                    <input type="text" class="form-control" name="zip_code" value="<?= htmlspecialchars($insertedData['zip_code'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Country:</label>
                    <input type="text" class="form-control" name="country" value="<?= htmlspecialchars($insertedData['country'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Email: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="email" value="<?= htmlspecialchars(strtolower($insertedData['email'] ?? '')) ?>">
                    <?php if (isset($errors['email'])): ?>
                        <p class="text-danger"><?= $errors['email'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Phone 1:</label>
                    <input type="text" class="form-control" name="phone_1" value="<?= htmlspecialchars($insertedData['phone_1'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Phone 2:</label>
                    <input type="text" class="form-control" name="phone_2" value="<?= htmlspecialchars($insertedData['phone_2'] ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-warning">Save</button>
                <a href="index.php" class="btn btn-default">Back to list</a>
            </form>
        </div>
    </div>

<?php require __DIR__ . '/partials/footer.php'; ?>
