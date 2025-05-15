<?php
include "config.php";
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login User</title>
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
            background-color: #019376;
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
            $password = $_POST['password'];

            $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
            $user = mysqli_fetch_assoc($result);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['username'];
                $_SESSION['user_id'] = $user['id_user'];
                header("Location: index.php");
                exit;
            } else {
                echo "<p class='message error'>Login gagal! Username atau password salah.</p>";
                echo "<a class='button' href='login_user.php'>Kembali ke Login</a>";
            }
        }
        ?>
    </div>
</body>

</html>