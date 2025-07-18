<?php 
    include 'components/connection.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = '';
    }

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = $_POST['pass'];
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
        $select_user->execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($select_user->rowCount() > 0) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            header('Location: home.php');
            exit;
        } else {
            $warning_msg[] = 'email atau kata sandi salah';
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
    <title>Coffee Shop - halaman Masuk</title>
    <link rel="icon" type="image/png" href="img/download.png">
</head>
<body>
    <div style="text-align:left; margin-top: 20px;">
        <a href="home.php" class="btn back-btn">← Kembali ke Beranda</a>
    </div>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png">
                <h1>Masuk Sekarang</h1>
                <p>Isi data diri Anda:</p> 
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Email<sup>*</sup></p>
                    <input type="email" name="email" required placeholder="Masukkan email anda" maxlength="100" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <div class="input-field">
                    <p>Password<sup>*</sup></p>
                    <input type="password" name="pass" required placeholder="Masukkan password anda" maxlength="100" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <button type="submit" name="submit" class="btn">masuk sekarang</button>
                <p>Tidak memiliki akun? <a href="register.php">daftar sekarang</a></p> 
            </form>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'components/alert.php';?>
</body>
</html>