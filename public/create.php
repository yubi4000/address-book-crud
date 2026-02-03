<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
$formData = [
    'first_name' => '',
    'last_name'  => '',
    'nickname'   => '',
    'street'     => '',
    'number'     => '',
    'city'       => '',
    'zip_code'   => '',
    'country'    => '',
    'email'      => '',
    'phone_1'    => '',
    'phone_2'    => ''
];

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

    $formData = array_merge($personInput, $detailsInput);

    $errors = validate_contact($personInput, $detailsInput);

    if (!csrf_verify()) {
        $errors['csrf'] = 'Invalid form submission. Please try again.';
    }

    if (empty($errors)) {

        $personId = $personModel->create([

            'first_name' => $personInput['first_name'],
            'last_name'  => $personInput['last_name'],
            'nickname'   => $personInput['nickname']

        ]);

        $detailsModel->create($personId, [
            
            'street'   => $detailsInput['street'],
            'number'   => $detailsInput['number'],
            'city'     => $detailsInput['city'],
            'zip_code' => $detailsInput['zip_code'],
            'country'  => $detailsInput['country'],
            'email'    => $detailsInput['email'],
            'phone_1'  => $detailsInput['phone_1'],
            'phone_2'  => $detailsInput['phone_2']

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
            <?php render_person_form($formData, $errors, 'Save'); ?>
        </div>
    </div>

<?php require __DIR__ . '/partials/footer.php'; ?>
