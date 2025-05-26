<?php 
    include '../components/connection.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
    if (!isset($admin_id)) {
        header('location: login.php');
    }
    if (isset($_POST['delete'])) {
        $p_id = $_POST['product_id'];
        $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);
        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
        $delete_product->execute([$p_id]);
        $success_msg[] = 'produk berhasil dihapus';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="adminstyle.css?v=<?php echo time(); ?>">
    <title>Panel Admin Kedai Kopi - halaman semua produk</title>
</head>
<body>
    <?php include '../components/admin_header.php';?>
    <div class="main">
        <div class="banner">
            <h1>semua produk</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">dasbor</a><span>/semua produk</span>
        </div>
        <section class="show-post">
            <h1 class="heading">semua produk</h1>
            <div class="box-container">
                <?php 
                    $select_product= $conn->prepare("SELECT * FROM `products`");
                    $select_product->execute();
                    if ($select_product->rowCount() > 0) {
                        while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
                    <?php if ($fetch_product['image'] != '') {?>
                        <img src="../image/<?= $fetch_product['image']; ?>" class="image">
                    <?php } ?>
                    <div class="status" style="color: <?php if ($fetch_product['status'] == 'active') {echo 'green';} else {echo 'red';} ?>;"><?= $fetch_product['status']; ?></div>
                    <div class="price">Rp<?= $fetch_product['price']; ?>,-</div>
                    <div class="title"><?= $fetch_product['name']; ?></div>
                    <div class="flex-btn">
                        <a href="edit_product.php?id=<?= $fetch_product['id']; ?>" class="btn">ubah</a>
                        <button type="submit" name="delete" class="btn" onclick="return confirm('hapus produk ini');">hapus</button>
                        <a href="read_product.php?post_id=<?= $fetch_product['id']; ?>" class="btn">lihat</a>
                    </div>
                </form>
                <?php 
                        }
                    } else {
                        echo '
                            <div class="empty">
                                <p>tidak ada produk! <br> <a href="add_product.php" style="margin-top: 1.5rem;" class="btn">tambah produk</a></p>
                            </div>
                        ';
                    }
                ?>
                
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php';?>
</body>
</html>