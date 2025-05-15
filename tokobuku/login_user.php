<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
            color: #222;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 80px auto;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .btn-success {
            background-color: #01b085;
            border-color: #01b085;
        }

        .btn-success:hover {
            background-color: #019376;
            border-color: #019376;
        }

        .form-group label {
            font-weight: bold;
            color: #222;
        }

        h3 {
            color: #01b085;
        }

        a {
            color: #01b085;
        }

        a:hover {
            text-decoration: underline;
            color: #019376;
        }
    </style>
</head>

<body><br>
    <div class="form-container">
        <h3 class="text-center mb-4">Welcome to <br> Varian Bookstore</h3>
        <form action="proses_login_user.php" method="POST">
            <div class="form-group">
                <br>
                <label>Username:</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-success btn-block">Login</button>

            <p class="mt-3 text-center">Belum punya akun? <a href="register_user.php">Daftar di sini!</a></p>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>