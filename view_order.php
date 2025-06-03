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

    if (isset($_GET['get_id'])) {
        $get_id = $_GET['get_id'];
    } else {
        $get_id = '';
        header('location: order.php');
    }

    if (isset($_POST['cancel'])) {
        $update_order = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
        $update_order->execute(['canceled', $get_id]);
        header('location: order.php');
        $success_msg[] = 'pesanan berhasil dibatalkan';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>Coffee Shop - halaman detail Pesanan</title>
</head>
<body>
    <?php include 'components/header.php';?>
    <div class="main">
        <div class="banner">
            <h1>Detail Pesanan</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/Detail Pesanan</span>
        </div>
        <section class="order-detail">
            <div class="title">
                <img src="img/download.png" class="logo">
                <h1>Detail Pesananku</h1>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
            </div>
            <div class="box-container">
                <?php 
                    $grand_total = 0;
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
                    $select_orders->execute([$get_id]);
                    if ($select_orders->rowCount() > 0) {
                        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                            $select_products->execute([$fetch_orders['product_id']]);
                            if ($select_products->rowCount() > 0) {
                                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                                    $sub_total = ($fetch_orders['price'] * $fetch_orders['qty']);
                                    $grand_total += $sub_total;
                ?>
                <div class="box">
                    <div class="col">
                        <p class="title"><i class="bi bi-calendar-fill"></i><?= $fetch_orders['date']; ?></p>
                        <img src="image/<?= $fetch_products['image']; ?>" class="image">
                        <p class="price"><?= $fetch_products['price']; ?> x <?= $fetch_orders['qty']; ?></p>
                        <h3 class="name"><?= $fetch_products['name']; ?></h3>
                        <p class="grand-total">Total yang harus dibayarkan : <span>Rp<?= $grand_total; ?>,-</p>
                    </div>
                    <div class="col">
                        <p class="title">Alamat penagihan</p>
                        <p class="user"><i class="bi bi-person-bounding-box"></i><?= $fetch_orders['name']; ?></p>
                        <p class="user"><i class="bi bi-phone"></i><?= $fetch_orders['number']; ?></p>
                        <p class="user"><i class="bi bi-envelope"></i><?= $fetch_orders['email']; ?></p>
                        <p class="user"><i class="bi bi-pin-map"></i><?= $fetch_orders['address']; ?></p>
                        <p class="title">Status</p>
                        <p class="status" style="color:<?php if ($fetch_orders['status'] == 'dikirim') {echo 'green';} elseif ($fetch_orders['status'] == 'dibatalkan') {echo 'red';} else {echo 'orange';} ?>"><?= $fetch_orders['status']; ?></p>
                        <?php if ($fetch_orders['status'] == 'dibatalkan') { ?>
                            <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">Pesan lagi</a>
                        <?php } else {?>
                            <form method="post">
                                <button type="submit" name="cancel" class="btn" onclick="return confirm('anda ingin batalkan pesanan?')">batalkan pesanan</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
                <?php 
                                }
                            } else {
                                echo '<p class="empty">tidak ada produk</p>';
                            }
                        }
                    } else {
                        echo '<p class="empty">belum ada pesanan yang dilakukan</p>';
                    }
                ?>
            </div>
        </section>
        <?php include 'components/footer.php';?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php';?>
</body>
</html>