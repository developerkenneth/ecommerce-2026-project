<?php

use App\Utilities\Helper;
use App\Model\User;

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {



    if (!isset($_POST['csrf_token']) || empty($_POST['csrf_token'])) {
        die("stop trying to hack our website... make satan no punish you");
    }
    // validate csrf token to prevent request forgery
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {

        die("stop trying to hack our website... make satan no punish you");
    }



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
        if (User::emailExist($email)) {
            $errors[] = "this email $email already exist";
        }

        // register user

        $registrationData = [
            'name' => $name,
            'password' => $password,
            'email' => $email
        ];

        try {
            User::create($registrationData);
            $success = "registration has been completed successfully";
            unset($_SESSION['csrf_token']);
        } catch (PDOException $error) {
            $errors[] = $error->getMessage();
        }
    }
}
