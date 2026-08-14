<?php

$pageTitle = "Edit Product";

require_once "components/user/head.php";
require_once "components/user/header.php";

?>

<link rel="stylesheet" href="./assets/css/add-product.css">

<section class="dashboard-container">

    <?php require_once "components/user/leftbar.php"; ?>

    <main class="add-product-page">

        <div class="breadcrumb-bar">

            <div class="breadcrumb">

                <a href="./dashboard.php">
                    Dashboard
                </a>

                <span>/</span>

                <a href="./index.php#products">
                    Products
                </a>

                <span>/</span>

                <strong>
                    Edit Product
                </strong>

            </div>

        </div>


        <div
            id="editLoading"
            class="edit-state">

            <i class="fa-solid fa-spinner fa-spin"></i>

            <span>
                Loading product...
            </span>

        </div>


        <div
            id="editError"
            class="edit-state edit-error">

            <i class="fa-solid fa-circle-exclamation"></i>

            <span id="editErrorMessage">
                Unable to load product.
            </span>

        </div>


        <form
            id="editProductForm"
            enctype="multipart/form-data"
            style="display:none;">


            <div class="form-card">

                <div class="card-title">

                    <i class="fa-solid fa-box-open"></i>

                    <div>

                        <h2>
                            Product Details
                        </h2>

                        <p>
                            Update your product information.
                        </p>

                    </div>

                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label for="editName">
                            Product Name
                        </label>

                        <input
                            id="editName"
                            type="text"
                            name="name">

                    </div>


                    <div class="form-group">

                        <label for="editCategory">
                            Category
                        </label>

                        <select
                            id="editCategory"
                            name="category">

                            <option value="">
                                Select Category
                            </option>

                            <option value="Electronics">
                                Electronics
                            </option>

                            <option value="Fashion">
                                Fashion
                            </option>

                            <option value="clothing">
                                Clothing
                            </option>

                            <option value="accessries">
                                Accessories
                            </option>

                            <option value="technologies">
                                Technologies
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label for="editBrand">
                            Brand
                        </label>

                        <input
                            id="editBrand"
                            type="text"
                            name="brand">

                    </div>


                    <div class="form-group">

                        <label for="editPrice">
                            Price (₦)
                        </label>

                        <input
                            id="editPrice"
                            type="number"
                            min="0.50"
                            step="0.01"
                            name="price">

                    </div>


                    <div class="form-group">

                        <label for="editDiscount">
                            Discount (%)
                        </label>

                        <input
                            id="editDiscount"
                            type="number"
                            min="0"
                            max="100"
                            name="discount_percentage">

                    </div>


                    <div class="form-group">

                        <label for="editStock">
                            Stock Quantity
                        </label>

                        <input
                            id="editStock"
                            type="number"
                            min="1"
                            name="stocks_available">

                    </div>

                </div>


                <div class="form-group">

                    <label for="editDescription">
                        Full Description
                    </label>

                    <textarea
                        id="editDescription"
                        rows="7"
                        name="description"></textarea>

                </div>


                <div
                    id="editResponseMessage"
                    class="edit-response">
                </div>


                <div class="edit-actions">

                    <a
                        href="./dashboard.php"
                        class="outline-btn">

                        Cancel

                    </a>


                    <button
                        type="submit"
                        class="save-btn"
                        id="updateProductBtn">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Save Changes

                    </button>

                </div>

            </div>

        </form>

    </main>

</section>

<script src="./assets/js/header.js"></script>
<script src="./assets/js/edit-product.js"></script>

<?php include_once "./components/user/footer.php"; ?>