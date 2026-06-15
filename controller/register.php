<?php

include_once "./src/Utilities/Helper.php";

use App\Utilities\Helper;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // sanitization
    $name = Helper::sanitize($_POST['username']);
    $email = Helper::sanitize($_POST['email']);
    $password = Helper::sanitize($_POST['password']);
    $confirmPassword = Helper::sanitize($_POST['confirm_password']);


    $required_fields = ['username', 'email', 'password', 'confirm_password'];

    // validation for empty fields
    foreach ($_POST as $field => $value) {
        if (in_array($field, $required_fields) && empty($value)) {
            $errors[] = "$field is required";
        }
    }

    if (!empty($errors)) {
        print_r($errors);
    } else {
        echo "no error found";
    }
}
