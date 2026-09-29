<?php

session_start();

/* =====================================================
   CEK LOGIN
===================================================== */

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit;
}


/* =====================================================
   AMBIL CART DARI URL
===================================================== */

$cart = [];

if (isset($_GET["cart"])) {

    $decoded = json_decode(
        urldecode($_GET["cart"]),
        true
    );

    if (is_array($decoded)) {
        $cart = $decoded;
    }
}


/* =====================================================
   JIKA CART KOSONG
===================================================== */

if (empty($cart)) {
    header("Location: cart.html");
    exit;
}


/* =====================================================
   SIMPAN CART KE SESSION
   Supaya bisa digunakan oleh struk.php
===================================================== */

$_SESSION["checkout_cart"] = $cart;


/* =====================================================
   FUNGSI KONVERSI HARGA
===================================================== */

function convertPrice($price)
{
    if (is_numeric($price)) {
        return (float) $price;
    }

    $price = str_replace(
        [
            "Rp.",
            "Rp",
            "rp.",
            "rp",
            ".",
            ",",
            " "
        ],
        "",
        $price
    );

    return (float) $price;
}


/* =====================================================
   FORMAT RUPIAH
===================================================== */

function rupiah($number)
{
    return "Rp. " . number_format(
        $number,
        0,
        ",",
        "."
    );
}


/* =====================================================
   HITUNG SUBTOTAL
===================================================== */

$subtotal = 0;

foreach ($cart as $item) {

    $price = convertPrice(
        $item["price"] ?? 0
    );

    $quantity = (int) (
        $item["quantity"] ?? 1
    );

    if ($quantity < 1) {
        $quantity = 1;
    }

    $subtotal +=
        $price * $quantity;
}


/* =====================================================
   ONGKIR
===================================================== */

$shipping = 5000;


/* =====================================================
   TOTAL
===================================================== */

$total =
    $subtotal +
    $shipping;


/* =====================================================
   NOMOR PESANAN
===================================================== */

$orderNumber =
    "NRL-" .
    date("Ymd") .
    "-" .
    rand(1000, 9999);

$_SESSION["order_number"] = $orderNumber;

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Checkout - Norelle</title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f7f7f7;

            color: #302F2F;
        }


        /* HEADER */

        header {

            height: 80px;

            background: white;

            border-bottom:
                1px solid #ddd;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 6%;
        }


        .logo {

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size: 38px;

            font-weight: bold;

            color: #302F2F;

            text-decoration: none;
        }


        .back-cart {

            text-decoration: none;

            color: #302F2F;

            font-size: 14px;
        }


        /* CONTAINER */

        .checkout-container {

            width: 90%;

            max-width: 1200px;

            margin: 45px auto 70px;
        }


        .checkout-title {

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size: 40px;

            margin-bottom: 35px;
        }


        .checkout-grid {

            display: grid;

            grid-template-columns:
                1.5fr 1fr;

            gap: 30px;

            align-items: start;
        }


        .checkout-box {

            background: white;

            border:
                1px solid #ddd;

            padding: 30px;
        }


        .box-title {

            font-size: 19px;

            margin-bottom: 25px;
        }


        /* FORM */

        .form-group {

            margin-bottom: 22px;
        }


        .form-group label {

            display: block;

            font-size: 12px;

            font-weight: bold;

            margin-bottom: 9px;
        }


        .form-group input,
        .form-group textarea {

            width: 100%;

            padding: 14px;

            border:
                1px solid #ccc;

            font-size: 14px;

            outline: none;
        }


        .form-group textarea {

            min-height: 110px;

            resize: vertical;
        }


        .form-group input:focus,
        .form-group textarea:focus {

            border-color: #302F2F;
        }


        /* PAYMENT */

        .payment-title {

            font-size: 18px;

            margin: 30px 0 18px;
        }


        .payment-option {

            display: flex;

            align-items: center;

            gap: 10px;

            border:
                1px solid #ddd;

            padding: 15px;

            margin-bottom: 10px;

            cursor: pointer;

            font-size: 14px;
        }


        /* PRODUCT */

        .product-item {

            display: grid;

            grid-template-columns:
                85px 1fr;

            gap: 15px;

            padding: 18px 0;

            border-bottom:
                1px solid #eee;
        }


        .product-item:first-child {

            padding-top: 0;
        }


        .product-image {

            width: 85px;

            height: 105px;

            background: #f3f3f3;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow: hidden;
        }


        .product-image img {

            width: 100%;

            height: 100%;

            object-fit: contain;
        }


        .product-name {

            font-weight: bold;

            font-size: 14px;

            margin-bottom: 8px;
        }


        .product-detail {

            font-size: 12px;

            color: #666;

            margin-bottom: 5px;
        }


        .product-price {

            font-size: 13px;

            font-weight: bold;

            margin-top: 8px;
        }


        /* SUMMARY */

        .summary {

            margin-top: 20px;
        }


        .summary-row {

            display: flex;

            justify-content: space-between;

            padding: 10px 0;

            font-size: 14px;
        }


        .summary-total {

            display: flex;

            justify-content: space-between;

            border-top:
                1px solid #999;

            padding-top: 18px;

            margin-top: 8px;

            font-size: 18px;

            font-weight: bold;
        }


        /* BUTTON */

        .place-order {

            width: 100%;

            height: 55px;

            border: none;

            background: #302F2F;

            color: white;

            font-weight: bold;

            margin-top: 22px;

            cursor: pointer;
        }


        .place-order:hover {

            background: #444;
        }


        .note {

            text-align: center;

            color: #777;

            font-size: 10px;

            margin-top: 15px;
        }


        @media (max-width: 800px) {

            .checkout-grid {

                grid-template-columns: 1fr;
            }

            .checkout-container {

                width: 94%;
            }

        }

    </style>

