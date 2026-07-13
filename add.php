<?php
$pageTitle =  "Add Product";
require_once "components/user/head.php";

?>



<?php include_once "components/user/header.php" ?>
<!-- DASHBOARD -->
<section class="dashboard-container">


    <?php require_once "components/user/leftbar.php"; ?>
    <!-- RIGHT CONTENT -->
    <div class="dashboard-content">
        <h1>Add a Product </h1>
        <form action="" method="post">

            <div class="form-group">
                <label for="">Product name</label>
                <input type="text">
            </div>


            <div class="form-group">
                <label for="">Price (Naira)</label>
                <input type="text">
            </div>


            <div class="form-group">
                <label for="">Tags</label>
                <input type="text">
            </div>


            <div class="form-group">
                <label for="">Brand</label>
                <input type="text">
            </div>



            <div class="form-group">
                <label for="">Description</label>
                <textarea name="" id=""></textarea>
            </div>
        </form>
    </div>

</section>

<?php include_once "./components/user/footer.php";
