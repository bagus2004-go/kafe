<?php 
    include '../components/connection.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
    if (!isset($admin_id)) {
        header('location: login.php');
    }
    if (isset($_POST['publish'])) {
        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);
        $status = 'active';
        $image = $_FILES['image']['name'];
        $image = filter_var($image , FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder ='../image/'.$image;
        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
        $select_image->execute([$image]);
        if (isset($image)) {
            if ($select_image->rowCount() > 0) {
                $warning_msg[] = 'nama gambar diulang';
            } elseif ($image_size > 5242880) {
                $warning_msg[] = 'ukuran gambar terlalu besar';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
            }
        } else {
            $image = '';
        }
        if ($select_image->rowCount() > 0 AND $image != '') {
            $warning_msg[] = 'harap ganti nama gambar Anda';
        } else {
            $insert_product = $conn->prepare("INSERT INTO `products` (id, name, price, image, product_detail, status) VALUES(?,?,?,?,?,?)");
            $insert_product->execute([$id, $name, $price, $image, $content, $status]);
            $success_msg[] = 'produk berhasil dimasukkan!';
        }
    }
    if (isset($_POST['draft'])) {
        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $content = $_POST['content'];
        $content = filter_var($content, FILTER_SANITIZE_STRING);
        $status = 'deactive';
        $image = $_FILES['image']['name'];
        $image = filter_var($image , FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder ='../image/'.$image;
        $select_image = $conn->prepare("SELECT * FROM `products` WHERE image = ?");
        $select_image->execute([$image]);
        if (isset($image)) {
            if ($select_image->rowCount() > 0) {
                $warning_msg[] = 'nama gambar diulang';
            } elseif ($image_size > 5242880) {
                $warning_msg[] = 'ukuran gambar terlalu besar';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
            }
        } else {
            $image = '';
        }
        if ($select_image->rowCount() > 0 AND $image != '') {
            $warning_msg[] = 'harap ganti nama gambar Anda';
        } else {
            $insert_product = $conn->prepare("INSERT INTO `products` (id, name, price, image, product_detail, status) VALUES(?,?,?,?,?,?)");
            $insert_product->execute([$id, $name, $price, $image, $content, $status]);
            $success_msg[] = 'produk berhasil disimpan sebagai draf';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="adminstyle.css?v=<?php echo time(); ?>">
    <title>Panel Admin Kedai Kopi - halaman tambah produk</title>
</head>
<body>
    <?php include '../components/admin_header.php';?>
    <div class="main">
        <div class="banner">
            <h1>tambah produk</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">dasbor</a><span>/tambah produk</span>
        </div>
        <section class="form-container">
            <h1 class="heading">tambah produk</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-field">
                    <label>nama produk <sup>*</sup></label>
                    <input type="text" name="name" maxlength="100" required placeholder="tambah nama produk">
                </div>
                <div class="input-field">
                    <label>harga produk <sup>*</sup></label>
                    <input type="number" name="price" maxlength="100000000" required placeholder="tambah harga produk">
                </div>
                <div class="input-field">
                    <label>detail produk <sup>*</sup></label>
                    <textarea name="content" required maxlength="10000" required placeholder="tulis deskripsi produk"></textarea>
                </div>
                <div class="input-field">
                    <label>gambar produk <sup>*</sup></label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <div class="flex-btn">
                    <button type="submit" name="publish" class="btn">publikasikan produk</button>
                    <button type="submit" name="draft" class="btn">simpan sebagai draf produk</button>
                </div>
            </form>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php';?>
</body>
</html>