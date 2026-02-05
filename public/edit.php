<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';
require_once __DIR__ . '/../classes/PersonDetails.php';
require_once __DIR__ . '/partials/csrf.php';
require_once __DIR__ . '/partials/flash.php';
require_once __DIR__ . '/partials/validation.php';
require_once __DIR__ . '/partials/form_helpers.php';

$db = (new Database())->getConnection();

$personModel = new Person($db);
$detailsModel = new PersonDetails($db);
$errors = [];

// proveri da li imamo ID u GET
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];

// POST: update osobe
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

    $errors = validate_contact($personInput, $detailsInput);

    if (!csrf_verify()) {
        $errors['csrf'] = 'Invalid form submission. Please try again.';
    }

    if (empty($errors)) {
        $data = [
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'nickname'   => $nickname,
        ];

        $personModel->update($id, $data);

        $detailsData = [
            'street'   => $street,
            'number'   => $number,
            'city'     => $city,
            'zip_code' => $zipCode,
            'country'  => $country,
            'email'    => $normalizedEmail,
            'phone_1'  => $phone1,
            'phone_2'  => $phone2,
        ];

        $detailsModel->update($id, $detailsData);

        flash_set('status', 'Contact updated successfully.', 'success');
        header('Location: index.php');
        exit;
    }
}

    // GET: učitaj podatke osobe
    $person = $personModel->getById($id);
    if (!$person) {
        echo "Person not found";
        exit;
    }

$details = $detailsModel->getByPersonId($id);

if (!empty($errors) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $person['first_name'] = $firstName;
    $person['last_name'] = $lastName;
    $person['nickname'] = $nickname;
    $details['street'] = $street;
    $details['number'] = $number;
    $details['city'] = $city;
    $details['zip_code'] = $zipCode;
    $details['country'] = $country;
    $details['email'] = $normalizedEmail;
    $details['phone_1'] = $phone1;
    $details['phone_2'] = $phone2;
}


?>
<?php
    $pageTitle = 'Edit Person';
    $activePage = 'edit';
    require __DIR__ . '/partials/header.php';
?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 mt-50">
                <?php if (isset($errors['csrf'])): ?>
                    <p class="text-danger"><?= $errors['csrf'] ?></p>
                <?php endif; ?>
                
                <?php
                $formData = array_merge($person, $details ?? []);
                render_person_form($formData, $errors, 'Update');
                ?>
            </div>
        </div><!-- row -->       
    </div><!-- container --> 

<?php require __DIR__ . '/partials/footer.php'; ?>
