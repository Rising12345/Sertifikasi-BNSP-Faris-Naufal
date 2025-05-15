<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id']) || !isset($_GET['id_pesanan'])) {
    header("Location: index.php");
    exit;
}

$id_pesanan = (int) $_GET['id_pesanan'];
$query = mysqli_query($conn, "
    SELECT * FROM pesanan 
    WHERE id_pesanan = $id_pesanan 
    AND id_user = {$_SESSION['user_id']}
");
$pesanan = mysqli_fetch_assoc($query);

if (!$pesanan) {
    die("Pesanan tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Konfirmasi Pesanan</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333;">
    <h2 style="color: #01b085;">Pesanan Berhasil Dibuat!</h2>
    <p>ID Pesanan: <strong><?php echo $pesanan['id_pesanan']; ?></strong></p>
    <p>Total: <strong>Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></strong></p>
    <p>Status: <strong><?php echo ucfirst(str_replace('_', ' ', $pesanan['status'])); ?></strong></p>
    <p>Metode Pembayaran: <strong><?php echo strtoupper($pesanan['metode_pembayaran']); ?></strong></p>

    <?php if ($pesanan['metode_pembayaran'] == 'transfer_bank'): ?>
        <div style="border: 1px solid #01b085; padding: 15px; margin-top: 20px; background-color: #f2fdfa;">
            <h3 style="color: #01b085;">Instruksi Pembayaran</h3>
            <p>Transfer ke: <strong>BANK BCA (11112222333344)</strong></p>
            <p>Jumlah: <strong>Rp <?php echo number_format($pesanan['total'], 0, ',', '.'); ?></strong></p>
            <p>Kode Referensi: <strong style="color: #01b085;">ORDER-<?php echo $pesanan['id_pesanan']; ?></strong></p>
        </div>
    <?php endif; ?>

    <a href="index.php" style="display: inline-block; margin-top: 20px; color: #01b085; text-decoration: none;">Kembali
        ke Beranda</a>
</body>

</html>