</head>


<body>


<header>

    <a
        href="index.html"
        class="logo"
    >
        Norelle
    </a>


    <a
        href="cart.html"
        class="back-cart"
    >
        ← Kembali ke Keranjang
    </a>

</header>



<main class="checkout-container">


    <h1 class="checkout-title">
        Checkout
    </h1>


    <form
        action="struk.php"
        method="POST"
        id="checkoutForm"
    >

        <div class="checkout-grid">


            <!-- =====================================
                 INFORMASI PENGIRIMAN
            ====================================== -->

            <div class="checkout-box">

                <h2 class="box-title">
                    Informasi Pengiriman
                </h2>


                <div class="form-group">

                    <label>
                        NAMA PENERIMA
                    </label>

                    <input
                        type="text"
                        name="receiver_name"
                        placeholder="Masukkan nama penerima"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        NOMOR TELEPON
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        placeholder="08xxxxxxxxxx"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        ALAMAT LENGKAP
                    </label>

                    <textarea
                        name="address"
                        placeholder="Masukkan alamat lengkap..."
                        required
                    ></textarea>

                </div>


                <div class="form-group">

                    <label>
                        KOTA
                    </label>

                    <input
                        type="text"
                        name="city"
                        placeholder="Contoh: Sidoarjo"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        KODE POS
                    </label>

                    <input
                        type="text"
                        name="postal_code"
                        placeholder="612xx"
                        required
                    >

                </div>


                <h2 class="payment-title">
                    Metode Pembayaran
                </h2>


                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment"
                        value="Transfer Bank"
                        required
                    >

                    Transfer Bank

                </label>


                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment"
                        value="COD"
                    >

                    Cash on Delivery (COD)

                </label>


            </div>



            <!-- =====================================
                 RINGKASAN
            ====================================== -->

            <div class="checkout-box">

                <h2 class="box-title">
                    Ringkasan Pesanan
                </h2>


                <?php foreach ($cart as $item): ?>

                    <?php

                    $name =
                        $item["name"]
                        ?? "Produk";

                    $image =
                        $item["image"]
                        ?? "";

                    $size =
                        $item["size"]
                        ?? "-";

                    $color =
                        $item["color"]
                        ?? "-";

                    $quantity =
                        (int) (
                            $item["quantity"]
                            ?? 1
                        );

                    $price =
                        convertPrice(
                            $item["price"]
                            ?? 0
                        );

                    $itemTotal =
                        $price * $quantity;

                    ?>


                    <div class="product-item">


                        <div class="product-image">

                            <?php if ($image !== ""): ?>

                                <img
                                    src="<?= htmlspecialchars($image) ?>"
                                    alt="<?= htmlspecialchars($name) ?>"
                                >

                            <?php endif; ?>

                        </div>


                        <div>

                            <div class="product-name">

                                <?= htmlspecialchars($name) ?>

                            </div>


                            <div class="product-detail">

                                Size:
                                <?= htmlspecialchars($size) ?>

                            </div>


                            <div class="product-detail">

                                Color:
                                <?= htmlspecialchars($color) ?>

                            </div>


                            <div class="product-detail">

                                Quantity:
                                <?= $quantity ?>

                            </div>


                            <div class="product-price">

                                <?= rupiah($itemTotal) ?>

                            </div>

                        </div>

                    </div>


                <?php endforeach; ?>


                <div class="summary">


                    <div class="summary-row">

                        <span>
                            Subtotal
                        </span>

                        <span>
                            <?= rupiah($subtotal) ?>
                        </span>

                    </div>


                    <div class="summary-row">

                        <span>
                            Shipping
                        </span>

                        <span>
                            <?= rupiah($shipping) ?>
                        </span>

                    </div>


                    <div class="summary-total">

                        <span>
                            Total
                        </span>

                        <span>
                            <?= rupiah($total) ?>
                        </span>

                    </div>


                </div>


                <button
                    type="submit"
                    class="place-order"
                >
                    PLACE ORDER
                </button>


                <div class="note">

                    Dengan melakukan pemesanan,
                    kamu menyetujui ketentuan
                    pembelian Norelle.

                </div>


            </div>


        </div>

    </form>

</main>


</body>

</html>