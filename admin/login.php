<?php 
    include '../components/connection.php';
    session_start();
    if (isset($_POST['login'])) {
        
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['password']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ? AND password = ?");
        $select_admin->execute([$email, $pass]);
        if ($select_admin->rowCount() > 0) {
            $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
            $_SESSION['admin_id'] = $fetch_admin_id['id'];
            header('location:dashboard.php');
        } else {
            $warning_msg[] = 'nama pengguna atau kata sandi salah';
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
    <title>Panel Admin Kedai Kopi - halaman masuk</title>
</head>
<body>
    <div class="main">
        <section>
            <div class="form-container" id="admin_login">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>MASUK</h3>
                    <div class="input-field">
                        <label>email pengguna<sup>*</sup></label>
                        <input type="email" name="email" maxlength="100" required placeholder="Masukkan email anda" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>kata sandi pengguna<sup>*</sup></label>
                        <input type="password" name="password" maxlength="100" required placeholder="Masukkan password anda" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <button type="submit" name="login" class="btn">masuk sekarang</button>
                    <p>tidak memiliki akun? <a href="register.php">daftar sekarang</a></p>
                </form>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php';?>
</body>
</html>