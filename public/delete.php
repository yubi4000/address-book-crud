<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';

$db = (new Database())->getConnection();
$personModel = new Person($db);

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];
$personModel->delete($id);

header('Location: index.php');
exit;
