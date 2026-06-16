<?php

include_once "./src/Utilities/Helper.php";

use App\Utilities\Helper;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // sanitization
    $name = Helper::sanitize($_POST['name']);
    $email = Helper::sanitize($_POST['email']);
    $password = Helper::sanitize($_POST['password']);
    $confirmPassword = Helper::sanitize($_POST['confirm_password']);


    $required_fields = ['name', 'email', 'password', 'confirm_password'];

    // validation for empty fields
    foreach ($_POST as $field => $value) {
        if (in_array($field, $required_fields) && empty($value)) {
            if ($field == "confirm_password") {
                $field = "confirm password";
            }
            $errors[] = "$field is required";
        }
    }

    if (empty($errors)) {

        // email validation

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "please enter a valid email";
        }

        if (strlen($password) < 6) {
            $errors[] = "password must be at least 6 characters long";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "password does not match";
        }

        // checked if email already exist in database 

    }
}
