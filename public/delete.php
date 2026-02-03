<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';
require_once __DIR__ . '/partials/csrf.php';

$db = (new Database())->getConnection();
$personModel = new Person($db);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify()) {
    header('Location: index.php');
    exit;
}

if (!isset($_POST['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_POST['id'];
$personModel->delete($id);

header('Location: index.php');
exit;
