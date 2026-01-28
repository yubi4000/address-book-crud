<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';

$db = (new Database())->getConnection();
$personModel = new Person($db);

// proveri da li imamo ID u GET
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

// POST: update osobe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'first_name' => $_POST['first_name'] ?? '',
        'last_name'  => $_POST['last_name'] ?? '',
        'nickname'   => $_POST['nickname'] ?? '',
    ];

    $personModel->update($id, $data);
    header('Location: index.php');
    exit;
}

// GET: učitaj podatke osobe
$person = $personModel->getById($id);
if (!$person) {
    echo "Person not found";
    exit;
}
?>

<h1>Edit Person</h1>
<form method="post">
    <label>First Name:</label><br>
    <input type="text" name="first_name" value="<?= htmlspecialchars($person['first_name']) ?>" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" value="<?= htmlspecialchars($person['last_name']) ?>" required><br><br>

    <label>Nickname:</label><br>
    <input type="text" name="nickname" value="<?= htmlspecialchars($person['nickname']) ?>"><br><br>

    <button type="submit">Update</button>
</form>

<a href="index.php">Back to list</a>