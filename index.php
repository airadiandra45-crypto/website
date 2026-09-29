<?php

session_start();

/* ==========================================
   CEK LOGIN
========================================== */

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {

    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Norelle - home</title>

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
            font-family: Arial, Helvetica, sans-serif;
            background: var(--white);
            color: var(--typography);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            display: block;
            width: 100%;
        }


        /* =========================================
           NAVBAR
           ========================================= */

        .navbar {
            width: 100%;
            height: 80px;
            background: var(--white);
            border-bottom: 1px solid #dddddd;

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


        /* LOGO */

        .logo {
            font-family: 
            Georgia, 
            "Times New Roman", 
            serif;

            font-size: 45px;
            font-weight: bold;

            letter-spacing: -1px;

            color: var(--typography);
        }


        /* NAV LINKS */

        .nav-links {
            display: flex;
            align-items: center;
            gap: 55px;
        }

        .nav-links a {
            font-size: 14px;
            font-weight: 500;
            position: relative;
            padding: 30px 0;
            color: var(--typography);
        }

        .nav-links a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 20px;

            width: 0;
            height: 1px;

            background: var(--typography);

            transition: 0.3s;
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }


        /* NAV ICONS */

        .nav-icons {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .nav-icon {
            width: 22px;
            height: 22px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--typography);
            transition: 0.3s;
        }

        .nav-icon:hover {
            opacity: 0.5;
        }

        .nav-icon svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
        }


        /* =========================================
           HERO
           ========================================= */

        .hero {
            width: 100%;
            height: 500px;

            position: relative;
            overflow: hidden;

            background: var(--secondary);
        }

        .hero img {
            width: 100%;
            height: 100%;

            object-fit: cover;
            object-position: center;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;

            background: linear-gradient(
                90deg,
                rgba(0,0,0,0.55),
                rgba(0,0,0,0.15),
                rgba(0,0,0,0)
            );
        }

        .hero-content {
            position: absolute;

            left: 4%;
            top: 50%;

            transform: translateY(-50%);

            color: white;

            max-width: 480px;
        }

        .hero-small {
            font-size: 14px;
            letter-spacing: 4px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .hero-title {
            font-family: Georgia, "Times New Roman", serif;

            font-size: 64px;
            line-height: 0.95;

            margin-bottom: 20px;
        }

        .hero-description {
            font-size: 16px;
            line-height: 1.6;

            max-width: 450px;
            margin-bottom: 30px;
        }

        .hero-button {
            display: inline-block;

            background: white;
            color: var(--typography);

            padding: 14px 30px;

            font-size: 13px;
            font-weight: 600;

            transition: 0.3s;
        }

        .hero-button:hover {
            background: var(--typography);
            color: white;
        }


        /* =========================================
           SECTION GENERAL
           ========================================= */

        .section {
            width: 92%;
            max-width: 1500px;
            margin: auto;

            padding: 70px 0;
        }

        .section-title {
            text-align: center;

            font-family: Georgia, "Times New Roman", serif;

            font-size: 34px;
            font-weight: bold;

            margin-bottom: 45px;

            color: var(--typography);
        }


        /* =========================================
           SHOP BY TYPE
           ========================================= */

        .type-grid {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;
        }

        .type-card {
            position: relative;

            height: 350px;

            overflow: hidden;

            background: var(--primary);

            cursor: pointer;
        }

        .type-card img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            transition: transform 0.5s ease;
        }

        .type-card:hover img {
            transform: scale(1.05);
        }

        .type-overlay {
            position: absolute;
            inset: 0;

            display: flex;
            align-items: flex-end;

            padding: 25px;

            background:
                linear-gradient(
                    transparent 45%,
                    rgba(0,0,0,0.65)
                );
        }

        .type-name {
            color: white;

            font-family: Georgia, "Times New Roman", serif;

            font-size: 25px;
            font-weight: bold;

            letter-spacing: 1px;
        }

        .type-shop {
            display: block;

            margin-top: 7px;

            font-size: 11px;
            letter-spacing: 2px;

            color: white;
        }


        /* =========================================
           TRENDING
           ========================================= */

        .trending {
            background: var(--primary);

            width: 100%;

            padding: 70px 4%;
        }

        .trending-container {
            max-width: 1500px;
            margin: auto;
        }

        .product-grid {
            display: grid;

            grid-template-columns:
                repeat(5, 1fr);

            gap: 22px;
        }

        .product-card {
            background: white;

            position: relative;

            overflow: hidden;
        }

        .product-image {
            width: 100%;
            aspect-ratio: 1 / 1;

            background: #eeeeee;

            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            transition: 0.4s;
        }

        .product-card:hover .product-image img {
            transform: scale(1.04);
        }

        .product-info {
            padding: 15px 5px 20px;
        }

        .product-name {
            font-size: 13px;
            font-weight: bold;

            margin-bottom: 7px;

            color: var(--typography);
        }

        .product-description {
            font-size: 11px;

            line-height: 1.5;

            color: var(--secondary);

            margin-bottom: 8px;
        }

        .product-price {
            font-size: 12px;
            font-weight: bold;

            color: var(--typography);
        }


        /* =========================================
           FOOTER
           ========================================= */

        footer {
            background: var(--typography);
            color: white;

            padding: 60px 4% 25px;
        }

        .footer-container {
            max-width: 1500px;
            margin: auto;

            display: grid;

            grid-template-columns:
                2fr 1fr 1fr 1fr 1fr;

            gap: 50px;
        }

        .footer-logo {
            font-family: Georgia, "Times New Roman", serif;

            font-size: 34px;
            font-weight: bold;

            margin-bottom: 15px;
        }

        .footer-description {
            color: #cccccc;

            font-size: 12px;

            line-height: 1.7;

            max-width: 220px;
        }

        .footer-title {
            font-size: 13px;
            font-weight: bold;

            margin-bottom: 20px;

            letter-spacing: 1px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            font-size: 12px;
            color: #cccccc;

            transition: 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .social-icons {
            display: flex;
            gap: 15px;
        }

        .social-icons a {
            width: 28px;
            height: 28px;

            border: 1px solid #777;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 11px;

            transition: 0.3s;
        }

        .social-icons a:hover {
            background: white;
            color: var(--typography);
        }

        .copyright {
            border-top: 1px solid #444;

            margin-top: 50px;
            padding-top: 20px;

            text-align: center;

            font-size: 11px;

            color: #999;
        }


        /* =========================================
           TABLET
           ========================================= */

        @media (max-width: 1000px) {

            .nav-links {
                gap: 25px;
            }

            .hero {
                height: 430px;
            }

            .hero-title {
                font-size: 50px;
            }

            .type-grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .product-grid {
                grid-template-columns:
                    repeat(3, 1fr);
            }

            .footer-container {
                grid-template-columns:
                    repeat(3, 1fr);
            }

        }


        /* =========================================
           MOBILE
           ========================================= */

        @media (max-width: 700px) {

            .navbar {
                height: auto;
                padding: 20px 0;
            }

            .navbar-container {
                flex-wrap: wrap;
                gap: 20px;
            }

            .logo {
                font-size: 30px;
            }

            .nav-links {
                order: 3;

                width: 100%;

                justify-content: center;

                gap: 20px;

                overflow-x: auto;
            }

            .nav-links a {
                padding: 5px 0;
                font-size: 11px;
            }

            .nav-links a::after {
                bottom: -4px;
            }

            .nav-icons {
                gap: 15px;
            }

            .hero {
                height: 500px;
            }

            .hero-content {
                left: 7%;
                right: 7%;
            }

            .hero-title {
                font-size: 46px;
            }

            .hero-description {
                font-size: 14px;
            }

            .section {
                padding: 50px 0;
            }

            .section-title {
                font-size: 28px;
            }

            .type-grid {
                grid-template-columns: 1fr;
            }

            .type-card {
                height: 300px;
            }

            .product-grid {
                grid-template-columns:
                    repeat(2, 1fr);

                gap: 15px;
            }

            .trending {
                padding: 50px 4%;
            }

            .footer-container {
                grid-template-columns: 1fr 1fr;
                gap: 35px;
            }

        }


        @media (max-width: 450px) {

            .product-grid {
                grid-template-columns: 1fr 1fr;
            }

            .footer-container {
                grid-template-columns: 1fr;
            }

            .hero-title {
                font-size: 40px;
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
        <a href="index.php" class="logo">
            Norelle
        </a>


        <!-- NAVIGATION -->
        <nav class="nav-links">

            <a href="index.php" class="active">
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
            <a href="search.html"
               class="nav-icon"
               aria-label="Search">

                <svg viewBox="0 0 24 24">
                    <circle cx="10.5"
                            cy="10.5"
                            r="5.5">
                    </circle>

                    <line x1="15"
                          y1="15"
                          x2="20"
                          y2="20">
                    </line>
                </svg>

            </a>


            <!-- PROFILE -->
            <a href="profile.php"
               class="nav-icon"
               aria-label="Profile">

                <svg viewBox="0 0 24 24">

                    <circle cx="12"
                            cy="7"
                            r="3">
                    </circle>

                    <path d="M5 21c0-4 3-7 7-7s7 3 7 7">
                    </path>

                </svg>

            </a>


            <!-- CART -->
            <a href="cart.html"
               class="nav-icon"
               aria-label="Shopping Cart">

                <svg viewBox="0 0 24 24">

                    <path d="M6 8h12l1 12H5L6 8z">
                    </path>

                    <path d="M9 8V6a3 3 0 0 1 6 0v2">
                    </path>

                </svg>

            </a>

        </div>

    </div>

</header>



<!-- =========================================
     HERO
     ========================================= -->

<section class="hero">

    <!--
        GANTI hero.jpg
        dengan nama file gambar hero kamu
    -->

    <img
        src="assets/images/wallpaper cortis.jpg"
        alt="Norelle Streetwear"
    >

    <div class="hero-overlay"></div>


    <div class="hero-content">

        <p class="hero-small">
            NORELLE STREETWEAR
        </p>

        <h1 class="hero-title">
            Elevate<br>
            Your Style
        </h1>

        <p class="hero-description">
            Modern streetwear for everyday confidence.
            Temukan gaya yang sesuai dengan setiap langkahmu.
        </p>

        <a href="shop.html"
           class="hero-button">

            SHOP NOW

        </a>

    </div>

</section>



<!-- =========================================
     SHOP BY TYPE
     ========================================= -->

<section class="section">

    <h2 class="section-title">
        Shop by Type
    </h2>


    <div class="type-grid">


        <!-- HOODIE -->

        <a href="shop.html?type=hoodie"
           class="type-card">

            <img
                src="assets/images/hoodie.jpg"
                alt="Hoodie"
            >

            <div class="type-overlay">

                <div>

                    <div class="type-name">
                        HOODIE
                    </div>

                    <span class="type-shop">
                        SHOP NOW
                    </span>

                </div>

            </div>

        </a>


        <!-- T_SHIRT -->

        <a href="shop.html?type=hoodie"
           class="type-card">

            <img
                src="assets/images/t-shirt.jpg"
                alt="T-Shirt"
            >

            <div class="type-overlay">

                <div>

                    <div class="type-name">
                        T-SHIRT
                    </div>

                    <span class="type-shop">
                        SHOP NOW
                    </span>

                </div>

            </div>

        </a>



        <!-- JACKET -->

        <a href="shop.html?type=jacket"
           class="type-card">

            <img
                src="assets/images/jacket.jpg"
                alt="Jacket"
            >

            <div class="type-overlay">

                <div>

                    <div class="type-name">
                        JACKET
                    </div>

                    <span class="type-shop">
                        SHOP NOW
                    </span>

                </div>

            </div>

        </a>



        <!-- PANTS -->

        <a href="shop.html?type=pants"
           class="type-card">

            <img
                src="assets/images/pants.jpg"
                alt="Pants"
            >

            <div class="type-overlay">

                <div>

                    <div class="type-name">
                        PANTS
                    </div>

                    <span class="type-shop">
                        SHOP NOW
                    </span>

                </div>

            </div>

        </a>



        <!-- SWEATER -->

        <a href="shop.html?type=sweater"
           class="type-card">

            <img
                src="assets/images/sweater.jpg"
                alt="Sweater"
            >

            <div class="type-overlay">

                <div>

                    <div class="type-name">
                        SWEATER
                    </div>

                    <span class="type-shop">
                        SHOP NOW
                    </span>

                </div>

            </div>

        </a>


    </div>

</section>



<!-- =========================================
     TRENDING NOW
     ========================================= -->

<section class="trending">

    <div class="trending-container">

        <h2 class="section-title">
            Trending Now
        </h2>


        <div class="product-grid">


            <!-- PRODUCT 1 -->

            <article class="product-card">

                <a href="product-detail.html">

                    <div class="product-image">

                        <img
                            src="assets/images/Trend Hoodie.jpg"
                            alt="HOODIE"
                        >

                    </div>

                    <div class="product-info">

                        <div class="product-name">
                            NORELLE
                        </div>

                        <div class="product-description">
                            Hoodie Boxy Pocket
                            Motif Paradise
                        </div>

                        <div class="product-price">
                            Rp. 300.000
                        </div>

                    </div>

                </a>

            </article>



            <!-- PRODUCT 2 -->

            <article class="product-card">

                <a href="product-detail.html">

                    <div class="product-image">

                        <img
                            src="assets/images/Trend T-Shirt.jpg"
                            alt="T-SHIRT"
                        >

                    </div>

                    <div class="product-info">

                        <div class="product-name">
                            NORELLE
                        </div>

                        <div class="product-description">
                            T Shirt Spread Light
                        </div>

                        <div class="product-price">
                            Rp. 179.000
                        </div>

                    </div>

                </a>

            </article>



            <!-- PRODUCT 3 -->

            <article class="product-card">

                <a href="product-detail.html">

                    <div class="product-image">

                        <img
                            src="assets/images/Trend T-Shirt 2.jpg"
                            alt="T-SHIRT"
                        >

                    </div>

                    <div class="product-info">

                        <div class="product-name">
                            NORELLE
                        </div>

                        <div class="product-description">
                            Core Casual Cotton Combed
                        </div>

                        <div class="product-price">
                            Rp. 68.000
                        </div>

                    </div>

                </a>

            </article>



            <!-- PRODUCT 4 -->

            <article class="product-card">

                <a href="product-detail.html">

                    <div class="product-image">

                        <img
                            src="assets/images/Trend Pants.jpg"
                            alt="Sweatpants"
                        >

                    </div>

                    <div class="product-info">

                        <div class="product-name">
                            NORELLE
                        </div>

                        <div class="product-description">
                            Sweatpants Loose
                            Baggy Fleece
                        </div>

                        <div class="product-price">
                            Rp. 105.000
                        </div>

                    </div>

                </a>

            </article>



            <!-- PRODUCT 5 -->

            <article class="product-card">

                <a href="product-detail.html">

                    <div class="product-image">

                        <img
                            src="assets/images/Trend Pants 2.jpg"
                            alt="SWEATPANTS JEANS"
                        >

                    </div>

                    <div class="product-info">

                        <div class="product-name">
                            NORELLE
                        </div>

                        <div class="product-description">
                            Tie dye - Loose Jeans
                        </div>

                        <div class="product-price">
                            Rp. 134.000
                        </div>

                    </div>

                </a>

            </article>


            <!-- PRODUCT 6 -->

            <article class="product-card">

                <a href="product-detail.html">

                    <div class="product-image">
                        
                        <img
                            src="assets/images/Trend Sweater.jpg"
                            alt="SWEATER"
                        >

                    </div>

                    <div class="product-info">

                        <div class="product-name">
                            NORELLE
                        </div>

                        <div class="product-description">
                            Cardigan Knitwear - CREWNECK MONTANA
                        </div>

                        <div class="product-price">
                            Rp. 154.000
                        </div>

                    </div>

                </a>

            </article>


            <!-- PRODUCT 7 -->

            <article class="product-card">

                <a href="product-detail.html">

                    <div class="product-image">
                        
                        <img
                            src="assets/images/Trend Sweater 2.jpg"
                            alt="SWEATER"
                        >

                    </div>

                    <div class="product-info">

                        <div class="product-name">
                            NORELLE
                        </div>

                        <div class="product-description">
                            Sweater Crewneck Rugby
                        </div>

                        <div class="product-price">
                            Rp. 113.000
                        </div>

                    </div>

                </a>

            </article>


            <!-- PRODUCT 7 -->

            <article class="product-card">

                <a href="product-detail.html">

                    <div class="product-image">
                        
                        <img
                            src="assets/images/Trend Jacket.jpg"
                            alt="JACKET"
                        >

                    </div>

                    <div class="product-info">

                        <div class="product-name">
                            NORELLE
                        </div>

                        <div class="product-description">
                            Cheongsam Track Jacket Suede Unisex
                        </div>

                        <div class="product-price">
                            Rp. 338.000
                        </div>

                    </div>

                </a>

            </article>

            <!-- PRODUCT 8 -->

            <article class="product-card">

                <a href="product-detail.html">

                    <div class="product-image">
                        
                        <img
                            src="assets/images/Trend Jacket 2.jpg"
                            alt="JACKET"
                        >

                    </div>

                    <div class="product-info">

                        <div class="product-name">
                            NORELLE
                        </div>

                        <div class="product-description">
                            Work Jacket Boxy - Basic Unisex
                        </div>

                        <div class="product-price">
                            Rp. 350.000
                        </div>

                    </div>

                </a>

            </article>

        </div>

    </div>

</section>



<!-- =========================================
     FOOTER
     ========================================= -->

<footer>

    <div class="footer-container">


        <!-- BRAND -->

        <div>

            <div class="footer-logo">
                Norelle
            </div>

            <p class="footer-description">

                Streetwear for every moment.
                Made for those who define
                their own style.

            </p>

        </div>



        <!-- SHOP -->

        <div>

            <div class="footer-title">
                SHOP
            </div>

            <ul class="footer-links">

                <li>
                    <a href="shop.html">
                        All Products
                    </a>
                </li>

                <li>
                    <a href="shop.html?type=hoodie">
                        Hoodie
                    </a>
                </li>

                <li>
                    <a href="shop.html?type=tshirt">
                        T-Shirt
                    </a>
                </li>

                <li>
                    <a href="shop.html?type=pants">
                        Pants
                    </a>
                </li>

                <li>
                    <a href="shop.html?type=jacket">
                        Jackets
                    </a>
                </li>

            </ul>

        </div>



        <!-- HELP -->

        <div>

            <div class="footer-title">
                HELP
            </div>

            <ul class="footer-links">

                <li>
                    <a href="#">
                        FAQ
                    </a>
                </li>

                <li>
                    <a href="#">
                        Shipping
                    </a>
                </li>

                <li>
                    <a href="#">
                        Returns
                    </a>
                </li>

                <li>
                    <a href="#">
                        Size Guide
                    </a>
                </li>

                <li>
                    <a href="contact.html">
                        Contact
                    </a>
                </li>

            </ul>

        </div>



        <!-- COMPANY -->

        <div>

            <div class="footer-title">
                COMPANY
            </div>

            <ul class="footer-links">

                <li>
                    <a href="#">
                        About Us
                    </a>
                </li>

                <li>
                    <a href="#">
                        Careers
                    </a>
                </li>

                <li>
                    <a href="#">
                        Privacy Policy
                    </a>
                </li>

                <li>
                    <a href="#">
                        Terms of Service
                    </a>
                </li>

            </ul>

        </div>



        <!-- FOLLOW -->

        <div>

            <div class="footer-title">
                FOLLOW US
            </div>

            <div class="social-icons">

                <a href="#">
                    IG
                </a>

                <a href="#">
                    TK
                </a>

                <a href="#">
                    YT
                </a>

                <a href="#">
                    X
                </a>

            </div>

        </div>


    </div>


    <div class="copyright">

        © 2026 Norelle. All rights reserved.

    </div>

</footer>

    <!-- =====================================================
         SCRIPT PRODUCT DETAIL
    ===================================================== -->

    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const products = document.querySelectorAll(".product-card");

        products.forEach(function (product, index) {

            const productId = index + 1;

            product.style.cursor = "pointer";

            product.addEventListener("click", function (event) {

                if (
                    event.target.closest("button") ||
                    event.target.closest(".wishlist") ||
                    event.target.closest(".add-cart")
                ) {
                    return;
                }

                window.location.href =
                    "product-detail.html?id=" + productId;

            });

        });

    });
    </script>

</body>
</html>