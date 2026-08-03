<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <php echo $title; ?></php>

    </title>
    <link rel="stylesheet" href="./assets/css/admin.css">
</head>

<body>
    <aside class="admin-sidebar">

        <div class="sidebar-logo">

            <i class="fa-solid fa-store"></i>

            <div>

                <h2>Marketplace</h2>

                <span>Admin Panel</span>

            </div>

        </div>

        <nav>

            <a href="dashboard.php" class="active">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>

            <a href="products.php">
                <i class="fa-solid fa-box"></i>
                Products
            </a>

            <a href="categories.php">
                <i class="fa-solid fa-layer-group"></i>
                Categories
            </a>

            <a href="orders.php">
                <i class="fa-solid fa-cart-shopping"></i>
                Orders
            </a>

            <a href="customers.php">
                <i class="fa-solid fa-users"></i>
                Customers
            </a>

            <a href="sellers.php">
                <i class="fa-solid fa-store"></i>
                Sellers
            </a>

            <a href="payments.php">
                <i class="fa-solid fa-credit-card"></i>
                Payments
            </a>

            <a href="coupons.php">
                <i class="fa-solid fa-ticket"></i>
                Coupons
            </a>

            <a href="reports.php">
                <i class="fa-solid fa-chart-line"></i>
                Reports
            </a>

            <a href="admins.php">
                <i class="fa-solid fa-user-shield"></i>
                Admins
            </a>

            <a href="settings.php">
                <i class="fa-solid fa-gear"></i>
                Settings
            </a>

        </nav>

        <div class="sidebar-footer">

            <a href="../logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                Logout

            </a>

        </div>

    </aside>

</body>

</html>