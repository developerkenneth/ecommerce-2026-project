<?php
require_once __DIR__ . "/vendor/autoload.php";

use App\Utilities\Helper;

$pageTitle = "register";

?>
<?php include_once "./components/guest/head.php" ?>
<!-- require controllers -->
<?php require_once "./controller/register.php" ?>

<div class="form-container">
    <h1>Create Account</h1>


    <?php if (!empty($errors)) : ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
        <div class="success">
            <p><?= $success ?> <a href="./login.php">click here to login</a></p>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <input type="text" name="name" value="<?= Helper::getOld("name"); ?>" placeholder="Name" />

        <input type="email" value="<?= Helper::getOld("email"); ?>" name="email" placeholder="Email" />

        <input type="password" name="password" placeholder="Password" />

        <input type="password" name="confirm_password" placeholder="Confirm Password" />

        <button type="submit">Register</button>
    </form>
</div>

<!-- footer -->
<?php include_once "./components/guest/footer.php" ?>