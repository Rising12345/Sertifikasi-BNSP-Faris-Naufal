<?php
include "../config.php";

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM produk WHERE id_produk = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Cek jika data tidak ditemukan
if (!$data) {
    echo "Produk tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #03ac0e;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        img {
            margin-top: 10px;
            border-radius: 8px;
        }

        button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #03ac0e;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #02890c;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Produk</h2>

        <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>">
            <input type="hidden" name="gambar_lama" value="<?php echo $data['gambar']; ?>">

            <label>Nama Produk:</label>
            <input type="text" name="nama_produk" value="<?php echo $data['nama_produk']; ?>">

            <label>Kategori:</label>
            <select name="kategori_produk" required>
                <option value="Fiksi" <?php echo ($data['kategori_produk'] == 'Fiksi') ? 'selected' : ''; ?>>Fiksi
                </option>
                <option value="Non-Fiksi" <?php echo ($data['kategori_produk'] == 'Non-Fiksi') ? 'selected' : ''; ?>>
                    Non-Fiksi</option>
                <option value="Anak" <?php echo ($data['kategori_produk'] == 'Anak') ? 'selected' : ''; ?>>Anak</option>
                <option value="Komputer" <?php echo ($data['kategori_produk'] == 'Komputer') ? 'selected' : ''; ?>>
                    Komputer</option>
                <option value="Agama" <?php echo ($data['kategori_produk'] == 'Agama') ? 'selected' : ''; ?>>Agama
                </option>
                <option value="Ekonomi" <?php echo ($data['kategori_produk'] == 'Ekonomi') ? 'selected' : ''; ?>>Ekonomi
                </option>
            </select>

            <label>Harga:</label>
            <input type="number" name="harga" value="<?php echo $data['harga']; ?>">

            <label>Deskripsi:</label>
            <textarea name="deskripsi"><?php echo $data['deskripsi']; ?></textarea>

            <label>Stok:</label>
            <input type="number" name="stok" value="<?php echo $data['stok']; ?>">

            <label>Gambar Saat Ini:</label>
            <img src="uploads/<?php echo $data['gambar']; ?>" alt="Gambar Produk" width="100">

            <label>Gambar Baru:</label>
            <input type="file" name="gambar">

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>

</body>

</html>