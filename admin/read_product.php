<?php 
    include '../components/connection.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
    if (!isset($admin_id)) {
        header('location: login.php');
    }
    $get_id = $_GET['post_id'];
    if (isset($_POST['delete'])) {
        $p_id = $_POST['product_id'];
        $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);
        $delete_image = $conn->prepare("DELETE FROM `products` WHERE id = ?");
        $delete_image->execute([$p_id]);
        $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
        if ($fetch_delete_image['image'] != '') {
            unlink('../image/'.$fetch_delete_image['image']);
        }
        header('location: view_product.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="adminstyle.css?v=<?php echo time(); ?>">
    <title>Panel Admin Kedai Kopi - halaman baca produk</title>
</head>
<body>
    <?php include '../components/admin_header.php';?>
    <div class="main">
        <div class="banner">
            <h1>baca produk</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">dasbor</a><span>/baca produk</span>
        </div>
        <section class="read-post">
            <h1 class="heading">baca produk</h1>
            <?php 
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_product->execute([$get_id]);
                if ($select_product->rowCount() > 0) {
                    $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC); {
                
            ?>
            <form action="" method="post">
                <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">    
                <div class="status" style="color: <?php if ($fetch_product['status'] == 'active') {echo 'green';} else {echo 'red';} ?>;"><?= $fetch_product['status']; ?></div>
                <?php if ($fetch_product['image'] != '') {?> 
                    <img src="../image/<?= $fetch_product['image']; ?>" class="image"> 
                <?php } ?>
                <div class="price">Rp<?= $fetch_product['price'];?>,-</div>
                <div class="title"><?= $fetch_product['name'];?></div>
                <div class="content"><?= $fetch_product['product_detail'];?></div>
                <div class="flex-btn">
                    <a href="edit_product.php?id=<?= $fetch_product['id']; ?>" class="btn">ubah</a>
                    <button type="submit" name="delete" class="btn" onclick="return confirm('hapus produk ini');">hapus</button>
                    <a href="view_product.php?id=<?= $get_id; ?>" class="btn">kembali</a>
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
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php';?>
</body>
</html>