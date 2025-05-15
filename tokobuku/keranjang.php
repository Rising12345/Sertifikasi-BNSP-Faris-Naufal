<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_user.php");
    exit;
}

// Ambil data keranjang
$query = mysqli_query($conn, "
    SELECT produk.nama_produk, produk.harga, keranjang.jumlah 
    FROM keranjang 
    JOIN produk ON keranjang.id_produk = produk.id_produk 
    WHERE keranjang.id_user = {$_SESSION['user_id']}
");

$total = 0;
$item_count = mysqli_num_rows($query);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f4f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        h2 {
            color: #01b085;
            text-align: center;
            margin-bottom: 30px;
        }

        .product-card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fafafa;
        }

        .product-card h3 {
            margin: 0 0 10px;
            color: #333;
        }

        .product-card p {
            margin: 5px 0;
            color: #555;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 20px;
            margin-top: 30px;
            color: #333;
        }

        .btn-checkout {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 30px auto 0;
            background-color: #01b085;
            color: white;
            text-decoration: none;
            text-align: center;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn-checkout:hover {
            background-color: #01806a;
        }
    </style>
    <script>
        function validateCheckout() {
            <?php if ($item_count == 0): ?>
                alert("Keranjang kosong! Tambahkan produk terlebih dahulu.");
                window.location.href = "index.php";
                return false;
            <?php else: ?>
                return true;
            <?php endif; ?>
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>Keranjang Belanja</h2>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <div class="product-card">
                <h3><?php echo $row['nama_produk']; ?></h3>
                <p>Harga: Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                <p>Jumlah: <?php echo $row['jumlah']; ?></p>
            </div>
            <?php $total += $row['harga'] * $row['jumlah']; ?>
        <?php endwhile; ?>

        <div class="total">
            Total: Rp <?php echo number_format($total, 0, ',', '.'); ?>
        </div>

        <a href="checkout.php" class="btn-checkout" onclick="return validateCheckout()">Checkout</a>
    </div>
</body>

</html>