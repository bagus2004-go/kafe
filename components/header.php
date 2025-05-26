<header class="header">
    <div class="flex">
        <a href="home.php" class="logo"><img src="img/logo.png"></a>
        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="view_products.php">produk</a>
            <a href="order.php">pesanan</a>
            <a href="about.php">tentang kami</a>
            <a href="contact.php">kontak</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <a href="whislist.php" class="cart-btn"><i class="bx bx-heart"></i><sup>0</sup></a>
            <a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup>0</sup></a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>
        <div class="user-box">
            <p>nama pengguna : <span><?php //echo $_SESSION['user_name']; ?></span></p>
            <p>email pengguna : <span><?php //echo $_SESSION['user_email']; ?></span></p>
            <a href="login.php" class="btn">masuk</a>
            <a href="register.php" class="btn">daftar</a>
            <form method="post">
                <button type="submit" name="logout" class="logout-btn">keluar</button>
            </form>
        </div>
    </div>
</header>


