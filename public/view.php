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

<h1>Contact Details</h1>
<a href="index.php">Back to list</a>

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
