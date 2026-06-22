<?php

use App\Core\Session;

session_start();
require_once __DIR__ . "/vendor/autoload.php";
$pageTitle = "Login";


if (!isset($_SESSION['csrf_token']) && !empty($_SESSION['csrf_token'])) {
    Session::csrf();
}

?>
<?php include_once "./components/guest/head.php" ?>

<?php require_once "controller/login.php"; ?>

<div class="form-container">
    <h1>Login</h1>

    <?php if (!empty($errors)) : ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <input type="email" name="email" placeholder="Enter Email" required />

        <input
            type="password"
            name="password"
            placeholder="Enter Password"

            required />

        <input type="hidden" value="<?= $_SESSION['csrf_token'] ?>" name="csrf_token">

        <button type="submit">Login</button>
    </form>
</div>

<!-- footer -->
<?php include_once "./components/guest/footer.php" ?>