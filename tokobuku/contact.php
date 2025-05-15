<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Varian Bookstore</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 30px 20px;
            background-color: #fefefe;
            color: #333;
            line-height: 1.8;
        }

        h1 {
            color: #01b085;
            margin-bottom: 20px;
            text-align: center;
        }

        .contact-box {
            background-color: #f2fdfa;
            border-left: 5px solid #01b085;
            padding: 25px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .contact-info {
            margin-bottom: 20px;
        }

        .contact-info h2 {
            color: #029677;
            margin-top: 0;
            font-size: 1.3em;
        }

        .contact-method {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .contact-icon {
            margin-right: 15px;
            color: #01b085;
            font-size: 1.5em;
            width: 30px;
            text-align: center;
        }

        .btn-back {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 24px;
            background-color: #01b085;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn-back:hover {
            background-color: #029677;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <h1>Hubungi Varian Bookstore</h1>

    <div class="contact-box">
        <div class="contact-info">
            <h2>Informasi Kontak</h2>

            <div class="contact-method">
                <div class="contact-icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div>
                    <strong>Telepon:</strong> 0811-1111-2222
                </div>
            </div>

            <div class="contact-method">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <strong>Email:</strong> info@varianbookstore.com
                </div>
            </div>

            <div class="contact-method">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <strong>Alamat:</strong> Jl. Buku No. 123, Jakarta Selatan
                </div>
            </div>

            <div class="contact-method">
                <div class="contact-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <strong>Jam Operasional:</strong> Senin-Minggu, 09.00-21.00 WIB
                </div>
            </div>
        </div>

        <div class="contact-info">
            <h2>Media Sosial</h2>

            <div class="contact-method">
                <div class="contact-icon">
                    <i class="fab fa-instagram"></i>
                </div>
                <div>
                    <strong>Instagram:</strong> @varianbookstore
                </div>
            </div>

            <div class="contact-method">
                <div class="contact-icon">
                    <i class="fab fa-facebook-f"></i>
                </div>
                <div>
                    <strong>Facebook:</strong> Varian Bookstore
                </div>
            </div>

            <div class="contact-method">
                <div class="contact-icon">
                    <i class="fab fa-twitter"></i>
                </div>
                <div>
                    <strong>Twitter:</strong> @varianbookstore
                </div>
            </div>
        </div>
    </div>

    <a href="index.php" class="btn-back">Kembali ke Beranda</a>
</body>

</html>