<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function flash_set(string $key, string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = [
        'key' => $key,
        'message' => $message,
        'type' => $type
    ];
}

function flash_get(string $key): ?array
{
    if (!isset($_SESSION['flash']) || $_SESSION['flash']['key'] !== $key) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}
