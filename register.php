<?php
$pageTitle = "register"

?>
<?php include_once "./components/guest/head.php" ?>
<!-- require controllers -->
<?php require_once "./controller/register.php" ?>

<div class="form-container">
    <h1>Create Account</h1>

    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" />

        <input type="email" name="email" placeholder="Email" />

        <input type="password" name="password" placeholder="Password" />

        <input type="password" name="confirm_password" placeholder="Password" />

        <button type="submit">Register</button>
    </form>
</div>

<!-- footer -->
<?php include_once "./components/guest/footer.php" ?>