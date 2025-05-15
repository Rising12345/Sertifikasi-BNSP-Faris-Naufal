<?php
include "../config.php";

$message = '';
$success = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username sudah digunakan
    $cekQuery = "SELECT * FROM admin WHERE username = '$username'";
    $cekResult = mysqli_query($conn, $cekQuery);

    if (mysqli_num_rows($cekResult) > 0) {
        $message = "Username sudah digunakan. Silahkan gunakan username lain.";
        $success = false;
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Simpan ke database
        $query = "INSERT INTO admin (username, password) VALUES ('$username', '$hashedPassword')";

        if (mysqli_query($conn, $query)) {
            $message = "Registrasi berhasil.";
            $success = true;
        } else {
            $message = "Gagal registrasi: " . mysqli_error($conn);
            $success = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Registrasi</title>
    <style>
        body {
            background-color: #f2fdf6;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .message {
            font-size: 18px;
            color:
                <?php echo $success ? '#01b085' : '#cc0000'; ?>
            ;
            margin-bottom: 24px;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            margin: 5px;
            background-color: #01b085;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #019376;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message">
            <?php echo $message; ?>
        </div>

        <?php if ($success): ?>
            <a href="login.php" class="button">← Kembali ke Login</a>
        <?php else: ?>
            <a href="register.php" class="button">← Kembali ke Register</a>
        <?php endif; ?>
    </div>
</body>

</html>