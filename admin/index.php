<?php
require_once("../core/config.php");
require_once("../components/user/head.php");
$root = ROOT;
?>
<?php require_once("$root/components/admin/header.php"); ?>
<link rel="stylesheet" href="../assets/css/admin.css">

<body>

    <div class="admin-layout">

        <!-- Sidebar -->
        <?php require_once("$root/components/admin/sidebar.php"); ?>

        <!-- Main Content -->
        <main class="admin-content">

            <!-- Dashboard Header -->
            <div class="admin-dashboard-header">

                <div>
                    <h1>Admin</h1>

                    <p>Welcome back, <?= $user->name ?></p>

                    <span>Here's what's happening across your marketplace today.</span>
                </div>

                <div class="dashboard-actions">

                    <button class="primary-btn">
                        <i class="fa-solid fa-user-plus"></i>
                        Add Seller
                    </button>

                </div>

            </div>


            <!-- Statistics -->
            <section class="stats-grid">

                <div class="stat-card revenue">
                    <div class="stat-icon">
                        <i class="fa-solid fa-naira-sign"></i>
                    </div>

                    <div class="stat-info">
                        <small>Total Revenue</small>
                        <h2>₦28.4M</h2>
                        <span class="positive">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                            +12.8%
                        </span>
                    </div>
                </div>

                <div class="stat-card orders">
                    <div class="stat-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>

                    <div class="stat-info">
                        <small>Total Orders</small>
                        <h2>18,420</h2>
                        <span class="positive">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                            +6.3%
                        </span>
                    </div>
                </div>

                <div class="stat-card customers">
                    <div class="stat-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <div class="stat-info">
                        <small>Customers</small>
                        <h2>9,845</h2>
                        <span class="positive">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                            +8.1%
                        </span>
                    </div>
                </div>

                <div class="stat-card sellers">
                    <div class="stat-icon">
                        <i class="fa-solid fa-store"></i>
                    </div>

                    <div class="stat-info">
                        <small>Active Sellers</small>
                        <h2>426</h2>
                        <span class="positive">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                            +3.4%
                        </span>
                    </div>
                </div>

                <div class="stat-card products">
                    <div class="stat-icon">
                        <i class="fa-solid fa-box"></i>
                    </div>

                    <div class="stat-info">
                        <small>Products</small>
                        <h2>8,241</h2>
                        <span class="positive">
                            +15%
                        </span>
                    </div>
                </div>

                <div class="stat-card pending">
                    <div class="stat-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <div class="stat-info">
                        <small>Pending Orders</small>
                        <h2>152</h2>
                        <span class="warning">
                            Waiting
                        </span>
                    </div>
                </div>

                <div class="stat-card refunds">
                    <div class="stat-icon">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>

                    <div class="stat-info">
                        <small>Refund Requests</small>
                        <h2>21</h2>
                        <span class="negative">
                            -4%
                        </span>
                    </div>
                </div>

                <div class="stat-card tickets">
                    <div class="stat-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>

                    <div class="stat-info">
                        <small>Support Tickets</small>
                        <h2>18</h2>
                        <span class="warning">
                            Open
                        </span>
                    </div>
                </div>

            </section>

            <section class="dashboard-row">

                <!-- Revenue Analytics -->

                <div class="dashboard-card analytics-card">

                    <div class="card-header">

                        <div>

                            <h2>Revenue Analytics</h2>

                            <p>Monthly marketplace revenue</p>

                        </div>

                        <select>

                            <option>This Month</option>
                            <option>Last Month</option>
                            <option>This Year</option>

                        </select>

                    </div>

                    <div class="chart-container">

                        <canvas id="revenueChart"></canvas>

                    </div>

                </div>

                <!-- Marketplace Health -->

                <div class="dashboard-card health-card">

                    <h2>Marketplace Health</h2>

                    <div class="health-item">

                        <span>Server Status</span>

                        <span class="online">Online</span>

                    </div>

                    <div class="health-item">

                        <span>Database</span>

                        <span class="online">Healthy</span>

                    </div>

                    <div class="health-item">

                        <span>Payments</span>

                        <span class="online">Working</span>

                    </div>

                    <div class="health-item">

                        <span>Email Service</span>

                        <span class="online">Running</span>

                    </div>

                    <div class="health-item">

                        <span>Storage</span>

                        <span class="warning">82% Used</span>

                    </div>

                    <div class="health-item">

                        <span>API</span>

                        <span class="online">Normal</span>

                    </div>

                </div>

            </section>

            <section class="dashboard-row">

                <!-- Latest Orders -->

                <div class="dashboard-card">

                    <div class="card-header">

                        <div>
                            <h2>Latest Orders</h2>
                            <p>Newest marketplace orders</p>
                        </div>

                        <a href="#">View All</a>

                    </div>

                    <table class="orders-table">

                        <thead>

                            <tr>

                                <th>Order</th>

                                <th>Customer</th>

                                <th>Seller</th>

                                <th>Amount</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>#MK10021</td>

                                <td>Gabriel</td>

                                <td>Tech Store</td>

                                <td>₦185,000</td>

                                <td><span class="badge success">Delivered</span></td>

                            </tr>

                            <tr>

                                <td>#MK10022</td>

                                <td>John</td>

                                <td>Fashion Hub</td>

                                <td>₦62,000</td>

                                <td><span class="badge pending">Pending</span></td>

                            </tr>

                            <tr>

                                <td>#MK10023</td>

                                <td>Sarah</td>

                                <td>Smart Gadgets</td>

                                <td>₦350,000</td>

                                <td><span class="badge processing">Processing</span></td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <!-- Quick Actions -->

                <div class="dashboard-card">

                    <h2>Quick Actions</h2>

                    <div class="quick-actions">

                        <button><i class="fa-solid fa-user-plus"></i> Add Seller</button>

                        <button><i class="fa-solid fa-layer-group"></i> Add Category</button>

                        <button><i class="fa-solid fa-ticket"></i> Create Coupon</button>

                        <button><i class="fa-solid fa-chart-column"></i> Reports</button>

                        <button><i class="fa-solid fa-credit-card"></i> Payments</button>

                        <button><i class="fa-solid fa-user-shield"></i> Admins</button>

                    </div>

                </div>

            </section>
            <section class="dashboard-row">

                <div class="dashboard-card">

                    <div class="card-header">
                        <h2>Top Sellers</h2>
                        <a href="#">View All</a>
                    </div>

                    <div class="leaderboard">

                        <div class="leader">
                            <img src="https://placehold.co/50x50" alt="">
                            <div>
                                <h4>Tech Store</h4>
                                <small>₦8.2M Revenue</small>
                            </div>
                            <strong>★★★★★</strong>
                        </div>

                        <div class="leader">
                            <img src="https://placehold.co/50x50" alt="">
                            <div>
                                <h4>Fashion Hub</h4>
                                <small>₦6.4M Revenue</small>
                            </div>
                            <strong>★★★★☆</strong>
                        </div>

                    </div>

                </div>

                <div class="dashboard-card">

                    <div class="card-header">
                        <h2>Best Selling Products</h2>
                        <a href="#">View All</a>
                    </div>

                    <div class="leaderboard">

                        <div class="leader">
                            <img src="https://placehold.co/50x50" alt="">
                            <div>
                                <h4>iPhone 15 Pro</h4>
                                <small>320 Sold</small>
                            </div>
                        </div>

                        <div class="leader">
                            <img src="https://placehold.co/50x50" alt="">
                            <div>
                                <h4>Nike Air Max</h4>
                                <small>280 Sold</small>
                            </div>
                        </div>

                    </div>

                </div>

            </section>
        </main>

    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="./assets/js/admin.js"></script>

</html>