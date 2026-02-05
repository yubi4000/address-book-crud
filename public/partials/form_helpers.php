<?php

function render_person_form(array $formData, array $errors, string $submitLabel, string $backUrl = 'index.php', array $backParams = []): void
{
    require __DIR__ . '/person_form.php';
}

function render_contact_details_form(array $formData, array $errors): void
{
    require __DIR__ . '/contact_details_form.php';
}
