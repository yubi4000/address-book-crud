<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';

$db = (new Database())->getConnection();
$personModel = new Person($db);

// ako je forma submitovana
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'first_name' => $_POST['first_name'] ?? '',
        'last_name'  => $_POST['last_name'] ?? '',
        'nickname'   => $_POST['nickname'] ?? '',
    ];

    $personModel->create($data);
    header('Location: index.php');
    exit;
}
?>

<h1>Add New Person</h1>
<form method="post">
    <label>First Name:</label><br>
    <input type="text" name="first_name" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" required><br><br>

    <label>Nickname:</label><br>
    <input type="text" name="nickname"><br><br>

    <button type="submit">Save</button>
</form>

<a href="index.php">Back to list</a>