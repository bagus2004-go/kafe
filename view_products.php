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

    if (isset($_POST['add_to_wishlist'])) {
        $id = unique_id();
        $product_id = $_POST['product_id'];
        $varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
        $varify_wishlist->execute([$user_id, $product_id]);
        $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $cart_num->execute([$user_id, $product_id]);
        if ($varify_wishlist->rowCount() > 0) {
            $warning_msg[] = 'produk sudah ada di daftar anda';
        } else if ($cart_num->rowCount() > 0) {
            $warning_msg[] = 'produk sudah ada di keranjang anda';
        } else {
            $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            if ($select_price->rowCount() > 0) {
                $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);
                $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (id, user_id, product_id, price) VALUES(?,?,?,?)");
                if ($insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']])) {
                    $success_msg[] = 'produk berhasil dimasukkan ke daftar anda';
                } else {
                    $warning_msg[] = 'gagal menambahkan produk ke wishlist';
                }
            } else {
                $warning_msg[] = 'produk tidak ditemukan';
            }
        }
    }

    if (isset($_POST['add_to_cart'])) {
        $id = unique_id();
        $product_id = $_POST['product_id'];
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);
        $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
        $varify_cart->execute([$user_id, $product_id]);
        $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $max_cart_items->execute([$user_id]);
        if ($varify_cart->rowCount() > 0) {
            $warning_msg[] = 'produk sudah ada di daftar anda';
        } else if ($max_cart_items->rowCount() > 20) {
            $warning_msg[] = 'keranjang anda penuh';
        } else {
            $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);
            $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty) VALUES(?,?,?,?,?)");
            $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
            $success_msg[] = 'produk berhasil dimasukkan ke keranjang anda';
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
    <title>Coffee Shop - halaman Produk</title>
</head>
<body>
    <?php include 'components/header.php';?>
    <div class="main">
        <div class="banner">
            <h1>Produk</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/Lihat Produk</span>
        </div>
        <section class="products">
            <div class="box-container">
                <?php 
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" class="box">
                    <img src="image/<?= $fetch_products['image'];?>" class="img">
                    <div class="button">
                        <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                        <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                        <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bx bxs-show"></a>
                    </div>
                    <h3 class="name"><?= $fetch_products['name']; ?></h3>
                    <input type="hidden" name="product_id"  value="<?= $fetch_products['id']; ?>">
                    <div class="flex">
                        <p class="price">Harga Rp<?= $fetch_products['price']; ?>,-</p>
                        <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                    </div>
                    <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">beli sekarang</a>
                </form>
                <?php
                        }
                    } else {
                        echo '<p class="empty">tidak ada produk</p>';
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