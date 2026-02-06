<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Person.php';
require_once __DIR__ . '/partials/csrf.php';
require_once __DIR__ . '/partials/flash.php';

$db = (new Database())->getConnection();
$personModel = new Person($db);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify()) {
    header('Location: index.php');
    exit;
}

$backParams = [];
foreach (['page', 'search', 'sort', 'dir'] as $key) {
    if (isset($_POST[$key])) {
        $backParams[$key] = (string) $_POST[$key];
    }
}
$backUrl = 'index.php' . (!empty($backParams) ? ('?' . http_build_query($backParams)) : '');

if (!isset($_POST['id'])) {
    header('Location: ' . $backUrl);
    exit;
}

$id = (int) $_POST['id'];
$personModel->delete($id);

flash_set('status', 'Contact deleted successfully.', 'success');
header('Location: ' . $backUrl);
exit;
