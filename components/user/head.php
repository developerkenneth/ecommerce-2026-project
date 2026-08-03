<?php

use App\Core\Auth;

session_start();

require_once("vendor/autoload.php");
Auth::loggedOutRedirect();

$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>seller <?= $pageTitle; ?></title>
</head>
<body>