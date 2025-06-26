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
    <title>Panel Admin Kedai Kopi - halaman daftar pengguna</title>
    <link rel="icon" type="image/png" href="img/download.png">
</head>
<body>
    <?php include '../components/admin_header.php';?>
    <div class="main">
        <div class="banner">
            <h1>daftar pengguna</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">dasbor</a><span>/daftar pengguna</span>
        </div>
        <section class="accounts">
            <h1 class="heading">daftar pengguna</h1>
            <div class="box-container">
                <?php 
                    $select_users = $conn->prepare("SELECT * FROM `users`");
                    $select_users->execute();
                    if ($select_users->rowCount() > 0) {
                        while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box">
                    <p>id pengguna : <span><?= $fetch_users['id']; ?></span></p>
                    <p>nama pengguna : <span><?= $fetch_users['name']; ?></span></p>
                    <p>email pengguna : <span><?= $fetch_users['email']; ?></span></p>
                </div>
                <?php 
                        }
                    } else {
                        echo '
                            <div class="empty">
                                <p>tidak ada pengguna!</p>
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