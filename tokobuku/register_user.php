<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f8fb;
            color: #333;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .btn-primary {
            background-color: #01b085;
            border-color: #01b085;
        }

        .btn-primary:hover {
            background-color: #019a74;
            border-color: #019a74;
        }

        .form-control {
            border-radius: 6px;
        }

        h2 {
            font-weight: bold;
            color: #01b085;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6">
            <div class="card p-4">
                <h2 class="mb-4 text-center">Registrasi User</h2>
                <form action="proses_register_user.php" method="POST">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>

                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap:</label>
                        <input type="text" class="form-control" name="nama_lengkap" required>
                    </div>

                    <div class="form-group">
                        <label>No Telepon:</label>
                        <input type="number" class="form-control" name="no_telepon" required>
                    </div>

                    <div class="form-group">
                        <label>Alamat:</label>
                        <textarea class="form-control" name="alamat" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                </form>
                <p class="mt-3 text-center">
                    Sudah punya akun?
                    <a href="login_user.php">Login di sini</a>
                    <!-- ubah sesuai nama file login kamu -->
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>