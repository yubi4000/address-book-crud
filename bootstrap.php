<?php

// error reporting (dev only)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// autoload helpers
foreach (glob(__DIR__ . "/public/helpers/*.php") as $file) {
    require_once $file;
}

// load classes manually (for now)
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Person.php';
require_once __DIR__ . '/classes/PersonDetails.php';
