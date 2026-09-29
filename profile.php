<?php

/* =====================================================
   PROFILE NORELLE
   SISTEM LOGIN PHP SESSION
===================================================== */

session_start();


/* =====================================================
   CEK LOGIN
===================================================== */

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {

    header("Location: login.php");
    exit;

}


/* =====================================================
   AMBIL DATA USER DARI SESSION
===================================================== */

$userName = $_SESSION["user_name"] ?? "Norelle";
$userEmail = $_SESSION["user_email"] ?? "support@norelle.com";

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Norelle - Profile</title>


    <style>

        /* =========================================
           COLOR PALETTE
        ========================================= */

        :root {

            --primary: #F3F3F3;

            --secondary: #656565;

            --typography: #302F2F;

            --white: #FFFFFF;

            --black: #000000;

        }


        /* =========================================
           RESET
        ========================================= */

        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

        }


        html {

            scroll-behavior: smooth;

        }


        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: var(--white);

            color: var(--typography);

            min-height: 100vh;

            display: flex;

            flex-direction: column;

        }


        a {

            text-decoration: none;

            color: inherit;

        }


        /* =========================================
           NAVBAR
        ========================================= */

        .navbar {

            width: 100%;

            height: 70px;

            background: var(--white);

            border-bottom:
                1px solid #dddddd;

            display: flex;

            align-items: center;

            position: sticky;

            top: 0;

            z-index: 1000;

        }


        .navbar-container {

            width: 92%;

            max-width: 1500px;

            margin: auto;

            display: flex;

            align-items: center;

            justify-content: space-between;

        }


        /* =========================================
           LOGO
        ========================================= */

        .logo {

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size: 38px;

            font-weight: bold;

            letter-spacing: -1px;

            color: var(--typography);

        }


        /* =========================================
           NAV LINKS
        ========================================= */

        .nav-links {

            display: flex;

            align-items: center;

            gap: 45px;

        }


        .nav-links a {

            font-size: 14px;

            font-weight: 400;

            position: relative;

            padding: 25px 0;

            color: var(--typography);

        }


        .nav-links a::after {

            content: "";

            position: absolute;

            left: 0;

            bottom: 15px;

            width: 0;

            height: 1px;

            background:
                var(--typography);

            transition: 0.3s;

        }


        .nav-links a:hover::after {

            width: 100%;

        }


        /* =========================================
           NAV ICONS
        ========================================= */

        .nav-icons {

            display: flex;

            align-items: center;

            gap: 20px;

        }


        .nav-icon {

            width: 20px;

            height: 20px;

            display: flex;

            align-items: center;

            justify-content: center;

            color:
                var(--typography);

            transition: 0.3s;

        }


        .nav-icon:hover {

            opacity: 0.5;

        }


        .nav-icon svg {

            width: 18px;

            height: 18px;

            stroke:
                currentColor;

            fill: none;

            stroke-width: 1.5;

        }


        /* =========================================
           MAIN
        ========================================= */

        main {

            flex: 1;

            padding:
                25px 15px 55px;

            background:
                var(--primary);

        }


        /* =========================================
           PROFILE CARD
        ========================================= */

        .profile-card {

            width: 100%;

            min-height: 95px;

            background:
                var(--white);

            border:
                1px solid #dddddd;

            box-shadow:
                0 2px 5px
                rgba(0,0,0,0.12);

            display: flex;

            align-items: center;

            padding:
                10px 20px;

            margin-bottom: 30px;

        }


        /* =========================================
           PROFILE PHOTO
        ========================================= */

        .profile-photo {

            width: 76px;

            height: 76px;

            border:
                4px solid
                var(--typography);

            border-radius: 50%;

            position: relative;

            margin-right: 15px;

            flex-shrink: 0;

            overflow: hidden;

        }


        .profile-head {

            width: 29px;

            height: 29px;

            background:
                var(--typography);

            border-radius: 50%;

            position: absolute;

            top: 10px;

            left: 20px;

        }


        .profile-body {

            width: 52px;

            height: 28px;

            background:
                var(--typography);

            border-radius:
                30px 30px 0 0;

            position: absolute;

            bottom: -3px;

            left: 8px;

        }


        /* =========================================
           PROFILE INFORMATION
        ========================================= */

        .profile-info {

            flex: 1;

        }


        .profile-info h1 {

            font-size: 20px;

            margin-bottom: 8px;

            font-weight: bold;

        }


        .profile-info p {

            font-size: 11px;

            line-height: 1.4;

            color:
                var(--typography);

        }


        /* =========================================
           CONTACT
        ========================================= */

        .profile-contact {

            width: 175px;

            margin-right: 15px;

        }


        .contact-item {

            display: flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 7px;

        }


        .contact-item svg {

            width: 16px;

            height: 16px;

            stroke:
                var(--secondary);

            stroke-width: 2;

            fill: none;

            flex-shrink: 0;

        }


        .contact-text {

            display: flex;

            flex-direction: column;

        }


        .contact-label {

            font-size: 9px;

            color:
                var(--secondary);

        }


        .contact-value {

            font-size: 9px;

            color:
                var(--secondary);

        }


        /* =========================================
           EDIT PROFILE
        ========================================= */

        .edit-profile {

            width: 115px;

            height: 21px;

            background:
                var(--secondary);

            color: white;

            border: none;

            cursor: pointer;

            font-size: 10px;

            margin-top: 5px;

        }


        .edit-profile:hover {

            background:
                var(--typography);

        }


        /* =========================================
           PROFILE MENU
        ========================================= */

        .profile-menu {

            width: 100%;

            min-height: 125px;

            background:
                var(--white);

            border:
                1px solid #dddddd;

            box-shadow:
                0 2px 5px
                rgba(0,0,0,0.12);

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

        }


        .menu-item {

            min-height: 125px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            text-align: center;

            border-right:
                1px solid #dddddd;

            text-decoration: none;

            color:
                var(--typography);

            transition:
                0.2s ease;

        }


        .menu-item:last-child {

            border-right: none;

        }


        .menu-item:hover {

            background: #eeeeee;

        }


        /* =========================================
           MENU ICON
        ========================================= */

        .menu-icon {

            width: 31px;

            height: 31px;

            margin-bottom: 7px;

        }


        .menu-icon svg {

            width: 100%;

            height: 100%;

            stroke:
                var(--typography);

            stroke-width: 1.8;

            fill: none;

        }


        .menu-number {

            font-size: 11px;

            font-weight: bold;

            margin-bottom: 2px;

        }


        .menu-title {

            font-size: 11px;

            font-weight: bold;

            margin-bottom: 4px;

        }


        .menu-description {

            font-size: 8px;

            color:
                var(--secondary);

        }


        /* =========================================
           FOOTER
        ========================================= */

        footer {

            width: 100%;

            background:
                var(--typography);

            color: white;

            padding:
                28px 27px 25px;

            flex-shrink: 0;

        }


        .footer-container {

            width: 100%;

            display: grid;

            grid-template-columns:
                1.4fr
                1fr
                1fr
                1fr
                1fr;

            gap: 35px;

        }


        .footer-brand h2 {

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size: 24px;

            margin-bottom: 12px;

            color: white;

        }


        .footer-brand p {

            font-size: 9px;

            line-height: 1.8;

            color:
                var(--primary);

            max-width: 180px;

        }


        .footer-column h3 {

            font-size: 10px;

            margin-bottom: 14px;

            color: white;

        }


        .footer-column a {

            display: block;

            color:
                var(--primary);

            text-decoration: none;

            font-size: 9px;

            margin-bottom: 8px;

        }


        .footer-column a:hover {

            color: white;

        }


        /* =========================================
           SOCIAL MEDIA
        ========================================= */

        .social-icons {

            display: flex;

            align-items: center;

            gap: 12px;

        }


        .social-icons a {

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            text-decoration: none;

        }


        .social-icons svg {

            width: 13px;

            height: 13px;

            stroke: white;

            stroke-width: 1.8;

            fill: none;

        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 900px) {

            .navbar {

                padding:
                    0 30px;

            }


            .nav-links {

                gap: 30px;

            }


            .profile-card {

                flex-wrap: wrap;

                gap: 15px;

                padding: 15px;

            }


            .profile-contact {

                margin-left: auto;

            }


            .footer-container {

                grid-template-columns:
                    repeat(3, 1fr);

            }

        }


        @media (max-width: 700px) {

            .navbar {

                height: auto;

                min-height: 70px;

                padding:
                    12px 20px;

                flex-wrap: wrap;

            }


            .logo {

                font-size: 34px;

            }


            .nav-links {

                order: 3;

                width: 100%;

                justify-content: center;

                gap: 20px;

            }


            .nav-links a {

                font-size: 13px;

                padding: 10px 0;

            }


            .nav-icons {

                margin-left: auto;

                gap: 16px;

            }


            .profile-card {

                flex-direction: column;

                text-align: center;

            }


            .profile-photo {

                margin-right: 0;

            }


            .profile-contact {

                width: auto;

                margin-right: 0;

            }


            .profile-menu {

                grid-template-columns:
                    1fr 1fr;

            }


            .menu-item:nth-child(2) {

                border-right: none;

            }


            .menu-item:nth-child(1),
            .menu-item:nth-child(2) {

                border-bottom:
                    1px solid #dddddd;

            }


            .footer-container {

                grid-template-columns:
                    1fr 1fr;

            }

        }


        @media (max-width: 450px) {

            .profile-menu {

                grid-template-columns:
                    1fr;

            }


            .menu-item {

                border-right: none;

                border-bottom:
                    1px solid #dddddd;

            }


            .menu-item:last-child {

                border-bottom: none;

            }


            .footer-container {

                grid-template-columns:
                    1fr;

            }

        }

    </style>

