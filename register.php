<?php 
    include 'components/connection.php';
    session_start();

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = '';
    }

    if (isset($_POST['submit'])) {
        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = $_POST['pass'];
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = $_POST['cpass'];
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->execute([$email]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($select_user->rowCount() > 0) {
            $message[] = 'email pengguna sudah ada';
            echo 'email pengguna sudah ada';
        } else {
            if ($pass != $cpass) {
                $message[] = 'konfirmasi kata sandi tidak cocok';
                echo 'konfirmasi kata sandi tidak cocok';
            } else {
                $insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password) VALUES(?,?,?,?)");
                $insert_user->execute([$id, $name, $email, $pass]);
                $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
                $select_user->execute([$email, $pass]);
                $row = $select_user->fetch(PDO::FETCH_ASSOC);
                if ($select_user->rowCount() > 0) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_email'] = $row['email'];
                    header('Location: home.php');
                    exit;
                }
            }
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
    <title>Coffee Shop - halaman Daftar</title>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <img src="img/download.png">
                <h1>Daftar Sekarang</h1>
                <p>Isi data diri Anda:)</p> 
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <p>Nama<sup>*</sup></p>
                    <input type="text" name="name" required placeholder="Masukkan nama anda" maxlength="100">
                </div>
                <div class="input-field">
                    <p>Email<sup>*</sup></p>
                    <input type="email" name="email" required placeholder="Masukkan email anda" maxlength="100" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <div class="input-field">
                    <p>Password<sup>*</sup></p>
                    <input type="password" name="pass" required placeholder="Masukkan password anda" maxlength="100" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <div class="input-field">
                    <p>Konfirmasi Password<sup>*</sup></p>
                    <input type="password" name="cpass" required placeholder="Konfirmasi password anda" maxlength="100" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>
                <input type="submit" name="submit" value="daftar sekarang" class="btn">
                <p>sudah punya akun? <a href="login.php">masuk sekarang</a></p> 
            </form>
        </section>
    </div>
</body>
</html>