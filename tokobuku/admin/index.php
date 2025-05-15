<?php
session_start();
include "../config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Proses saat form disubmit
if (isset($_POST['submit'])) {
    $nama_produk = $_POST['nama_produk'];
    $kategori_produk = $_POST['kategori_produk'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $upload_dir = "uploads/";

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $gambar_path = $upload_dir . basename($gambar);

    if (move_uploaded_file($tmp_name, $gambar_path)) {
        $query = "INSERT INTO produk (nama_produk, kategori_produk, gambar, harga, deskripsi, stok) 
                  VALUES ('$nama_produk', '$kategori_produk', '$gambar', '$harga', '$deskripsi', '$stok')";

        if (mysqli_query($conn, $query)) {
            echo "<div class='alert alert-success mt-3'>Produk berhasil ditambahkan!</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning mt-3'>Gagal upload gambar.</div>";
    }
}

// Add new category
if (isset($_POST['add_category'])) {
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);

    $query = "INSERT INTO kategori_buku (nama_kategori) VALUES ('$nama_kategori')";
    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success mt-3'>Kategori berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Edit category
if (isset($_POST['edit_category'])) {
    $id_kategori = $_POST['id_kategori'];
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);

    $query = "UPDATE kategori_buku SET nama_kategori = '$nama_kategori' WHERE id_kategori = $id_kategori";
    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success mt-3'>Kategori berhasil diperbarui!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Delete category
if (isset($_GET['delete_category'])) {
    $id_kategori = $_GET['delete_category'];

    // Check if category is used in any products
    $check_query = "SELECT COUNT(*) as total FROM produk WHERE kategori_produk IN (SELECT nama_kategori FROM kategori_buku WHERE id_kategori = $id_kategori)";
    $check_result = mysqli_query($conn, $check_query);
    $check_data = mysqli_fetch_assoc($check_result);

    if ($check_data['total'] > 0) {
        echo "<div class='alert alert-danger mt-3'>Kategori tidak dapat dihapus karena masih digunakan oleh beberapa produk!</div>";
    } else {
        $query = "DELETE FROM kategori_buku WHERE id_kategori = $id_kategori";
        if (mysqli_query($conn, $query)) {
            echo "<div class='alert alert-success mt-3'>Kategori berhasil dihapus!</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Get all categories for dropdown
$query_kategori = "SELECT * FROM kategori_buku ORDER BY nama_kategori";
$result_kategori = mysqli_query($conn, $query_kategori);
$kategori_options = '';
while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
    $kategori_options .= "<option value='{$row_kategori['nama_kategori']}'>{$row_kategori['nama_kategori']}</option>";
}

// Get all categories for management table
$query_kategori_table = "SELECT * FROM kategori_buku ORDER BY nama_kategori";
$result_kategori_table = mysqli_query($conn, $query_kategori_table);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tokobuku - Admin Console</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f8fb;
            color: #333;
        }

        .navbar {
            background-color: #01b085;
        }

        .navbar-brand,
        .navbar-text {
            color: white;
        }

        .navbar a:hover {
            color: #01b085;
        }

        .btn-primary {
            background-color: #01b085;
            border-color: #01b085;
        }

        .btn-primary:hover {
            background-color: #019a74;
            border-color: #019a74;
        }

        .form-control,
        .form-control-file,
        select {
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .table {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: center;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        .table-bordered td,
        .table-bordered th {
            border-color: #ddd;
        }

        .container {
            margin-top: 30px;
        }

        h2 {
            font-weight: bold;
            color: #333;
        }

        .form-group label {
            font-weight: bold;
        }

        .navbar .navbar-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.875rem;
        }

        /* Modal styles */
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background-color: #01b085;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .modal-footer {
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid d-flex justify-content-between">
                <a class="navbar-brand" href="#">Dashboard Varian Bookstore</a>
                <div class="d-flex align-items-center">
                    <span class="navbar-text mr-3">Halo admin <?php echo $_SESSION['username'] ?></span>
                    <a href="login.php?logout=true"
                        class="btn btn-light btn-sm text-success font-weight-bold">Logout</a>
                </div>
            </div>
        </nav>

        <!-- Category Management Section -->
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Manajemen Kategori Buku</h2>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">
                    Tambah Kategori
                </button>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result_kategori_table) > 0):
                        mysqli_data_seek($result_kategori_table, 0); // Reset pointer
                        while ($row = mysqli_fetch_assoc($result_kategori_table)):
                            ?>
                            <tr>
                                <td><?= $row['id_kategori'] ?></td>
                                <td><?= $row['nama_kategori'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editCategoryModal<?= $row['id_kategori'] ?>">
                                        Edit
                                    </button>
                                    <a href="?delete_category=<?= $row['id_kategori'] ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Category Modal -->
                            <div class="modal fade" id="editCategoryModal<?= $row['id_kategori'] ?>" tabindex="-1" role="dialog"
                                aria-labelledby="editCategoryModalLabel<?= $row['id_kategori'] ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCategoryModalLabel<?= $row['id_kategori'] ?>">Edit
                                                Kategori</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_kategori" value="<?= $row['id_kategori'] ?>">
                                                <div class="form-group">
                                                    <label for="nama_kategori">Nama Kategori</label>
                                                    <input type="text" class="form-control" id="nama_kategori"
                                                        name="nama_kategori" value="<?= $row['nama_kategori'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Tutup</button>
                                                <button type="submit" name="edit_category" class="btn btn-primary">Simpan
                                                    Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; else: ?>
                        <tr>
                            <td colspan="3">Tidak ada data kategori.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
            aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_kategori">Nama Kategori</label>
                                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="add_category" class="btn btn-primary">Tambah Kategori</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Form untuk Menambah Produk -->
        <div class="mt-4">
            <h2>Tambah Produk</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama_produk">Nama Produk:</label>
                    <input type="text" class="form-control" name="nama_produk" id="nama_produk" required>
                </div>

                <div class="form-group">
                    <label for="kategori_produk">Kategori Produk:</label>
                    <select class="form-control" name="kategori_produk" id="kategori_produk" required>
                        <?php echo $kategori_options; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Produk:</label>
                    <input type="file" class="form-control-file" name="gambar" id="gambar" required>
                </div>

                <div class="form-group">
                    <label for="harga">Harga:</label>
                    <input type="number" class="form-control" name="harga" id="harga" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi:</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" required></textarea>
                </div>

                <div class="form-group">
                    <label for="stok">Stok:</label>
                    <input type="number" class="form-control" name="stok" id="stok" required>
                </div>

                <button type="submit" class="btn btn-primary" name="submit">Tambah Produk</button>
            </form>
        </div>

        <!-- Tabel Produk -->
        <div class="mt-4">
            <h2>Data Produk</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Gambar</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query_produk = "SELECT * FROM produk";
                    $result_produk = mysqli_query($conn, $query_produk);

                    if (mysqli_num_rows($result_produk) > 0):
                        while ($row_produk = mysqli_fetch_assoc($result_produk)):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row_produk['nama_produk']; ?></td>
                                <td><?php echo $row_produk['kategori_produk']; ?></td>
                                <td><img src="uploads/<?php echo $row_produk['gambar']; ?>" width="50"></td>
                                <td>Rp <?php echo number_format($row_produk['harga'], 0, ',', '.'); ?></td>
                                <td><?php echo $row_produk['deskripsi']; ?></td>
                                <td><?php echo $row_produk['stok']; ?></td>
                                <td>
                                    <a href="edit_produk.php?id=<?php echo $row_produk['id_produk']; ?>"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <a href="hapus_produk.php?id=<?php echo $row_produk['id_produk']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin hapus produk ini?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                        <tr>
                            <td colspan="8">Tidak ada data produk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tabel User -->
        <div class="mt-4">
            <h2>Data User</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>No Telp</th>
                        <th>Alamat</th>
                        <th>Dibuat Pada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query_user = "SELECT * FROM user";
                    $result_user = mysqli_query($conn, $query_user);

                    if (mysqli_num_rows($result_user) > 0):
                        while ($row_user = mysqli_fetch_assoc($result_user)):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row_user['username']; ?></td>
                                <td><?php echo $row_user['nama_lengkap']; ?></td>
                                <td><?php echo $row_user['no_telepon']; ?></td>
                                <td><?php echo $row_user['alamat']; ?></td>
                                <td><?php echo $row_user['created_at']; ?></td>
                            </tr>
                        <?php endwhile; else: ?>
                        <tr>
                            <td colspan="6">Tidak ada data user.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <h2>Data Pesanan</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query_pesanan = "SELECT pesanan.*, user.username FROM pesanan JOIN user ON pesanan.id_user = user.id_user ORDER BY pesanan.created_at DESC";
                    $result_pesanan = mysqli_query($conn, $query_pesanan);

                    if (mysqli_num_rows($result_pesanan) > 0):
                        while ($row = mysqli_fetch_assoc($result_pesanan)):
                            ?>
                            <tr>
                                <td><?= $row['id_pesanan'] ?></td>
                                <td><?= $row['username'] ?></td>
                                <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                                <td>
                                    <form action="update_status.php" method="POST">
                                        <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                                        <select name="status" onchange="this.form.submit()"
                                            class="form-control form-control-sm">
                                            <option value="pending" <?= ($row['status'] == 'pending') ? 'selected' : '' ?>>Pending
                                            </option>
                                            <option value="diproses" <?= ($row['status'] == 'diproses') ? 'selected' : '' ?>>
                                                Diproses</option>
                                            <option value="dikirim" <?= ($row['status'] == 'dikirim') ? 'selected' : '' ?>>Dikirim
                                            </option>
                                            <option value="selesai" <?= ($row['status'] == 'selesai') ? 'selected' : '' ?>>Selesai
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                <td><a href="detail_pesanan.php?id=<?= $row['id_pesanan'] ?>"
                                        class="btn btn-info btn-sm">Detail</a></td>
                            </tr>
                        <?php endwhile; else: ?>
                        <tr>
                            <td colspan="6">Tidak ada pesanan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>