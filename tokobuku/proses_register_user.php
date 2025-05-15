<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Proses Registrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            padding: 50px;
        }

        .container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            margin: auto;
        }

        h2 {
            color: #01b085;
        }

        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #01b085;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        a.button:hover {
            background-color: #01b085;
        }

        .message {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $nama_lengkap = $_POST['nama_lengkap'];
            $no_telepon = $_POST['no_telepon'];
            $alamat = $_POST['alamat'];

            $cek = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
            if (mysqli_num_rows($cek) > 0) {
                echo "<p class='message error'>Username sudah digunakan!</p>";
            } else {
                $query = "INSERT INTO user (username, password, nama_lengkap, no_telepon, alamat) 
                      VALUES ('$username', '$password', '$nama_lengkap', '$no_telepon', '$alamat')";
                if (mysqli_query($conn, $query)) {
                    echo "<p class='message'>Registrasi berhasil!</p>";
                    echo "<a class='button' href='login_user.php'>Login di sini</a>";
                } else {
                    echo "<p class='message error'>Registrasi gagal!</p>";
                }
            }
        }
        ?>
        <br>
        <a class="button" href="register_user.php">Kembali ke Register</a>
    </div>
</body>

</html>