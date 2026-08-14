<?php
$pageTitle = "settings";

require_once("components/user/head.php");
?>


<?php require_once("components/user/header.php"); ?>
<link rel="stylesheet" href="./assets/css/settings.css">

<div class="settings-layout">
    <div class="settings-container">

        <!-- SETTINGS SIDEBAR -->

        <aside class="settings-sidebar">

            <div class="settings-title">

                <i class="fa-solid fa-gear"></i>

                <h2>Settings</h2>

            </div>

            <nav class="settings-nav">

                <a href="#profile" class="active" data-section="profile">
                    <i class="fa-solid fa-user"></i>
                    <span>Profile</span>
                </a>

                <a href="#security" data-section="security">
                    <i class="fa-solid fa-lock"></i>
                    <span>Security</span>
                </a>

                <a href="#notifications" data-section="notifications">
                    <i class="fa-solid fa-bell"></i>
                    <span>Notifications</span>
                </a>

                <a href="#appearance" data-section="appearance">
                    <i class="fa-solid fa-palette"></i>
                    <span>Appearance</span>
                </a>

                <a href="#language" data-section="language">
                    <i class="fa-solid fa-language"></i>
                    <span>Language</span>
                </a>

                <a href="#payments" data-section="payments">
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Payments</span>
                </a>

                <a href="#address" data-section="address">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Address</span>
                </a>

                <a href="#api-keys" data-section="api-keys">
                    <i class="fa-solid fa-key"></i>
                    <span>API Keys</span>
                </a>

                <a href="#privacy" data-section="privacy">
                    <i class="fa-solid fa-shield"></i>
                    <span>Privacy</span>
                </a>

            </nav>

        </aside>


        <!-- SETTINGS CONTENT -->

        <main class="settings-content">


            <!-- ================= PROFILE ================= -->

            <section class="settings-section active" id="profile">

                <div class="settings-header">

                    <h1>Profile Settings</h1>

                    <p>
                        Manage your personal information and account details.
                    </p>

                </div>


                <section class="settings-card">

                    <div class="profile-image">

                        <div class="profile-photo-wrapper">

                            <img
                                id="profilePreview"
                                src="./assets/photos/019f700f-c91b-727a-9bfd-9dbdac1a48f4.png"
                                alt="Profile">

                            <label for="profileImageInput" class="camera-btn">

                                <i class="fa-solid fa-camera"></i>

                            </label>

                            <input
                                type="file"
                                id="profileImageInput"
                                accept="image/png,image/jpeg,image/webp"
                                hidden>

                        </div>


                        <div>

                            <h3>Profile Photo</h3>

                            <p>
                                JPG, PNG or WebP. Maximum size 5MB.
                            </p>

                        </div>

                    </div>


                    <div class="form-grid">


                        <div class="form-group">

                            <label for="fullName">
                                Full Name
                            </label>

                            <input
                                id="fullName"
                                type="text"
                                placeholder="John Doe">

                        </div>


                        <div class="form-group">

                            <label for="username">
                                Username
                            </label>

                            <input
                                id="username"
                                type="text"
                                placeholder="johndoe">

                        </div>


                        <div class="form-group">

                            <label for="email">
                                Email Address
                            </label>

                            <input
                                id="email"
                                type="email"
                                placeholder="example@gmail.com">

                        </div>


                        <div class="form-group">

                            <label for="phone">
                                Phone Number
                            </label>

                            <input
                                id="phone"
                                type="tel"
                                placeholder="+234 800 000 0000">

                        </div>


                        <div class="form-group">

                            <label for="country">
                                Country
                            </label>

                            <input
                                id="country"
                                type="text"
                                placeholder="Nigeria">

                        </div>


                        <div class="form-group">

                            <label for="city">
                                City
                            </label>

                            <input
                                id="city"
                                type="text"
                                placeholder="Lagos">

                        </div>

                    </div>


                    <div class="settings-actions">

                        <button class="save-btn" id="saveProfile">

                            <i class="fa-solid fa-check"></i>

                            Save Changes

                        </button>

                    </div>

                </section>

            </section>


            <!-- ================= SECURITY ================= -->

            <section class="settings-section" id="security">

                <div class="settings-header">

                    <h1>Security</h1>

                    <p>
                        Protect your account and control your security settings.
                    </p>

                </div>


                <section class="settings-card">

                    <h2>Password</h2>

                    <p>
                        Change your password regularly to keep your account secure.
                    </p>

                    <button class="outline-btn" id="changePasswordBtn">

                        <i class="fa-solid fa-key"></i>

                        Change Password

                    </button>

                </section>


                <section class="settings-card">

                    <div class="setting-row">

                        <div>

                            <h3>Two-Factor Authentication</h3>

                            <p>
                                Add an extra layer of protection to your account.
                            </p>

                        </div>

                        <button class="outline-btn" id="twoFactorBtn">

                            Enable 2FA

                        </button>

                    </div>

                </section>


                <section class="settings-card">

                    <h2>Login Activity</h2>

                    <p>
                        Review recent activity on your account.
                    </p>


                    <div class="security-item">

                        <div class="security-item-icon">

                            <i class="fa-solid fa-desktop"></i>

                        </div>

                        <div>

                            <strong>Current Session</strong>

                            <span>Windows · Chrome</span>

                        </div>

                        <span class="online">
                            Active
                        </span>

                    </div>

                </section>

            </section>


            <!-- ================= NOTIFICATIONS ================= -->

            <section class="settings-section" id="notifications">

                <div class="settings-header">

                    <h1>Notifications</h1>

                    <p>
                        Control how GABSITE communicates with you.
                    </p>

                </div>


                <section class="settings-card">


                    <div class="toggle-row">

                        <div>

                            <h4>Email Notifications</h4>

                            <span>
                                Receive important account updates through email.
                            </span>

                        </div>

                        <label class="switch">

                            <input
                                type="checkbox"
                                id="emailNotifications"
                                checked>

                            <span class="slider"></span>

                        </label>

                    </div>


                    <div class="toggle-row">

                        <div>

                            <h4>Order Updates</h4>

                            <span>
                                Get notified about your orders.
                            </span>

                        </div>

                        <label class="switch">

                            <input
                                type="checkbox"
                                id="orderNotifications"
                                checked>

                            <span class="slider"></span>

                        </label>

                    </div>


                    <div class="toggle-row">

                        <div>

                            <h4>Seller Messages</h4>

                            <span>
                                Receive messages from sellers.
                            </span>

                        </div>

                        <label class="switch">

                            <input
                                type="checkbox"
                                id="sellerNotifications">

                            <span class="slider"></span>

                        </label>

                    </div>


                    <div class="toggle-row">

                        <div>

                            <h4>Promotions & Offers</h4>

                            <span>
                                Receive special offers and marketplace promotions.
                            </span>

                        </div>

                        <label class="switch">

                            <input
                                type="checkbox"
                                id="promotionNotifications">

                            <span class="slider"></span>

                        </label>

                    </div>


                    <div class="toggle-row">

                        <div>

                            <h4>Security Alerts</h4>

                            <span>
                                Get notified about important security events.
                            </span>

                        </div>

                        <label class="switch">

                            <input
                                type="checkbox"
                                id="securityNotifications"
                                checked>

                            <span class="slider"></span>

                        </label>

                    </div>

                </section>

            </section>


            <!-- ================= APPEARANCE ================= -->

            <section class="settings-section" id="appearance">

                <div class="settings-header">

                    <h1>Appearance</h1>

                    <p>
                        Customize how GABSITE looks for you.
                    </p>

                </div>


                <section class="settings-card">

                    <h2>Theme</h2>

                    <p>
                        Choose how the application should appear.
                    </p>


                    <div class="theme-options">


                        <button
                            class="theme-btn active"
                            data-theme="light">

                            <i class="fa-solid fa-sun"></i>

                            Light

                        </button>


                        <button
                            class="theme-btn"
                            data-theme="dark">

                            <i class="fa-solid fa-moon"></i>

                            Dark

                        </button>


                        <button
                            class="theme-btn"
                            data-theme="system">

                            <i class="fa-solid fa-desktop"></i>

                            System

                        </button>


                    </div>

                </section>

            </section>


            <!-- ================= LANGUAGE ================= -->

            <section class="settings-section" id="language">

                <div class="settings-header">

                    <h1>Language & Region</h1>

                    <p>
                        Customize your language, currency and regional preferences.
                    </p>

                </div>


                <section class="settings-card">

                    <div class="form-grid">


                        <div class="form-group">

                            <label for="languageSelect">
                                Language
                            </label>

                            <select id="languageSelect">

                                <option value="en">
                                    English
                                </option>

                                <option value="fr">
                                    French
                                </option>

                                <option value="es">
                                    Spanish
                                </option>

                            </select>

                        </div>


                        <div class="form-group">

                            <label for="currencySelect">
                                Currency
                            </label>

                            <select id="currencySelect">

                                <option value="NGN">
                                    NGN ₦
                                </option>

                                <option value="USD">
                                    USD $
                                </option>

                                <option value="EUR">
                                    EUR €

                                </option>

                            </select>

                        </div>


                        <div class="form-group">

                            <label for="timezoneSelect">
                                Timezone
                            </label>

                            <select id="timezoneSelect">

                                <option value="Africa/Lagos">
                                    Africa/Lagos (WAT)
                                </option>

                                <option value="Europe/London">
                                    Europe/London
                                </option>

                                <option value="America/New_York">
                                    America/New_York
                                </option>

                            </select>

                        </div>

                    </div>


                    <button class="save-btn" id="saveRegion">

                        Save Preferences

                    </button>

                </section>

            </section>


            <!-- ================= PAYMENTS ================= -->

            <section class="settings-section" id="payments">

                <div class="settings-header">

                    <h1>Payment Methods</h1>

                    <p>
                        Manage your saved payment methods.
                    </p>

                </div>


                <section class="settings-card">


                    <div class="payment-box">

                        <div class="payment-icon">

                            <i class="fa-brands fa-cc-visa"></i>

                        </div>


                        <div>

                            <h4>Visa Card</h4>

                            <span>
                                **** **** **** 4521
                            </span>

                        </div>


                        <span class="default-badge">
                            Default
                        </span>


                        <button class="remove-btn">
                            Remove
                        </button>

                    </div>


                    <button class="save-btn" id="addPayment">

                        <i class="fa-solid fa-plus"></i>

                        Add Payment Method

                    </button>

                </section>

            </section>


            <!-- ================= ADDRESS ================= -->

            <section class="settings-section" id="address">

                <div class="settings-header">

                    <h1>Addresses</h1>

                    <p>
                        Manage your delivery and billing addresses.
                    </p>

                </div>


                <section class="settings-card">


                    <div class="address-card">

                        <div>

                            <span class="default-badge">
                                Default
                            </span>

                            <h3>Home Address</h3>

                            <p>
                                12 Example Street<br>
                                Lagos, Nigeria
                            </p>

                            <span>
                                +234 800 000 0000
                            </span>

                        </div>


                        <div class="address-actions">

                            <button class="outline-btn">
                                Edit
                            </button>

                            <button class="remove-btn">
                                Delete
                            </button>

                        </div>

                    </div>


                    <button class="save-btn">

                        <i class="fa-solid fa-plus"></i>

                        Add New Address

                    </button>

                </section>

            </section>


            <!-- ================= API KEYS ================= -->

            <section class="settings-section" id="api-keys">

                <div class="settings-header">

                    <h1>API Keys</h1>

                    <p>
                        Manage API credentials connected to your GABSITE account.
                    </p>

                </div>


                <section class="settings-card">

                    <div class="api-warning">

                        <i class="fa-solid fa-triangle-exclamation"></i>

                        <div>

                            <strong>Keep your API keys private.</strong>

                            <p>
                                Never share your secret API keys publicly.
                            </p>

                        </div>

                    </div>


                    <div class="api-key-item">

                        <div>

                            <h4>Production API Key</h4>

                            <code>
                                gabs_••••••••••••••••••••
                            </code>

                            <small>
                                Created recently
                            </small>

                        </div>


                        <button class="remove-btn">
                            Revoke
                        </button>

                    </div>


                    <button class="save-btn" id="createApiKey">

                        <i class="fa-solid fa-plus"></i>

                        Create API Key

                    </button>

                </section>

            </section>


            <!-- ================= PRIVACY ================= -->

            <section class="settings-section" id="privacy">

                <div class="settings-header">

                    <h1>Privacy</h1>

                    <p>
                        Control your personal data and account privacy.
                    </p>

                </div>


                <section class="settings-card">


                    <div class="toggle-row">

                        <div>

                            <h4>Personalized Experience</h4>

                            <span>
                                Allow GABSITE to personalize recommendations.
                            </span>

                        </div>

                        <label class="switch">

                            <input type="checkbox" checked>

                            <span class="slider"></span>

                        </label>

                    </div>


                    <div class="toggle-row">

                        <div>

                            <h4>Usage Analytics</h4>

                            <span>
                                Help improve GABSITE by sharing anonymous usage data.
                            </span>

                        </div>

                        <label class="switch">

                            <input type="checkbox" checked>

                            <span class="slider"></span>

                        </label>

                    </div>


                </section>


                <section class="settings-card danger-zone">

                    <h2>Danger Zone</h2>

                    <p>
                        These actions can permanently affect your account.
                    </p>


                    <button class="danger-btn">

                        <i class="fa-solid fa-user-slash"></i>

                        Deactivate Account

                    </button>


                    <button class="danger-btn">

                        <i class="fa-solid fa-trash"></i>

                        Delete Account

                    </button>

                </section>

            </section>


        </main>

    </div>

</div>

<script src="./assets/js/settings.js"></script>

</body>

</html>