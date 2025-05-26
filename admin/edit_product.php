<?php 
    include '../components/connection.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
    if (!isset($admin_id)) {
        header('location: login.php');
    }
    if (isset($_POST['update'])) {
        $post_id = $_GET['id'];
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);
        $status = $_POST['status'];
        $status = filter_var($status, FILTER_SANITIZE_STRING);
        $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, product_detail = ?, status = ? WHERE id = ?");
        $update_product->execute([$name, $price, $content, $status, $post_id]);
        $success_msg[] = 'produk berhasil diperbarui!';
        $old_image = $_POST['old_image'];
        $image = $_FILES['image']['name'];
        $image = filter_var($image , FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder ='../image/'.$image;
        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
        $select_image->execute([$image]);
        if (!empty($image)) {
            if ($image_size > 5242880) {
                $warning_msg[] = 'ukuran gambar terlalu besar';
            } elseif ($select_image->rowCount() > 0 AND $image != '') {
                $warning_msg[] = 'ganti nama gambar Anda';
            } else {
                $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
                $update_image->execute([$image, $post_id]);
                move_uploaded_file($image_tmp_name, $image_folder);
                if ($old_image != $image AND $old_image != '') {
                    unlink('../image/'.$old_image);

                }
                $success_msg[] = 'gambar berhasil diperbarui!';
            }
        }
    }

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
    <title>Panel Admin Kedai Kopi - halaman ubah produk</title>
</head>
<body>
    <?php include '../components/admin_header.php';?>
    <div class="main">
        <div class="banner">
            <h1>ubah produk</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">dasbor</a><span>/ubah produk</span>
        </div>
        <section class="edit-post">
            <h1 class="heading">ubah produk</h1>
            <?php 
                $post_id = $_GET['id'];
                $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_product->execute([$post_id]);
                if ($select_product->rowCount() > 0) {
                    while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="old_image" value="<?= $fetch_product['image'];?>">
                    <input type="hidden" name="product_id" value="<?= $fetch_product['id'];?>">
                    <div class="input-field">
                        <label>perbarui status</label>
                        <select name="status">
                            <option selected disabled value="<?= $fetch_product['status'];?>"><?= $fetch_product['status'];?></option>
                            <option value="active">aktif</option>
                            <option value="deactive">tidak aktif</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label>nama produk</label>
                        <input type="text" name="name" value="<?= $fetch_product['name'];?>">
                    </div>
                    <div class="input-field">
                        <label>harga produk</label>
                        <input type="number" name="price" value="<?= $fetch_product['price'];?>">
                    </div>
                    <div class="input-field">
                        <label>deskripsi produk</label>
                        <textarea name="content"><?= $fetch_product['product_detail'];?></textarea>
                    </div>
                    <div class="input-field">
                        <label>gambar produk</label>
                        <input type="file" name="image" accept="image/*">
                        <img src="../image/<?= $fetch_product['image'];?>">
                    </div>
                    <div class="flex-btn">
                        <button type="submit" name="update" class="btn">perbarui produk</button>
                        <a href="view_product.php" class="btn">kembali</a>
                        <button type="submit" name="delete" class="btn">hapus produk</button>
                    </div>
                </form>        
            </div>
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