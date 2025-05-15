<?php
session_start();
include "../config.php";

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['username'] = $admin['username'];
        header("Location: index.php");
        exit;
    } else {
        $loginError = "Login gagal. Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Gagal</title>
    <style>
        body {
            background-color: #f2fdf6;
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
        }

        .container {
            display: inline-block;
            padding: 25px 35px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .message {
            font-size: 18px;
            color: #cc0000;
            margin-bottom: 24px;
        }

        .back-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #01b085;
            ;
            e;
            /* Warna hijau Tokopedia */
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: rgb(1, 97, 73);
            /* Hijau kebiruan saat hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message">Login gagal. Username atau password salah.</div>
        <a href="login.php" class="back-button">← Kembali ke Login Administrator</a>
    </div>
</body>

</html>