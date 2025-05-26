<?php 
    include '../components/connection.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
    if (!isset($admin_id)) {
        header('location: login.php');
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="adminstyle.css?v=<?php echo time(); ?>">
    <title>Panel Admin Kedai Kopi - halaman dasbor</title>
</head>
<body>
    <?php include '../components/admin_header.php';?>
    <div class="main">
        <div class="banner">
            <h1>dasbor</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">home</a><span>/dasbor</span>
        </div>
        <section class="dashboard">
            <h1 class="heading">dasbor</h1>
            <div class="box-container">
                <div class="box">
                    <h3>Selamat datang!</h3>
                    <p><?= $fetch_profile['name']; ?></p>
                    <a href="" class="btn">profil</a>
                </div>
                <div class="box">
                    <?php 
                        $select_product = $conn->prepare("SELECT * FROM `products`");
                        $select_product->execute();
                        $num_of_product = $select_product->rowCount();
                    ?>
                    <h3><?= $num_of_product; ?></h3>
                    <p>produk ditambahkan</p>
                    <a href="add_product.php" class="btn">tambahkan produk baru</a>
                </div>
                <div class="box">
                    <?php 
                        $select_active_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                        $select_active_product->execute(['active']);
                        $num_of_active_product = $select_active_product->rowCount();
                    ?>
                    <h3><?= $num_of_active_product; ?></h3>
                    <p>total produk aktif</p>
                    <a href="view_product.php" class="btn">lihat produk aktif</a>
                </div>
                <div class="box">
                    <?php 
                        $select_deactive_product = $conn->prepare("SELECT * FROM `products` WHERE status = ?");
                        $select_deactive_product->execute(['deactive']);
                        $num_of_deactive_product = $select_deactive_product->rowCount();
                    ?>
                    <h3><?= $num_of_deactive_product; ?></h3>
                    <p>total produk yang dinonaktifkan</p>
                    <a href="view_product.php" class="btn">lihat produk nonaktif</a>
                </div>
                <div class="box">
                    <?php 
                        $select_users = $conn->prepare("SELECT * FROM `users`");
                        $select_users->execute();
                        $num_of_users = $select_users->rowCount();
                    ?>
                    <h3><?= $num_of_users; ?></h3>
                    <p>pengguna terdaftar</p>
                    <a href="user_accounts.php" class="btn">lihat pengguna</a>
                </div>
                <div class="box">
                    <?php 
                        $select_admin = $conn->prepare("SELECT * FROM `admin`");
                        $select_admin->execute();
                        $num_of_admin = $select_admin->rowCount();
                    ?>
                    <h3><?= $num_of_admin; ?></h3>
                    <p>admin terdaftar</p>
                    <a href="admin_accounts.php" class="btn">lihat admin</a>
                </div>
                <div class="box">
                    <?php 
                        $select_message = $conn->prepare("SELECT * FROM `message`");
                        $select_message->execute();
                        $num_of_message = $select_message->rowCount();
                    ?>
                    <h3><?= $num_of_message; ?></h3>
                    <p>pesan yang belum dibaca</p>
                    <a href="admin_message.php" class="btn">lihat pesan</a>
                </div>
                <div class="box">
                    <?php 
                        $select_orders = $conn->prepare("SELECT * FROM `orders`");
                        $select_orders->execute();
                        $num_of_orders = $select_orders->rowCount();
                    ?>
                    <h3><?= $num_of_orders; ?></h3>
                    <p>total pesanan yang dilakukan</p>
                    <a href="orders.php" class="btn">lihat pesanan</a>
                </div>
                <div class="box">
                    <?php 
                        $select_confirm_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                        $select_confirm_orders->execute(['in progress']);
                        $num_of_confirm_orders = $select_confirm_orders->rowCount();
                    ?>
                    <h3><?= $num_of_confirm_orders; ?></h3>
                    <p>total konfirmasi pesanan</p>
                    <a href="orders.php" class="btn">lihat konfirmasi pesanan</a>
                </div>
                <div class="box">
                    <?php 
                        $select_canceled_orders = $conn->prepare("SELECT * FROM `orders` WHERE status = ?");
                        $select_canceled_orders->execute(['canceled']);
                        $num_of_canceled_orders = $select_canceled_orders->rowCount();
                    ?>
                    <h3><?= $num_of_canceled_orders; ?></h3>
                    <p>total pesanan yang dibatalkan</p>
                    <a href="orders.php" class="btn">lihat pesanan dibatalkan</a>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php';?>
</body>
</html>