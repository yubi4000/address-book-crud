<?php

function validate_contact(array $personInput, array $detailsInput): array
{
    $errors = [];

    if (($personInput['first_name'] ?? '') === '') {
        $errors['first_name'] = 'First name is required';
    }

    if (($personInput['last_name'] ?? '') === '') {
        $errors['last_name'] = 'Last name is required';
    }

    $email = $detailsInput['email'] ?? '';
    if ($email === '') {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    $phone1 = $detailsInput['phone_1'] ?? '';
    if ($phone1 === '') {
        $errors['phone_1'] = 'Phone 1 is required';
    } elseif (!ctype_digit($phone1)) {
        $errors['phone_1'] = 'Phone 1 must be numeric';
    }

    $zipCode = $detailsInput['zip_code'] ?? '';
    if ($zipCode === '') {
        $errors['zip_code'] = 'Zip code is required';
    } elseif (!ctype_digit($zipCode)) {
        $errors['zip_code'] = 'Zip code must be numeric';
    }

    $phone2 = $detailsInput['phone_2'] ?? '';
    if ($phone2 !== '' && !ctype_digit($phone2)) {
        $errors['phone_2'] = 'Phone 2 must be numeric';
    }

    return $errors;
}
