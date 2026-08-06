<?php

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

                <h2>
                    Settings
                </h2>

            </div>


            <nav>


                <a href="#" class="active">
                    <i class="fa-solid fa-user"></i>
                    Profile
                </a>


                <a href="#">
                    <i class="fa-solid fa-lock"></i>
                    Security
                </a>


                <a href="#">
                    <i class="fa-solid fa-bell"></i>
                    Notifications
                </a>


                <a href="#">
                    <i class="fa-solid fa-palette"></i>
                    Appearance
                </a>


                <a href="#">
                    <i class="fa-solid fa-language"></i>
                    Language
                </a>


                <a href="#">
                    <i class="fa-solid fa-credit-card"></i>
                    Payments
                </a>


                <a href="#">
                    <i class="fa-solid fa-location-dot"></i>
                    Address
                </a>


                <a href="#">
                    <i class="fa-solid fa-key"></i>
                    API Keys
                </a>


                <a href="#">
                    <i class="fa-solid fa-shield"></i>
                    Privacy
                </a>


            </nav>


        </aside>




        <!-- SETTINGS CONTENT -->


        <main class="settings-content">


            <div class="settings-header">

                <h1>
                    Profile Settings
                </h1>

                <p>
                    Manage your personal information and account details.
                </p>

            </div>



            <!-- PROFILE CARD -->


            <section class="settings-card">


                <div class="profile-image">


                    <img
                        src="./assets/photos/019f700f-c91b-727a-9bfd-9dbdac1a48f4.png"
                        alt="Profile">


                    <button>
                        <i class="fa-solid fa-camera"></i>
                    </button>


                </div>



                <div class="form-grid">


                    <div class="form-group">

                        <label>
                            Full Name
                        </label>

                        <input
                            type="text"
                            value="" placeholder="John Doe">


                    </div>



                    <div class="form-group">

                        <label>
                            Username
                        </label>

                        <input
                            type="text"
                            value="" placeholder="John Doe">


                    </div>




                    <div class="form-group">

                        <label>
                            Email Address
                        </label>

                        <input
                            type="email"
                            placeholder="Example@gmail.com">


                    </div>




                    <div class="form-group">

                        <label>
                            Phone Number
                        </label>

                        <input
                            type="text"
                            placeholder="+234">


                    </div>




                    <div class="form-group">

                        <label>
                            Country
                        </label>

                        <input
                            type="text"
                            placeholder="Country">


                    </div>



                    <div class="form-group">

                        <label>
                            City
                        </label>

                        <input
                            type="text" placeholder="City">


                    </div>



                </div>



                <button class="save-btn">

                    Save Changes

                </button>



            </section>




            <!-- SECURITY PREVIEW -->


            <section class="settings-card">


                <h2>
                    Security
                </h2>


                <p>
                    Protect your account with password and authentication.
                </p>


                <button class="outline-btn">

                    Change Password

                </button>


                <button class="outline-btn">

                    Enable Two Factor Authentication

                </button>



            </section>


            <!-- NOTIFICATIONS SETTINGS -->

            <section class="settings-card">

                <h2>
                    Notifications
                </h2>

                <p>
                    Control how you receive updates from GABSITE.
                </p>


                <div class="toggle-row">

                    <div>
                        <h4>Email Notifications</h4>
                        <span>Receive important updates through email.</span>
                    </div>


                    <label class="switch">

                        <input type="checkbox" checked>

                        <span class="slider"></span>

                    </label>

                </div>



                <div class="toggle-row">

                    <div>
                        <h4>Order Updates</h4>
                        <span>Get notified about your orders.</span>
                    </div>


                    <label class="switch">

                        <input type="checkbox" checked>

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

                        <input type="checkbox">

                        <span class="slider"></span>

                    </label>


                </div>


            </section>






            <!-- APPEARANCE SETTINGS -->


            <section class="settings-card">


                <h2>
                    Appearance
                </h2>


                <p>
                    Customize how GABSITE looks for you.
                </p>



                <div class="theme-options">


                    <button class="theme-btn active">

                        <i class="fa-solid fa-sun"></i>

                        Light

                    </button>



                    <button class="theme-btn">

                        <i class="fa-solid fa-moon"></i>

                        Dark

                    </button>



                    <button class="theme-btn">

                        <i class="fa-solid fa-desktop"></i>

                        System

                    </button>


                </div>


            </section>







            <!-- LANGUAGE SETTINGS -->


            <section class="settings-card">


                <h2>
                    Language & Region
                </h2>


                <div class="form-grid">


                    <div class="form-group">

                        <label>
                            Language
                        </label>


                        <select>

                            <option>
                                English
                            </option>

                            <option>
                                French
                            </option>

                            <option>
                                Spanish
                            </option>


                        </select>


                    </div>




                    <div class="form-group">

                        <label>
                            Currency
                        </label>


                        <select>

                            <option>
                                NGN ₦
                            </option>


                            <option>
                                USD $
                            </option>


                            <option>
                                EUR €
                            </option>


                        </select>


                    </div>


                </div>


            </section>








            <!-- PAYMENT SETTINGS -->


            <section class="settings-card">


                <h2>
                    Payment Methods
                </h2>


                <p>
                    Manage your saved payment information.
                </p>



                <div class="payment-box">


                    <i class="fa-solid fa-credit-card"></i>


                    <div>

                        <h4>
                            Visa Card
                        </h4>


                        <span>
                            **** **** **** 4521
                        </span>


                    </div>


                    <button>
                        Remove
                    </button>


                </div>



                <button class="save-btn">

                    Add Payment Method

                </button>



            </section>




        </main>



    </div>


</div>