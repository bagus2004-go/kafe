<header class="header">
    <div class="flex">
        <a href="dashboard.php" class="logo"><img src="../img/logo2.png"></a>
        <nav class="navbar">
            <a href="dashboard.php">dasbor</a>
            <a href="add_product.php">tambah produk</a>
            <a href="view_product.php">lihat produk</a>
            <a href="user_accounts.php">akun</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <i class="bx bx-list-plus" id="menu-btn"></i>
        </div>
        <div class="profile-detail">
            <?php 
                $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
                $select_profile->execute([$admin_id]);
                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="profile">
                <img src="../image/<?= $fetch_profile['profile'];?>" class="logo-img">
                <p><?= $fetch_profile['name'];?></p>
            </div>
            <div class="flex-btn">
                <a href="profile.php" class="btn">profil</a>
                <a href="../components/admin_logout.php" onclick="return confirm('keluar dari situs web ini');" class="btn">Keluar</a>
            </div>
            <?php 
                }
            ?>
        </div>
    </div>
</header>