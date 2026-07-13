<?php
$pageTitle =  "Dasboard";
require_once "components/user/head.php";

?>



<?php include_once "components/user/header.php" ?>
<!-- DASHBOARD -->
<section class="dashboard-container">


    <?php require_once "components/user/leftbar.php"; ?>
    <!-- RIGHT CONTENT -->
    <div class="dashboard-content">

        <div class="dashboard-header">

            <div>

                <h1>Seller Dashboard</h1>

                <p>Welcome back, <?= $user->name ?> 👋</p>

            </div>

            <button class="add-product-btn">
                <i class="fa-solid fa-plus"></i>
                Add Product
            </button>

        </div>

        <div class="dashboard-cards">

            <div class="card">

                <div class="card-icon">
                    <i class="fa-solid fa-box"></i>
                </div>

                <div>

                    <h4>Total Products</h4>
                </div>

            </div>

            <div class="card">

                <div class="card-icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>

                <div>

                    <h4>Total Orders</h4>


                </div>

            </div>

            <div class="card">

                <div class="card-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>

                    <h4>Customers</h4>


                </div>

            </div>

            <div class="card">

                <div class="card-icon">
                    <i class="fa-solid fa-naira-sign"></i>
                </div>

                <div>

                    <h4>Revenue</h4>



                </div>

            </div>





        </div>


        <div class="dashboard-body">

            <!-- Recent Products -->

            <div class="recent-products">

                <div class="section-header">

                    <h2>Recent Products</h2>

                    <a href="#" class="view-all">View All</a>

                </div>

                <table>

                    <thead>

                        <tr>

                            <th>Image</th>

                            <th>Product</th>

                            <th>Category</th>

                            <th>Price</th>

                            <th>Stock</th>

                            <th>Status</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>
                                <img src="img/laptop1.png" class="product-img">
                            </td>

                            <td>name</td>

                            <td>Laptops</td>

                            <td>price</td>

                            <td>18</td>

                            <td>
                                <span class="status in-stock">
                                    In Stock
                                </span>
                            </td>

                            <td>

                                <button class="edit-btn">
                                    Edit
                                </button>

                                <button class="delete-btn">
                                    Delete
                                </button>

                            </td>

                        </tr>

                        <tr>

                            <td>
                                <img src="img/laptop2.png" class="product-img">
                            </td>

                            <td>name</td>

                            <td>Laptops</td>

                            <td>price</td>

                            <td>0</td>

                            <td>
                                <span class="status out-stock">
                                    Out of Stock
                                </span>
                            </td>

                            <td>

                                <button class="edit-btn">
                                    Edit
                                </button>

                                <button class="delete-btn">
                                    Delete
                                </button>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>




        <!-- SALES OVERVIEW -->

        <div class="sales-overview">

            <div class="section-header">

                <h2>Sales Overview</h2>

                <select>

                    <option>This Week</option>
                    <option>This Month</option>
                    <option>This Year</option>

                </select>

            </div>

            <div class="chart-placeholder">

                <i class="fa-solid fa-chart-line"></i>

                <h3>Sales Analytics</h3>

                <p>Your sales chart anaytics will appear here.</p>

            </div>

        </div>



        <!-- product mangement  -->
        <!-- RECENT ORDERS -->

        <div class="recent-orders">

            <div class="section-header">

                <h2>Recent Orders</h2>

                <a href="#" class="view-all">View All</a>

            </div>

            <table>

                <thead>

                    <tr>

                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>#ORD001</td>

                        <td>John Doe</td>

                        <td>HP EliteBook G7</td>

                        <td>₦350,000</td>

                        <td>
                            <span class="badge delivered">
                                Delivered
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>#ORD002</td>

                        <td>Mary Johnson</td>

                        <td>Dell Latitude</td>

                        <td>₦420,000</td>

                        <td>
                            <span class="badge pending">
                                Pending
                            </span>
                        </td>

                    </tr>

                    <tr>

                        <td>#ORD003</td>

                        <td>David Smith</td>

                        <td>MacBook Air</td>

                        <td>₦950,000</td>

                        <td>
                            <span class="badge cancelled">
                                Cancelled
                            </span>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>
    </div>

</section>

<?php include_once "./components/user/footer.php";
