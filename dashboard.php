<?php
session_start();
$user = $_SESSION['user'];

echo "welcome, $user->name";
