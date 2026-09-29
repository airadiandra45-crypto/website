<?php

require_once "koneksi.php";

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if ($name === "" || $email === "" || $password === "" || $confirmPassword === "") {
        $message = "Semua field harus diisi.";
        $messageType = "error";

    } elseif (strlen($name) < 3) {
        $message = "Nama minimal 3 karakter.";
        $messageType = "error";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format email tidak valid.";
        $messageType = "error";

    } elseif (strlen($password) < 6) {
        $message = "Password minimal 6 karakter.";
        $messageType = "error";

    } elseif ($password !== $confirmPassword) {
        $message = "Password dan konfirmasi password tidak sama.";
        $messageType = "error";

    } else {

        $check = mysqli_prepare(
            $koneksi,
            "SELECT id FROM users WHERE email = ? LIMIT 1"
        );

        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {

            $message = "Email sudah terdaftar.";
            $messageType = "error";
            mysqli_stmt_close($check);

        } else {

            mysqli_stmt_close($check);

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $insert = mysqli_prepare(
                $koneksi,
                "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $insert,
                "sss",
                $name,
                $email,
                $hashedPassword
            );

            if (mysqli_stmt_execute($insert)) {

                mysqli_stmt_close($insert);

                header("Location: login.php?registered=1");
                exit;

            } else {

                $message = "Registrasi gagal. Silakan coba lagi.";
                $messageType = "error";

                mysqli_stmt_close($insert);
            }
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
        content="width=device-width, initial-scale=1.0">

    <title>Norelle - Create Account</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">

    <style>

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
            background: #ffffff;
            color: #302F2F;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .logo {
            font-family: "Playfair Display", serif;
            font-size: 42px;
            font-weight: 700;
            color: #302F2F;
        }

        /* =========================
           REGISTER
        ========================= */

        .register-section {
            min-height: calc(100vh - 88px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 55px 20px;
            background: #f8f8f8;
        }

        .register-container {
            width: 100%;
            max-width: 470px;
            background: #ffffff;
            border: 1px solid #dddddd;
            padding: 42px;
        }

        .register-title {
            font-family: "Playfair Display", serif;
            font-size: 36px;
            text-align: center;
            color: #302F2F;
            margin-bottom: 8px;
        }

        .register-subtitle {
            text-align: center;
            font-size: 13px;
            color: #777777;
            margin-bottom: 30px;
        }

        .message {
            padding: 11px;
            font-size: 12px;
            margin-bottom: 18px;
            text-align: center;
        }

        .error-message {
            background: #f8eeee;
            border: 1px solid #e0caca;
            color: #9a3333;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            height: 48px;
            padding: 0 14px;
            border: 1px solid #cccccc;
            outline: none;
            font-size: 14px;
            color: #302F2F;
            background: #ffffff;
        }

        .form-group input:focus {
            border-color: #302F2F;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 50px;
        }

        .show-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 16px;
            color: #555555;
        }

        .terms {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 12px;
            color: #666666;
            margin: 20px 0 24px;
            line-height: 1.5;
        }

        .terms input {
            margin-top: 2px;
            cursor: pointer;
        }

        .terms a {
            color: #302F2F;
            text-decoration: underline;
        }

        .register-button {
            width: 100%;
            height: 48px;
            border: none;
            background: #302F2F;
            color: #ffffff;
            font-size: 13px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: .3s;
        }

        .register-button:hover {
            background: #444444;
        }

        .login-text {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: #777777;
        }

        .login-text a {
            color: #302F2F;
            font-weight: bold;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .logo {
                font-size: 34px;
            }
        }

        @media (max-width: 650px) {

            .logo {
                font-size: 30px;
            }

            .register-section {
                min-height: calc(100vh - 70px);
                padding: 30px 15px;
            }

            .register-container {
                padding: 30px 25px;
            }
        }

    </style>

</head>

<body>


    </header>


    <!-- =========================
         REGISTER
    ========================= -->

    <main class="register-section">

        <div class="register-container">

            <h1 class="register-title">
                Create Account
            </h1>

            <p class="register-subtitle">
                Create your Norelle account
            </p>


            <?php if ($message !== ""): ?>

                <div class="message error-message">

                    <?php
                    echo htmlspecialchars($message);
                    ?>

                </div>

            <?php endif; ?>


            <form
                id="registerForm"
                method="POST"
                action="registrasi.php">


                <!-- NAME -->

                <div class="form-group">

                    <label for="name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Enter your full name"
                        value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                        required>

                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Enter your email"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        required>

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Create a password"
                            required>

                        <button
                            type="button"
                            class="show-password"
                            onclick="togglePassword('password', this)">

                            👁

                        </button>

                    </div>

                </div>


                <!-- CONFIRM PASSWORD -->

                <div class="form-group">

                    <label for="confirmPassword">
                        Confirm Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="confirm_password"
                            id="confirmPassword"
                            placeholder="Confirm your password"
                            required>

                        <button
                            type="button"
                            class="show-password"
                            onclick="togglePassword('confirmPassword', this)">

                            👁

                        </button>

                    </div>

                </div>


                <!-- TERMS -->

                <label class="terms">

                    <input
                        type="checkbox"
                        name="terms"
                        id="terms"
                        required>

                    <span>

                        I agree to the
                        <a href="#">Terms of Service</a>
                        and
                        <a href="#">Privacy Policy</a>.

                    </span>

                </label>


                <!-- BUTTON -->

                <button
                    type="submit"
                    class="register-button">

                    CREATE ACCOUNT

                </button>

            </form>


            <!-- LOGIN -->

            <div class="login-text">

                Already have an account?

                <a href="login.php">
                    Login
                </a>

            </div>

        </div>

    </main>


    <script>

        function togglePassword(inputId, button) {

            const input =
                document.getElementById(inputId);

            if (input.type === "password") {

                input.type = "text";

                button.textContent = "◉";

            } else {

                input.type = "password";

                button.textContent = "👁";

            }

        }

    </script>

</body>

</html>
