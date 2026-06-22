<?php

use App\Core\Auth;
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
    $email = Helper::sanitize($_POST['email']);
    $password = Helper::sanitize($_POST['password']);



    $required_fields = ['email', 'password'];

    // validation for empty fields
    foreach ($_POST as $field => $value) {
        if (in_array($field, $required_fields) && empty($value)) {
            $errors[] = "$field is required";
        }
    }

    if (empty($errors)) {


        // email validation

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "please enter a valid email";
        }
        if (!User::emailExist($email)) {
            $errors[] = "invalid credentials.";
        } else {

            $user = User::findUserByEmail($email);

            if (!Helper::verifyPassword($password, $user->password)) {
                $errors[] = "invalid credentials";
            }

            if (empty($errors)) {
                // login user
                if (Auth::login($user)) {
                    // redirecct user to the dashboard
                    header(("Location:dashboard.php"));
                    exit();
                } else {;
                    $errors[] = "failed to login user... please try again";
                }
            }
        }
    }
}
