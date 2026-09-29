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
   CEK CART
===================================================== */

if (
    !isset($_SESSION["checkout_cart"]) ||
    empty($_SESSION["checkout_cart"])
) {

    header("Location: cart.html");

    exit;
}


/* =====================================================
   AMBIL DATA
===================================================== */

$cart =
    $_SESSION["checkout_cart"];


$receiverName =
    trim($_POST["receiver_name"] ?? "");

$phone =
    trim($_POST["phone"] ?? "");

$address =
    trim($_POST["address"] ?? "");

$city =
    trim($_POST["city"] ?? "");

$postalCode =
    trim($_POST["postal_code"] ?? "");

$payment =
    $_POST["payment"] ?? "";


/* =====================================================
   VALIDASI
===================================================== */

if (
    $receiverName === "" ||
    $phone === "" ||
    $address === "" ||
    $city === "" ||
    $postalCode === "" ||
    $payment === ""
) {

    header("Location: checkout.php");

    exit;
}


/* =====================================================
   FUNGSI HARGA
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
   HITUNG
===================================================== */

$subtotal = 0;


foreach ($cart as $item) {

    $price =
        convertPrice(
            $item["price"] ?? 0
        );

    $quantity =
        (int) (
            $item["quantity"] ?? 1
        );

    if ($quantity < 1) {
        $quantity = 1;
    }

    $subtotal +=
        $price * $quantity;
}


$shipping = 5000;


$total =
    $subtotal +
    $shipping;


/* =====================================================
   NOMOR PESANAN
===================================================== */

$orderNumber =
    $_SESSION["order_number"]
    ??
    (
        "NRL-" .
        date("Ymd") .
        "-" .
        rand(1000, 9999)
    );


/* =====================================================
   TANGGAL
===================================================== */

date_default_timezone_set("Asia/Jakarta");

$orderDate =
    date("d/m/Y H:i");


?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Struk Pesanan - Norelle
    </title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            padding: 40px 20px;

            background: #f5f5f5;

            color: #302F2F;

            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }


        .receipt {

            width: 100%;

            max-width: 720px;

            margin: auto;

            background: white;

            border:
                1px solid #ddd;

            padding: 40px;
        }


        .brand {

            text-align: center;

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size: 42px;

            font-weight: bold;

            margin-bottom: 8px;
        }


        .receipt-title {

            text-align: center;

            font-size: 13px;

            letter-spacing: 2px;

            margin-bottom: 30px;

            color: #666;
        }


        .line {

            border-top:
                1px solid #ddd;

            margin: 20px 0;
        }


        .order-info {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 20px;

            font-size: 13px;
        }


        .label {

            color: #777;

            font-size: 11px;

            margin-bottom: 5px;

            text-transform: uppercase;
        }


        .value {

            font-weight: bold;

        }


        .section-title {

            font-size: 16px;

            font-weight: bold;

            margin: 25px 0 15px;
        }


        .product {

            display: grid;

            grid-template-columns:
                75px 1fr auto;

            gap: 15px;

            align-items: center;

            padding: 15px 0;

            border-bottom:
                1px solid #eee;
        }


        .product-image {

            width: 75px;

            height: 90px;

            background: #f5f5f5;

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

            font-size: 14px;

            font-weight: bold;

            margin-bottom: 7px;
        }


        .product-detail {

            font-size: 12px;

            color: #666;

            line-height: 1.6;
        }


        .product-price {

            font-size: 13px;

            font-weight: bold;

            text-align: right;
        }


        .summary {

            margin-top: 20px;
        }


        .summary-row {

            display: flex;

            justify-content: space-between;

            padding: 8px 0;

            font-size: 13px;
        }


        .total {

            display: flex;

            justify-content: space-between;

            border-top:
                1px solid #777;

            padding-top: 18px;

            margin-top: 10px;

            font-size: 18px;

            font-weight: bold;
        }


        .shipping-info {

            background: #f7f7f7;

            padding: 18px;

            margin-top: 25px;

            font-size: 13px;

            line-height: 1.7;
        }


        .payment-box {

            border:
                1px solid #ddd;

            padding: 20px;

            margin-top: 20px;
        }


        .payment-box h3 {

            margin: 0 0 12px;

            font-size: 15px;
        }


        .bank-number {

            font-size: 20px;

            font-weight: bold;

            letter-spacing: 1px;

            margin: 8px 0;
        }


        .cod-text {

            font-size: 13px;

            line-height: 1.6;
        }


        .thank-you {

            text-align: center;

            margin-top: 30px;

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size: 18px;
        }


        .actions {

            display: flex;

            gap: 10px;

            margin-top: 25px;
        }


        .actions button,
        .actions a {

            flex: 1;

            height: 48px;

            border: none;

            display: flex;

            align-items: center;

            justify-content: center;

            text-decoration: none;

            font-size: 12px;

            font-weight: bold;

            cursor: pointer;
        }


        .home-btn {

            background: #302F2F;

            color: white;
        }


        .print-btn {

            background: #eee;

            color: #302F2F;

        }


        @media print {

            body {

                background: white;

                padding: 0;
            }


            .receipt {

                border: none;

                max-width: none;
            }


            .actions {

                display: none;
            }

        }


        @media (max-width: 600px) {

            .receipt {

                padding: 25px 18px;
            }


            .order-info {

                grid-template-columns: 1fr;
            }


            .product {

                grid-template-columns:
                    65px 1fr;
            }


            .product-price {

                grid-column: 2;

                text-align: left;
            }

        }

    </style>