</head>


<body>


    <!-- =========================================
         NAVBAR
    ========================================= -->

    <header class="navbar">

        <div class="navbar-container">


            <!-- LOGO -->

            <a
                href="profile.php"
                class="logo">

                Norelle

            </a>


            <!-- MENU -->

            <nav class="nav-links">

                <a href="index.php">
                    HOME
                </a>

                <a href="shop.html">
                    SHOP
                </a>

                <a href="wanita.html">
                    WANITA
                </a>

                <a href="pria.html">
                    PRIA
                </a>

                <a href="contact.html">
                    CONTACT
                </a>

            </nav>


            <!-- ICONS -->

            <div class="nav-icons">


                <!-- SEARCH -->

                <a
                    href="search.html"
                    class="nav-icon"
                    aria-label="Search">

                    <svg viewBox="0 0 24 24">

                        <circle
                            cx="11"
                            cy="11"
                            r="6">
                        </circle>

                        <line
                            x1="16"
                            y1="16"
                            x2="21"
                            y2="21">
                        </line>

                    </svg>

                </a>


                <!-- PROFILE -->

                <a
                    href="profile.php"
                    class="nav-icon"
                    aria-label="Profile">

                    <svg viewBox="0 0 24 24">

                        <circle
                            cx="12"
                            cy="8"
                            r="3.5">
                        </circle>

                        <path
                            d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6">
                        </path>

                    </svg>

                </a>


                <!-- CART -->

                <a
                    href="cart.html"
                    class="nav-icon"
                    aria-label="Shopping Cart">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M5 8h14l-1 12H6L5 8z">
                        </path>

                        <path
                            d="M9 8V6a3 3 0 0 1 6 0v2">
                        </path>

                    </svg>

                </a>

            </div>

        </div>

    </header>



    <!-- =========================================
         MAIN
    ========================================= -->

    <main>


        <!-- =========================================
             PROFILE INFORMATION
        ========================================= -->

        <section class="profile-card">


            <!-- PROFILE PHOTO -->

            <div class="profile-photo">

                <div class="profile-head"></div>

                <div class="profile-body"></div>

            </div>


            <!-- PROFILE TEXT -->

            <div class="profile-info">

                <h1>

                    Hi,
                    <?php
                    echo htmlspecialchars($userName);
                    ?>

                </h1>

                <p>

                    Welcome back! Let’s continue

                    <br>

                    your style journey

                </p>

            </div>


            <!-- CONTACT -->

            <div class="profile-contact">


                <!-- EMAIL -->

                <div class="contact-item">

                    <svg viewBox="0 0 24 24">

                        <circle
                            cx="12"
                            cy="12"
                            r="9">
                        </circle>

                        <path
                            d="M4 8h16">
                        </path>

                        <path
                            d="M4 8l8 5 8-5">
                        </path>

                    </svg>


                    <div class="contact-text">

                        <span class="contact-label">

                            Email

                        </span>

                        <span class="contact-value">

                            <?php
                            echo htmlspecialchars($userEmail);
                            ?>

                        </span>

                    </div>

                </div>



                <!-- PHONE -->

                <div class="contact-item">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M6 3h4l2 5-2 2c1 2 2 3 4 4l2-2 5 2v4c0 1-1 2-2 2C11 20 4 13 4 5c0-1 1-2 2-2z">
                        </path>

                    </svg>


                    <div class="contact-text">

                        <span class="contact-label">

                            Phone

                        </span>

                        <span class="contact-value">

                            +62 857 2296 0077

                        </span>

                    </div>

                </div>



                <!-- EDIT PROFILE -->

                <button
                    class="edit-profile"
                    type="button">

                    Edit Profile

                </button>

            </div>

        </section>



        <!-- =========================================
             PROFILE MENU
        ========================================= -->

        <section class="profile-menu">


            <!-- ORDERS -->

            <a
                href="#"
                class="menu-item">

                <div class="menu-icon">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M5 8h14l-1 12H6L5 8z">
                        </path>

                        <path
                            d="M8 8V6a4 4 0 0 1 8 0v2">
                        </path>

                    </svg>

                </div>


                <span class="menu-number">

                    8

                </span>


                <span class="menu-title">

                    Orders

                </span>


                <span class="menu-description">

                    lihat semua pesanan

                </span>

            </a>



            <!-- WISHLIST -->

            <a
                href="#"
                class="menu-item">

                <div class="menu-icon">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M20.8 8.8c0 5-8.8 10.2-8.8 10.2S3.2 13.8 3.2 8.8A5 5 0 0 1 12 6a5 5 0 0 1 8.8 2.8z">
                        </path>

                    </svg>

                </div>


                <span class="menu-number">

                    20

                </span>


                <span class="menu-title">

                    Wishlist

                </span>


                <span class="menu-description">

                    lihat wishlist

                </span>

            </a>



            <!-- ADDRESS -->

            <a
                href="#"
                class="menu-item">

                <div class="menu-icon">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M12 21s7-6.2 7-12a7 7 0 1 0-14 0c0 5.8 7 12 7 12z">
                        </path>

                        <circle
                            cx="12"
                            cy="9"
                            r="2.5">
                        </circle>

                    </svg>

                </div>


                <span class="menu-number">

                    1

                </span>


                <span class="menu-title">

                    Address

                </span>


                <span class="menu-description">

                    lihat alamat

                </span>

            </a>



            <!-- =====================================
                 LOGOUT
            ====================================== -->

            <a
                href="logout.php"
                class="menu-item">

                <div class="menu-icon">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M10 4H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h5">
                        </path>

                        <path
                            d="M15 8l4 4-4 4">
                        </path>

                        <path
                            d="M19 12H9">
                        </path>

                    </svg>

                </div>


                <span class="menu-title">

                    Logout

                </span>

            </a>


        </section>


    </main>



    <!-- =========================================
         FOOTER
    ========================================= -->

    <footer>

        <div class="footer-container">


            <!-- BRAND -->

            <div class="footer-brand">

                <h2>

                    Norelle

                </h2>

                <p>

                    Streetwear for every moment.

                    <br>

                    Made for those who define

                    <br>

                    their own style.

                </p>

            </div>



            <!-- SHOP -->

            <div class="footer-column">

                <h3>

                    SHOP

                </h3>

                <a href="shop.html">
                    All Products
                </a>

                <a href="shop.html">
                    Hoodie
                </a>

                <a href="shop.html">
                    T-Shirt
                </a>

                <a href="shop.html">
                    Pants
                </a>

                <a href="shop.html">
                    Jackets
                </a>

            </div>



            <!-- HELP -->

            <div class="footer-column">

                <h3>

                    HELP

                </h3>

                <a href="#">
                    FAQ
                </a>

                <a href="#">
                    Shopping
                </a>

                <a href="#">
                    Returns
                </a>

                <a href="contact.html">
                    Contact
                </a>

            </div>



            <!-- COMPANY -->

            <div class="footer-column">

                <h3>

                    COMPANY

                </h3>

                <a href="#">
                    About Us
                </a>

                <a href="#">
                    Privacy Policy
                </a>

                <a href="#">
                    Terms of Service
                </a>

            </div>



            <!-- FOLLOW US -->

            <div class="footer-column">

                <h3>

                    FOLLOW US

                </h3>


                <div class="social-icons">


                    <!-- INSTAGRAM -->

                    <a href="#">

                        <svg viewBox="0 0 24 24">

                            <rect
                                x="3"
                                y="3"
                                width="18"
                                height="18"
                                rx="5">
                            </rect>

                            <circle
                                cx="12"
                                cy="12"
                                r="4">
                            </circle>

                            <circle
                                cx="17.5"
                                cy="6.5"
                                r="1">
                            </circle>

                        </svg>

                    </a>



                    <!-- TIKTOK -->

                    <a href="#">

                        <svg viewBox="0 0 24 24">

                            <path
                                d="M14 4v10.5a4 4 0 1 1-4-4">
                            </path>

                            <path
                                d="M14 4c1.2 2 2.8 3 5 3">
                            </path>

                        </svg>

                    </a>



                    <!-- YOUTUBE -->

                    <a href="#">

                        <svg viewBox="0 0 24 24">

                            <rect
                                x="3"
                                y="6"
                                width="18"
                                height="12"
                                rx="3">
                            </rect>

                            <polygon
                                points="10,9 16,12 10,15">
                            </polygon>

                        </svg>

                    </a>



                    <!-- FACEBOOK -->

                    <a href="#">

                        <svg viewBox="0 0 24 24">

                            <path
                                d="M14 8h3V4h-3c-3 0-5 2-5 5v3H6v4h3v5h4v-5h3l1-4h-4V9c0-.7.3-1 1-1z">
                            </path>

                        </svg>

                    </a>

                </div>

            </div>


        </div>

    </footer>


</body>

</html>