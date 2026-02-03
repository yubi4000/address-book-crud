<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';
require_once __DIR__ . '/../classes/PersonDetails.php';
require_once __DIR__ . '/partials/csrf.php';
require_once __DIR__ . '/partials/flash.php';

$db = (new Database())->getConnection();

$personModel = new Person($db);
$detailsModel = new PersonDetails($db);

$errors = [];
$insertedData = [];

// ako je forma submitovana
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $personInput = $personModel->normalizeInput([
        'first_name' => $_POST['first_name'] ?? '',
        'last_name'  => $_POST['last_name'] ?? '',
        'nickname'   => $_POST['nickname'] ?? ''
    ]);

    $detailsInput = $detailsModel->normalizeInput([
        'street'   => $_POST['street'] ?? '',
        'number'   => $_POST['number'] ?? '',
        'city'     => $_POST['city'] ?? '',
        'zip_code' => $_POST['zip_code'] ?? '',
        'country'  => $_POST['country'] ?? '',
        'email'    => $_POST['email'] ?? '',
        'phone_1'  => $_POST['phone_1'] ?? '',
        'phone_2'  => $_POST['phone_2'] ?? ''
    ]);

    $firstName = $personInput['first_name'];
    $lastName = $personInput['last_name'];
    $nickname = $personInput['nickname'];
    $street = $detailsInput['street'];
    $number = $detailsInput['number'];
    $city = $detailsInput['city'];
    $zipCode = $detailsInput['zip_code'];
    $country = $detailsInput['country'];
    $normalizedEmail = $detailsInput['email'];
    $phone1 = $detailsInput['phone_1'];
    $phone2 = $detailsInput['phone_2'];

    $insertedData = [
        'first_name' => $firstName,
        'last_name'  => $lastName,
        'nickname'   => $nickname,
        'street'     => $street,
        'number'     => $number,
        'city'       => $city,
        'zip_code'   => $zipCode,
        'country'    => $country,
        'email'      => $normalizedEmail,
        'phone_1'    => $phone1,
        'phone_2'    => $phone2,
    ];

    if (!csrf_verify()) {
        $errors['csrf'] = 'Invalid form submission. Please try again.';
    }

    // required fields error messages
    if ($firstName === '') {
        $errors['first_name'] = 'First name is required';
    }

    if ($lastName === '') {
        $errors['last_name'] = 'Last name is required';
    }

    if ($normalizedEmail === '') {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($normalizedEmail, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if ($phone1 === '') {
        $errors['phone_1'] = 'Phone 1 is required';
    } elseif (!ctype_digit($phone1)) {
        $errors['phone_1'] = 'Phone 1 must be numeric';
    }

    if ($zipCode === '') {
        $errors['zip_code'] = 'Zip code is required';
    } elseif (!ctype_digit($zipCode)) {
        $errors['zip_code'] = 'Zip code must be numeric';
    }

    if ($phone2 !== '' && !ctype_digit($phone2)) {
        $errors['phone_2'] = 'Phone 2 must be numeric';
    }

    if (empty($errors)) {

        $personId = $personModel->create([

            'first_name' => $firstName,
            'last_name'  => $lastName,
            'nickname'   => $nickname

        ]);

        $detailsModel->create($personId, [
            
            'street'   => $street,
            'number'   => $number,
            'city'     => $city,
            'zip_code' => $zipCode,
            'country'  => $country,
            'email'    => $normalizedEmail,
            'phone_1'  => $phone1,
            'phone_2'  => $phone2

        ]);

        flash_set('status', 'Contact created successfully.', 'success');
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
            <p class="text-muted"><span class="text-danger">*</span> Required fields</p>
            <?php if (isset($errors['csrf'])): ?>
                <p class="text-danger"><?= $errors['csrf'] ?></p>
            <?php endif; ?>
            <form method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label>First Name: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($insertedData['first_name'] ?? '') ?>" required>
                    <?php if (isset($errors['first_name'])): ?>
                        <p class="text-danger"><?= $errors['first_name'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Last Name: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($insertedData['last_name'] ?? '') ?>" required>
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
                    <input type="text" class="form-control" name="number" value="<?= htmlspecialchars($insertedData['number'] ?? '') ?>" inputmode="numeric" pattern="[0-9]+" title="Numbers only">
                </div>

                <div class="form-group">
                    <label>City:</label>
                    <input type="text" class="form-control" name="city" value="<?= htmlspecialchars($insertedData['city'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Zip Code: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="zip_code" value="<?= htmlspecialchars($insertedData['zip_code'] ?? '') ?>" required inputmode="numeric" pattern="[0-9]+" title="Numbers only">
                    <?php if (isset($errors['zip_code'])): ?>
                        <p class="text-danger"><?= $errors['zip_code'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Country:</label>
                    <input type="text" class="form-control" name="country" value="<?= htmlspecialchars($insertedData['country'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Email: <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars(strtolower($insertedData['email'] ?? '')) ?>" required>
                    <?php if (isset($errors['email'])): ?>
                        <p class="text-danger"><?= $errors['email'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Phone 1: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="phone_1" value="<?= htmlspecialchars($insertedData['phone_1'] ?? '') ?>" required inputmode="numeric" pattern="[0-9]+" title="Numbers only">
                    <?php if (isset($errors['phone_1'])): ?>
                        <p class="text-danger"><?= $errors['phone_1'] ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Phone 2:</label>
                    <input type="text" class="form-control" name="phone_2" value="<?= htmlspecialchars($insertedData['phone_2'] ?? '') ?>" inputmode="numeric" pattern="[0-9]+" title="Numbers only">
                    <?php if (isset($errors['phone_2'])): ?>
                        <p class="text-danger"><?= $errors['phone_2'] ?></p>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-warning">Save</button>
                <a href="index.php" class="btn btn-default">Back to list</a>
            </form>
        </div>
    </div>

<?php require __DIR__ . '/partials/footer.php'; ?>
