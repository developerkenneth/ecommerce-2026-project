<?php
$pageTitle =  "Add Product";
require_once "components/user/head.php";

?>



<?php include_once "components/user/header.php" ?>
<link rel="stylesheet" href="./assets/css/add-product.css">
<!-- DASHBOARD -->
<section class="dashboard-container">


    <?php require_once "components/user/leftbar.php"; ?>
    <section class="add-product-page">




        <div class="breadcrumb-bar">

            <div class="breadcrumb">

                <a href="./dashboard.php">Dashboard</a>

                <span>/</span>

                <a href="./product.php">Products</a>

                <span>/</span>

                <strong>Add Product</strong>

            </div>

        </div>


        <!-- typwirter animation -->



        <form id="addProductForm" enctype="multipart/form-data">
            <!-- IMAGE SECTION -->
            <div class="form-card">

                <div class="card-title">

                    <i class="fa-solid fa-images"></i>

                    <div>

                        <h2>Product Images</h2>

                        <p>
                            Upload high quality images of your product..
                        </p>

                    </div>

                </div>

                <div class="upload-area" id="dropArea">

                    <input
                        type="file"
                        name="photos[]"
                        id="imageInput"
                        multiple
                        accept=".jpg,.jpeg,.png">

                    <i class="fa-solid fa-cloud-arrow-up"></i>

                    <h3>Drag & Drop Images</h3>

                    <p>
                        PNG • JPG
                    </p>


                </div>

                <div id="previewContainer" class="preview-images"></div>

            </div>

            </div>


            <!-- PRODUCT INFO -->

            <div class="form-card">

                <div class="card-title">

                    <i class="fa-solid fa-box-open"></i>

                    <div>

                        <h2>Product Details</h2>

                        <p>Basic information about your product.</p>

                    </div>

                </div>

                <div class="form-grid">

                    <div class="form-group">

                        <label>Product Name</label>

                        <input type="text" name="name" placeholder="Enter product name...">

                    </div>

                    <div class="form-group">

                        <label>Category</label>

                        <select name="category">

                            <option>Select Category</option>

                            <option>Electronics</option>
                            <option>Fashion</option>
                            <option>clothing</option>
                            <option>accessries</option>
                            <option>technologies</option>


                        </select>

                    </div>

                    <div class="form-group">

                        <label>Brand</label>

                        <input type="text" name="brand" placeholder="Enter product brand...">

                    </div>

                    <div class="form-group">

                        <label>Price (₦)</label>

                        <input type="number" name="price" placeholder="Enter product price...">

                    </div>

                    <div class="form-group">

                        <label>Discount (%)</label>

                        <input type="number" name="discount_percentage" placeholder="Enter product discount...">

                    </div>

                    <div class="form-group">

                        <label>Stock Quantity</label>

                        <input
                            type="number"
                            name="stocks_available"
                            placeholder="Enter stock...">

                    </div>

                </div>

                <!-- <div class="form-group">

                    <label>Short Description</label>

                    <textarea rows="3"></textarea>

                </div> -->

                <div class="form-group">

                    <label>Full Description</label>

                    <textarea rows="6" name="description" placeholder=" Enter a short discription.."></textarea>

                </div>

                <button type="submit" id="sumit-btn" >
                    Add Product
                </button>
                <div id="responseMessage"></div>

            </div>
            </div>

        </form>
    </section>

</section>

<script src="./assets/js/add-product.js"></script>
<?php include_once "./components/user/footer.php";
