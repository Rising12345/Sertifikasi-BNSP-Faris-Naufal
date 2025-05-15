<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Admin Varian Bookstore</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f8fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-box {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .register-box h2 {
            color: #01b085;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .btn-register {
            background-color: #01b085;
            border: none;
        }

        .btn-register:hover {
            background-color: #019a74;
        }

        .form-label {
            font-weight: bold;
        }

        .text-login {
            margin-top: 1rem;
            text-align: center;
        }

        .text-login a {
            color: #01b085;
            text-decoration: none;
        }

        .text-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="register-box">
        <h2>Admin Registration</h2>
        <form action="proses_register.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-register text-white">Register</button>
            </div>
        </form>

        <div class="text-login">
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>