<?php 
    include 'components/connection.php';
?>
<style type="text/css">
    <?php include 'style.css';?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Coffee Shop - halaman Kontak kami</title>
</head>
<body>
    <?php include 'components/header.php';?>
    <div class="main">
        <div class="banner">
            <h1>Kontak Kami</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/Kontak kami</span>
        </div>
        <section class="services">
            <div class="box-container">
                <div class="box">
                    <img src="img/icon.png">
                    <div class="detail">
                        <h3>penghematan besar</h3>
                        <p>hemat banyak setiap pesanan</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon1.png">
                    <div class="detail">
                        <h3>Dukungan 24*7</h3>
                        <p>dukungan satu-satu</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon2.png">
                    <div class="detail">
                        <h3>voucher hadiah</h3>
                        <p>voucher di setiap perayaan</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon3.png">
                    <div class="detail">
                        <h3>Pengiriman gratis</h3>
                        <p>pengiriman barang gratis</p>
                    </div>
                </div>
            </div>
        </section>
        <div class="form-container">
            <form method="post">
                <div class="title">
                    <img src="img/download.png" class="logo">
                    <h1>Tinggalkan pesan</h1>
                </div>
                <div class="input-field">
                    <p>Nama Pengguna <sup>*</sup></p>
                    <input type="text" name="name">
                </div>
                <div class="input-field">
                    <p>Email Pengguna <sup>*</sup></p>
                    <input type="email" name="email">
                </div>
                <div class="input-field">
                    <p>Nomor Telepon <sup>*</sup></p>
                    <input type="text" name="number">
                </div>
                <div class="input-field">
                    <p>Pesan Anda <sup>*</sup></p>
                    <textarea name="message"></textarea>
                </div>
                <button type="submit" name="submit-btn" class="btn">kirim pesan</button>
            </form>
        </div>
        <?php include 'components/footer.php';?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php';?>
</body>
</html>