</head>


<body>


<div class="receipt">


    <!-- =========================================
         BRAND
    ========================================== -->

    <div class="brand">
        Norelle
    </div>


    <div class="receipt-title">
        STRUK PESANAN
    </div>


    <div class="line"></div>


    <!-- =========================================
         ORDER INFO
    ========================================== -->

    <div class="order-info">


        <div>

            <div class="label">
                Nomor Pesanan
            </div>

            <div class="value">
                <?= htmlspecialchars($orderNumber) ?>
            </div>

        </div>


        <div>

            <div class="label">
                Tanggal
            </div>

            <div class="value">
                <?= htmlspecialchars($orderDate) ?>
            </div>

        </div>


        <div>

            <div class="label">
                Metode Pembayaran
            </div>

            <div class="value">
                <?= htmlspecialchars($payment) ?>
            </div>

        </div>


        <div>

            <div class="label">
                Status
            </div>

            <div class="value">
                Pesanan Dibuat
            </div>

        </div>


    </div>


    <div class="line"></div>


    <!-- =========================================
         PRODUK
    ========================================== -->

    <div class="section-title">
        Detail Produk
    </div>


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


        <div class="product">


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

                    <br>

                    Color:
                    <?= htmlspecialchars($color) ?>

                    <br>

                    Quantity:
                    <?= $quantity ?>

                </div>


            </div>


            <div class="product-price">

                <?= rupiah($itemTotal) ?>

            </div>


        </div>


    <?php endforeach; ?>


    <!-- =========================================
         SUMMARY
    ========================================== -->

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
                Ongkir
            </span>

            <span>
                <?= rupiah($shipping) ?>
            </span>

        </div>


        <div class="total">

            <span>
                TOTAL
            </span>

            <span>
                <?= rupiah($total) ?>
            </span>

        </div>


    </div>


    <!-- =========================================
         ALAMAT
    ========================================== -->

    <div class="shipping-info">

        <strong>
            Informasi Pengiriman
        </strong>

        <br><br>

        <strong>
            <?= htmlspecialchars($receiverName) ?>
        </strong>

        <br>

        <?= htmlspecialchars($phone) ?>

        <br>

        <?= nl2br(
            htmlspecialchars($address)
        ) ?>

        <br>

        <?= htmlspecialchars($city) ?>,
        <?= htmlspecialchars($postalCode) ?>

    </div>


    <!-- =========================================
         PAYMENT
    ========================================== -->

    <?php if ($payment === "Transfer Bank"): ?>


        <div class="payment-box">

            <h3>
                Pembayaran Transfer Bank
            </h3>


            <div>
                Silakan lakukan pembayaran
                ke rekening berikut:
            </div>


            <br>


            <strong>
                Bank BCA
            </strong>


            <div class="bank-number">
                1234567890
            </div>


            <div>
                a.n. Norelle
            </div>


            <br>


            <div style="font-size: 12px; color: #666;">

                Setelah melakukan pembayaran,
                simpan bukti transfer untuk
                keperluan konfirmasi pesanan.

            </div>

        </div>


    <?php else: ?>


        <div class="payment-box">

            <h3>
                Pembayaran COD
            </h3>


            <div class="cod-text">

                Pembayaran dilakukan secara
                langsung kepada kurir ketika
                pesanan diterima.


                <br><br>


                Jumlah yang harus dibayar:

                <strong>
                    <?= rupiah($total) ?>
                </strong>

            </div>

        </div>


    <?php endif; ?>


    <!-- =========================================
         THANK YOU
    ========================================== -->

    <div class="thank-you">

        Terima kasih telah berbelanja
        di Norelle.

    </div>


    <!-- =========================================
         BUTTON
    ========================================== -->

    <div class="actions">


        <a
            href="index.php"
            class="home-btn"
        >
            KEMBALI KE HOME
        </a>


    </div>


</div>


</body>

</html>