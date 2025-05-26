<?php 
    include '../components/connection.php';
    if (isset($_POST['register'])) {
        $id = unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = sha1($_POST['password']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = sha1($_POST['cpassword']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../image/'.$image;
        $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email=?");
        $select_admin->execute([$email]);
        if ($select_admin->rowCount() > 0) {
            $warning_msg[] = 'email pengguna sudah keluar';
        } else {
            if($pass != $cpass) {
                $warning_msg[] = 'konfirmasi kata sandi tidak cocok';
            } else {
                $insert_admin = $conn->prepare("INSERT INTO `admin` (id, name, email, password, profile) VALUES(?,?,?,?,?)");
                $insert_admin->execute([$id, $name, $email, $cpass, $image]);
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'daftar admin baru';
            }
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
    <title>Panel Admin Kedai Kopi - halaman daftar</title>
</head>
<body>
    <div class="main">
        <section>
            <div class="form-container" id="admin_login">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>DAFTAR</h3>
                    <div class="input-field">
                        <label>nama pengguna<sup>*</sup></label>
                        <input type="text" name="name" maxlength="100" required placeholder="Masukkan nama anda" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>email pengguna<sup>*</sup></label>
                        <input type="email" name="email" maxlength="100" required placeholder="Masukkan email anda" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>kata sandi pengguna<sup>*</sup></label>
                        <input type="password" name="password" maxlength="100" required placeholder="Masukkan password anda" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>konfirmasi kata sandi<sup>*</sup></label>
                        <input type="password" name="cpassword" maxlength="100" required placeholder="Konfirmasi password anda" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-field">
                        <label>pilih profil<sup>*</sup></label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <button type="submit" name="register" class="btn">daftar sekarang</button>
                    <p>sudah punya akun? <a href="login.php">masuk sekarang</a></p>
                </form>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include '../components/alert.php';?>
</body>
</html>