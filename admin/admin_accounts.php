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
    <title>Panel Admin Kedai Kopi - halaman daftar admin</title>
    <link rel="icon" type="image/png" href="img/download.png">
</head>
<body>
    <?php include '../components/admin_header.php';?>
    <div class="main">
        <div class="banner">
            <h1>daftar admin</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">dasbor</a><span>/daftar admin</span>
        </div>
        <section class="accounts">
            <h1 class="heading">daftar admin</h1>
            <div class="box-container">
                <?php 
                    $select_admin = $conn->prepare("SELECT * FROM `admin`");
                    $select_admin->execute();
                    if ($select_admin->rowCount() > 0) {
                        while ($fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box">
                    <p>id admin : <span><?= $fetch_admin['id']; ?></span></p>
                    <p>nama admin : <span><?= $fetch_admin['name']; ?></span></p>
                    <p>email admin : <span><?= $fetch_admin['email']; ?></span></p>
                </div>
                <?php 
                        }
                    } else {
                        echo '
                            <div class="empty">
                                <p>tidak ada admin!</p>
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