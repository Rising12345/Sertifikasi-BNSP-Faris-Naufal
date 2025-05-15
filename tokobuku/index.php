<?php
session_start();
include "config.php";

// untuk nampilin produk
$query = "SELECT * FROM produk";

// untuk search produk
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if (!empty($keyword)) {
    $query .= " WHERE nama_produk LIKE '%$keyword%' OR kategori_produk LIKE '%$keyword%'";
}

$result = mysqli_query($conn, $query);

// Ambil riwayat pesanan jika user sudah login
$riwayat_pesanan = [];
if (isset($_SESSION['user_id'])) {
    $query_pesanan = mysqli_query($conn, "
        SELECT * FROM pesanan 
        WHERE id_user = {$_SESSION['user_id']}
        ORDER BY created_at DESC
    ");
    while ($row = mysqli_fetch_assoc($query_pesanan)) {
        $riwayat_pesanan[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online</title>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <nav>
        <a href="#" class="logo">Logo</a>
        <ul>
            <li><a href="index.php">Produk</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div>
            <?php if (isset($_SESSION['user'])): ?>
                <span>Welcome <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                <a href="logout.php">Logout</a>
                <a href="keranjang.php">Keranjang</a>
            <?php else: ?>
                <a href="login_user.php">Login</a>
                <a href="login_user.php">Keranjang</a>
            <?php endif; ?>
        </div>
    </nav>

    <h2>Daftar Produk</h2>
    <form method="GET" action="">
        <input type="text" name="keyword" placeholder="Cari produk atau kategori..."
            value="<?php echo htmlspecialchars($keyword); ?>">
        <button type="submit">Cari</button>
    </form>

    <div class="produk-wrapper">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="produk-card">
                    <img src="admin/uploads/<?php echo htmlspecialchars($row['gambar']); ?>"
                        alt="<?php echo htmlspecialchars($row['nama_produk']); ?>" width="150">
                    <h3><?php echo htmlspecialchars($row['nama_produk']); ?></h3>
                    <p>Kategori: <?php echo htmlspecialchars($row['kategori_produk']); ?></p>
                    <p>Harga: Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                    <p>Stok: <?php echo $row['stok']; ?></p>
                    <button onclick="addToCart(<?php echo $row['id_produk']; ?>)">Add to Cart</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada produk tersedia.</p>
        <?php endif; ?>
    </div>

    <!-- Riwayat Pemesanan -->
    <?php if (isset($_SESSION['user_id']) && !empty($riwayat_pesanan)): ?>
        <div class="riwayat-pesanan">
            <h2>Riwayat Pemesanan Anda</h2>
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($riwayat_pesanan as $pesanan): ?>
                        <tr>
                            <td><?php echo $pesanan['id_pesanan']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?></td>
                            <td>Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></td>
                            <td class="status-<?php echo str_replace('_', '-', $pesanan['status']); ?>">
                                <?php
                                $status = [
                                    'pending' => 'pending',
                                    'diproses' => 'Diproses',
                                    'dikirim' => 'Dikirim',
                                    'selesai' => 'Selesai'
                                ];
                                echo $status[$pesanan['status']] ?? $pesanan['status'];
                                ?>
                            </td>
                            <td>
                                <a href="detail_pesanan_user.php?id=<?php echo $pesanan['id_pesanan']; ?>">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <script>
        function addToCart(productId) {
            <?php if (!isset($_SESSION['user_id'])): ?>
                alert("Silakan login terlebih dahulu!");
                window.location.href = "login_user.php";
            <?php else: ?>
                fetch("add_to_cart.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "id_produk=" + productId
                })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.status === "success") {
                            window.location.reload();
                        }
                    });
            <?php endif; ?>
        }
    </script>
</body>

</html>