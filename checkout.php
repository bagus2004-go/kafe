<?php 
    include 'components/connection.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = '';
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('location: login.php');
    }

    
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
    <title>Coffee Shop - halaman Pembayaran</title>
</head>
<body>
    <?php include 'components/header.php';?>
    <div class="main">
        <div class="banner">
            <h1>Pembayaran</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/Pembayaran</span>
        </div>
        <section class="checkout">
            <div class="title">
                <img src="img/download.png" class="logo">
                <h1>Ringkasan Pembayaran</h1>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
            </div>
        </section>
        <div class="row">
            <form method="post">
                <h3>rincian tagihan</h3>
                <div class="flex">
                    <div class="box">
                        <div class="input-field">
                            <p>Nama Pengguna <sup>*</sup></p>
                            <input type="text" name="name" required maxlength="100" placeholder="Masukkan nama anda" class="input">
                        </div>
                        <div class="input-field">
                            <p>No.Telpon Pengguna <sup>*</sup></p>
                            <input type="number" name="number" required maxlength="15" placeholder="Masukkan no.telpon anda" class="input">
                        </div>
                        <div class="input-field">
                            <p>Email Pengguna <sup>*</sup></p>
                            <input type="email" name="email" required maxlength="100" placeholder="Masukkan email anda" class="input">
                        </div>
                        <div class="input-field">
                            <p>Metode Pembayaran <sup>*</sup></p>
                            <select name="method" class="input">
                                <option value="cash on delivery">Cash on Delivery</option>
                                <option value="credit or debit card">Credit atau Debit Card</option>
                                <option value="E banking">E-Banking</option>
                                <option value="shopeepay or gopay">ShopeePay atau Gopay</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <p>Tipe Alamat <sup>*</sup></p>
                            <select name="address_type" class="input">
                                <option value="home">Rumah</option>
                                <option value="office">Kantor</option>
                            </select>
                        </div>
                    </div>
                    <div class="box">
                        <div class="input-field">
                            <p>Alamat Pengguna <sup>*</sup></p>
                            <input type="text" name="address" required maxlength="100" placeholder="Masukkan alamat lengkap anda" class="input">
                        </div>
                    </div>
                </div>
                <button type="submit" name="place_order" class="btn">lanjut ke pembayaran</button>
            </form>
            <div class="summary">
                <h3>tas belanja</h3>
                <div class="box-container">
                    <?php 
                        $grand_total = 0;
                        if (isset($_GET['get_id'])) {
                            $select_get = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_get->execute([$_GET['get_id']]);
                            while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                                $sub_total = ($fetch_get['price']);
                                $grand_total += $sub_total;
                    ?>
                    <div class="box">
                        <img src="image/<?= $fetch_get['image']; ?>" class="image">
                        <div>
                            <h3 class="name"><?= $fetch_get['name']; ?></h3>
                            <p class="price">Rp<?= $fetch_get['price']; ?>,-</p>
                        </div>
                    </div>
                    <?php 
                            }
                        } else {
                            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                            $select_cart->execute([$user_id]);
                            if ($select_cart->rowCount() > 0) {
                                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                    $select_products->execute([$fetch_cart['product_id']]);
                                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                                    $sub_total = ($fetch_cart['qty'] * $fetch_products['price']);
                                    $grand_total += $sub_total;
                    ?>
                    <div class="flex">
                        <img src="image/<?= $fetch_products['image']; ?>">
                        <div>
                            <h3 class="name"><?= $fetch_products['name']; ?></h3>
                            <p class="price">Rp<?= $fetch_products['price']; ?> x <?= $fetch_cart['qty']; ?></p>
                        </div>
                    </div>
                    <?php 
                                }
                            } else {
                                echo '<p class="empty">Keranjang belanja anda masih kosong</p>';
                            }
                        }
                    ?>
                </div>
                <div class="grand-total"><span>total belanja : </span>Rp<?= $grand_total ?>,-</div>
            </div>
        </div>
        <?php include 'components/footer.php';?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php';?>
</body>
</html>
