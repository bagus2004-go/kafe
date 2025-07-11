<header class="header">
    <div class="flex">
        <a href="home.php" class="logo"><img src="img/logo2.png"></a>
        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="view_products.php">produk</a>
            <a href="order.php">pesanan</a>
            <a href="about.php">tentang kami</a>
            <a href="contact.php">kontak</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <?php 
                $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                $count_wishlist_items->execute([$user_id]);
                $total_wishlist_items = $count_wishlist_items->rowCount();
            ?>
            <a href="wishlist.php" class="cart-btn"><i class="bx bx-heart"></i><sup><?= $total_wishlist_items ?></sup></a>
            <?php 
                $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $total_cart_items = $count_cart_items->rowCount();
            ?>
            <a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup><?= $total_cart_items ?></sup></a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>
        <div class="user-box">
            <?php if(isset($_SESSION['user_name']) && isset($_SESSION['user_email'])): ?>
            <p>nama : <span><?= htmlspecialchars($_SESSION['user_name']) ?></span></p>
            <p>email : <span><?= htmlspecialchars($_SESSION['user_email']) ?></span></p>
            <form method="post">
                <button type="submit" name="logout" class="logout-btn">keluar</button>
            </form>
            <?php else: ?>
            <a href="login.php" class="btn">masuk</a>
            <a href="register.php" class="btn">daftar</a>
            <?php endif; ?>
        </div>
    </div>
</header>


