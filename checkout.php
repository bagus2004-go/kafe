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

    if (isset($_POST['place_order'])) {
        if (empty($user_id)) {
            echo "<script>alert('Silakan login terlebih dahulu sebelum melakukan pemesanan.'); window.location.href='login.php';</script>";
            exit;
        }
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        if (empty($user_id)) {
            $email = $_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        } else {
            $email = '';
        }
        $address = $_POST['address'];
        $address = filter_var($address, FILTER_SANITIZE_STRING);
        $address_type = $_POST['address_type'];
        $address_type = filter_var($address_type, FILTER_SANITIZE_STRING);
        $method = $_POST['method'];
        $method = filter_var($method, FILTER_SANITIZE_STRING);
        $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $varify_cart->execute([$user_id]);
        if (isset($_GET['get_id'])) {
            $get_product = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
            $get_product->execute([$_GET['get_id']]);
            if ($get_product->rowCount() > 0) {
                while ($fetch_products = $get_product->fetch(PDO::FETCH_ASSOC)) {
                    $insert_order = $conn->prepare("INSERT INTO `orders`(id, user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                    $insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_products['id'], $fetch_products['price'], 1]);
                    header('location: order.php');
                }
            } else {
                $warning_msg[] = 'produk tidak ada!';
            }
        } elseif ($varify_cart->rowCount() > 0) {
            while ($fetch_cart = $varify_cart->fetch(PDO::FETCH_ASSOC)) {
                $insert_order = $conn->prepare("INSERT INTO `orders`(id, user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_cart['product_id'], $fetch_cart['price'], $fetch_cart['qty']]);
            }
            if ($insert_order) {
                $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                $delete_cart_id->execute([$user_id]);
                header('location: order.php');
            }
        } else {
            $warning_msg[] = 'keranjang kosong!';
        }
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
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-gW6a-fnzsF9VEjzP"></script>
    <title>Coffee Shop - halaman Pembayaran</title>
    <link rel="icon" type="image/png" href="img/download.png">
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
            <div class="row">
                <form method="post" id="checkout-form">
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
                                <?php if(empty($user_id)): ?>
                                    <p style="color:red; margin-bottom:5px;">Silakan login terlebih dahulu untuk melanjutkan pemesanan.</p>
                                    <input type="email" name="email" required placeholder="masukkan email" maxlength="50" class="input">
                                <?php endif; ?>
                            </div>
                            <div class="input-field">
                                <p>Metode Pembayaran <sup>*</sup></p>
                                <select name="method" class="input">
                                    <option value="cash on delivery">Cash on Delivery</option>
                                    <option value="credit or debit card">Credit atau Debit Card</option>
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
                    <button type="submit" name="place_order" id="cod-submit" style="display:none;"></button>
                    <button id="pay-button" type="button" class="btn">Bayar</button>
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
        </section>
        <?php include 'components/footer.php';?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <script>
    document.getElementById('pay-button').addEventListener('click', function () {
        const method = document.querySelector('select[name="method"]').value;

        if (method === 'cash on delivery') {
            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "place_order";
            input.value = "1";
            document.getElementById('checkout-form').appendChild(input);
            document.getElementById('checkout-form').submit();
        } else if (method === 'credit or debit card') {
            const name = document.querySelector('input[name="name"]').value;
            const number = document.querySelector('input[name="number"]').value;
            const emailField = document.querySelector('input[name="email"]');
            const email = emailField ? emailField.value : "guest@email.com";
            const total = <?= $grand_total ?>;

            fetch('token.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email, number, total })
            })
            .then(res => res.json())
            .then(data => {
                snap.pay(data.token, {
                    onSuccess: function(result) {
                        alert('Pembayaran berhasil!');
                        window.location.href = "order.php";
                    },
                    onPending: function(result) {
                        alert('Pembayaran sedang diproses.');
                        window.location.href = "order.php";
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal!');
                        console.log(result);
                    },
                    onClose: function() {
                        alert('Popup ditutup tanpa menyelesaikan pembayaran.');
                    }
                });
            });
        }
    });
    </script>
    <?php include 'components/alert.php';?>
</body>
</html>
