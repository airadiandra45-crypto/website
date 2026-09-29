<?php

require_once "koneksi.php";

/*
|--------------------------------------------------------------------------
| DATA ADMIN
|--------------------------------------------------------------------------
*/

$nama = "Administrator";
$username = "admin";
$password = "admin123";
$email = "admin@norelle.com";
$alamat = "Sidoarjo";
$no_telp = "081234567890";


/*
|--------------------------------------------------------------------------
| CEK USERNAME
|--------------------------------------------------------------------------
*/

$cek = mysqli_prepare(
    $koneksi,
    "SELECT id_admin FROM admin WHERE username = ?"
);

mysqli_stmt_bind_param(
    $cek,
    "s",
    $username
);

mysqli_stmt_execute($cek);
mysqli_stmt_store_result($cek);

if (mysqli_stmt_num_rows($cek) > 0) {

    echo "Admin dengan username <b>$username</b> sudah ada.";

    mysqli_stmt_close($cek);
    exit;
}

mysqli_stmt_close($cek);


/*
|--------------------------------------------------------------------------
| HASH PASSWORD
|--------------------------------------------------------------------------
*/

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);


/*
|--------------------------------------------------------------------------
| SIMPAN ADMIN
|--------------------------------------------------------------------------
*/

$query = mysqli_prepare(
    $koneksi,
    "INSERT INTO admin
    (nama, username, password, email, alamat, no_telp)
    VALUES (?, ?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $query,
    "ssssss",
    $nama,
    $username,
    $hashedPassword,
    $email,
    $alamat,
    $no_telp
);


if (mysqli_stmt_execute($query)) {

    echo "<h2>Admin berhasil dibuat.</h2>";

    echo "<p>Username: <b>$username</b></p>";
    echo "<p>Password: <b>$password</b></p>";

    echo "<p>
        Silakan lanjut ke
        <a href='admin_login.php'>Login Admin</a>
    </p>";

} else {

    echo "Gagal membuat admin: " .
         mysqli_error($koneksi);
}


mysqli_stmt_close($query);

?>