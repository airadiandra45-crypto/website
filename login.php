<?php
session_start();

require_once "koneksi.php";

$errorMessage = "";
$successMessage = "";

if (isset($_GET["registered"]) && $_GET["registered"] == "1") {
    $successMessage = "Registrasi berhasil. Silakan login.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $errorMessage = "Email dan password harus diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Format email tidak valid.";
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1"
        );

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if ($user && password_verify($password, $user["password"])) {
                session_regenerate_id(true);

                $_SESSION["login"] = true;
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];

                header("Location: index.php");
                exit;
            }

            $errorMessage = "Email atau password salah.";
        } else {
            $errorMessage = "Terjadi kesalahan pada database.";
        }
    }
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

        /* =====================================================
           LOGIN SECTION
        ====================================================== */

        .login-section {

            min-height: calc(100vh - 88px);

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 60px 20px;

            background: #f8f8f8;

        }


        /* LOGIN BOX */

        .login-container {

            width: 100%;

            max-width: 430px;

            background: #ffffff;

            padding: 45px 42px;

            border: 1px solid #dddddd;

        }


        /* TITLE */

        .login-title {

            text-align: center;

            font-family: "Playfair Display", serif;

            font-size: 34px;

            margin-bottom: 8px;

            color: #302F2F;

        }


        .login-subtitle {

            text-align: center;

            font-size: 13px;

            color: #777777;

            margin-bottom: 35px;

        }


        /* =====================================================
           FORM
        ====================================================== */

        .form-group {

            margin-bottom: 20px;

        }


        .form-group label {

            display: block;

            font-size: 13px;

            margin-bottom: 8px;

            color: #302F2F;

        }


        .form-group input {

            width: 100%;

            height: 48px;

            border: 1px solid #cccccc;

            padding: 0 14px;

            font-size: 14px;

            outline: none;

            color: #302F2F;

            background: #ffffff;

        }


        .form-group input:focus {

            border-color: #302F2F;

        }


        /* =====================================================
           PASSWORD
        ====================================================== */

        .password-wrapper {

            position: relative;

        }


        .password-wrapper input {

            padding-right: 45px;

        }


        .show-password {

            position: absolute;

            right: 14px;

            top: 50%;

            transform: translateY(-50%);

            border: none;

            background: none;

            cursor: pointer;

            font-size: 16px;

            color: #555555;

        }


        /* =====================================================
           REMEMBER + FORGOT
        ====================================================== */

        .login-options {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 25px;

            font-size: 12px;

        }


        .remember {

            display: flex;

            align-items: center;

            gap: 7px;

        }


        .remember input {

            cursor: pointer;

        }


        .forgot-password {

            color: #302F2F;

            text-decoration: none;

        }


        .forgot-password:hover {

            text-decoration: underline;

        }


        /* =====================================================
           LOGIN BUTTON
        ====================================================== */

        .login-button {

            width: 100%;

            height: 48px;

            border: none;

            background: #302F2F;

            color: #ffffff;

            font-size: 13px;

            letter-spacing: 1px;

            cursor: pointer;

            transition: 0.3s;

        }


        .login-button:hover {

            background: #444444;

        }


        /* =====================================================
           REGISTER
        ====================================================== */

        .register-text {

            text-align: center;

            margin-top: 25px;

            font-size: 13px;

            color: #777777;

        }


        .register-text a {

            color: #302F2F;

            text-decoration: none;

            font-weight: bold;

        }


        .register-text a:hover {

            text-decoration: underline;

        }


        /* =====================================================
           ERROR MESSAGE
        ====================================================== */

        .error-message {

            display: none;

            background: #f8eeee;

            border: 1px solid #e0caca;

            color: #9a3333;

            padding: 11px;

            font-size: 12px;

            margin-bottom: 20px;

            text-align: center;

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 900px) {

            .navbar {

                padding: 0 30px;

            }

            .nav-menu {

                gap: 25px;

            }

            .logo {

                font-size: 34px;

            }

        }


        @media (max-width: 650px) {

            .login-section {

                min-height: calc(100vh - 70px);

                padding: 30px 15px;

            }

            .login-container {

                padding: 35px 25px;

            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         LOGIN
    ====================================================== -->

    <main class="login-section">


        <div class="login-container">


            <h1 class="login-title">
                Welcome Back
            </h1>


            <p class="login-subtitle">
                Login to continue your journey with Norelle
            </p>


            <!-- ERROR -->

            <?php if ($errorMessage !== ""): ?>

                <div
                    class="error-message"
                    id="errorMessage"
                    style="display: block;">

                    <?php echo htmlspecialchars($errorMessage); ?>

                </div>

            <?php endif; ?>

            <?php if ($successMessage !== ""): ?>

                <div
                    class="success-message"
                    style="
                        display:block;
                        background:#eef8ef;
                        border:1px solid #c9dfcb;
                        color:#39733d;
                        padding:11px;
                        font-size:12px;
                        margin-bottom:20px;
                        text-align:center;
                    ">

                    <?php echo htmlspecialchars($successMessage); ?>

                </div>

            <?php endif; ?>


            <!-- FORM -->

            <form id="loginForm" method="POST" action="login.php">


                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
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
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required>


                        <button
                            type="button"
                            class="show-password"
                            onclick="togglePassword()">

                            👁

                        </button>

                    </div>

                </div>



                <!-- OPTIONS -->

                <div class="login-options">


                    <label class="remember">

                        <input
                            type="checkbox"
                            id="remember">

                        <span>
                            Remember me
                        </span>

                    </label>


                    <a
                        href="#"
                        class="forgot-password">

                        Forgot Password?

                    </a>


                </div>



                <!-- LOGIN -->

                <button
                    type="submit"
                    class="login-button">

                    LOGIN

                </button>


            </form>



            <!-- REGISTER -->

            <div class="register-text">

                Don't have an account?

                <a href="registrasi.php">
                    Create Account
                </a>

            </div>


        </div>

    </main>



    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->
<script>

/* =================================================
   SHOW / HIDE PASSWORD
================================================= */

function togglePassword() {

    const password =
        document.getElementById("password");

    const button =
        document.querySelector(".show-password");

    if (password.type === "password") {

        password.type = "text";
        button.textContent = "◉";

    } else {

        password.type = "password";
        button.textContent = "👁";

    }
}

</script>


</body>

</html>