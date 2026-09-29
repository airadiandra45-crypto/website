<?php

session_start();

require_once "koneksi.php";

$error = "";


/*
|--------------------------------------------------------------------------
| JIKA SUDAH LOGIN
|--------------------------------------------------------------------------
*/

if (isset($_SESSION["admin_login"]) && $_SESSION["admin_login"] === true) {

    header("Location: admin_dashboard.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| PROSES LOGIN
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";


    if ($username === "" || $password === "") {

        $error = "Username dan password wajib diisi.";

    } else {

        $query = mysqli_prepare(
            $koneksi,
            "SELECT
                id_admin,
                nama,
                username,
                password,
                email,
                alamat,
                no_telp
             FROM admin
             WHERE username = ?
             LIMIT 1"
        );

        mysqli_stmt_bind_param(
            $query,
            "s",
            $username
        );

        mysqli_stmt_execute($query);

        $result = mysqli_stmt_get_result($query);

        $admin = mysqli_fetch_assoc($result);

        mysqli_stmt_close($query);


        if ($admin && password_verify($password, $admin["password"])) {

            /*
             * SIMPAN SESSION ADMIN
             */

            $_SESSION["admin_login"] = true;

            $_SESSION["admin_id"] = $admin["id_admin"];

            $_SESSION["admin_nama"] = $admin["nama"];

            $_SESSION["admin_username"] = $admin["username"];

            $_SESSION["admin_email"] = $admin["email"];


            /*
             * MASUK DASHBOARD ADMIN
             */

            header("Location: index.php");
            exit;

        } else {

            $error = "Username atau password salah.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Login - Norelle</title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            background: #f5f5f5;

            font-family: Arial, sans-serif;

            color: #222;
        }


        .login-box {

            width: 420px;

            background: white;

            padding: 45px;

            border: 1px solid #ddd;
        }


        .logo {

            text-align: center;

            font-family: Georgia, serif;

            font-size: 42px;

            font-weight: bold;

            margin-bottom: 8px;
        }


        .subtitle {

            text-align: center;

            color: #777;

            margin-bottom: 35px;
        }


        label {

            display: block;

            margin-bottom: 8px;

            font-size: 14px;

            font-weight: bold;
        }


        input {

            width: 100%;

            height: 48px;

            padding: 0 14px;

            border: 1px solid #ccc;

            outline: none;

            margin-bottom: 20px;

            font-size: 15px;
        }


        input:focus {

            border-color: #222;
        }


        button {

            width: 100%;

            height: 50px;

            border: none;

            background: #2d2d2d;

            color: white;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;
        }


        button:hover {

            background: #111;
        }


        .error {

            background: #ffe9e9;

            color: #b00020;

            border: 1px solid #f1b5b5;

            padding: 12px;

            margin-bottom: 20px;

            font-size: 14px;
        }


        .back {

            text-align: center;

            margin-top: 25px;

            font-size: 14px;
        }


        .back a {

            color: #222;

            font-weight: bold;

            text-decoration: none;
        }

    </style>

</head>


<body>


<div class="login-box">

    <div class="logo">
        Norelle
    </div>


    <div class="subtitle">
        Admin Login
    </div>


    <?php if ($error !== ""): ?>

        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <form method="POST">

        <label>
            Username
        </label>

        <input
            type="text"
            name="username"
            placeholder="Masukkan username"
            required
        >


        <label>
            Password
        </label>

        <input
            type="password"
            name="password"
            placeholder="Masukkan password"
            required
        >


        <button type="submit">
            LOGIN ADMIN
        </button>

    </form>


    <div class="back">

        <a href="index.html">
            ← Kembali ke Norelle
        </a>

    </div>

</div>


</body>

</html>