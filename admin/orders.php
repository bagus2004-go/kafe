<?php 
include '../components/connection.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location: login.php');
}

if (isset($_POST['delete_order'])) {
    $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_STRING);
    $verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
    $verify_delete->execute([$order_id]);
    if ($verify_delete->rowCount() > 0) {
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
        $delete_order->execute([$order_id]);
        $success_msg[] = 'Pesanan berhasil dihapus!';
    } else {
        $warning_msg[] = 'Pesanan tidak ditemukan!';
    }
}

if (isset($_POST['update_order'])) {
    $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_STRING);
    $update_status = $_POST['update_status'];
    $update_status = filter_var($update_status, FILTER_SANITIZE_STRING);
    $update_query = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
    $update_query->execute([$update_status, $order_id]);
    $success_msg[] = 'Status pembayaran berhasil diperbarui!';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Data Pesanan</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="adminstyle.css?v=<?= time(); ?>">
    <link rel="icon" type="image/png" href="img/download.png">
</head>
<body>
<?php include '../components/admin_header.php'; ?>

<div class="main">
    <div class="banner"><h1>Pesanan</h1></div>
    <div class="title2">
        <a href="dashboard.php">Dasbor</a><span>/Data Pesanan</span>
    </div>

    <section class="order-container">
        <h1 class="heading">Total Pesanan Masuk</h1>
        <div class="box-container">
            <?php 
            $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY date DESC");
            $select_orders->execute();
            if ($select_orders->rowCount() > 0) {
                while ($order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                    $total = $order['price'] * $order['qty'];
            ?>
            <div class="box">
                <div class="status" style="color: <?= ($order['status'] == 'diproses') ? 'green' : 'red'; ?>">
                    Status: <?= $order['status']; ?>
                </div>
                <div class="detail">
                    <p><strong>Nama Pelanggan:</strong> <?= $order['name']; ?></p>
                    <p><strong>ID Pesanan:</strong> <?= $order['id']; ?></p>
                    <p><strong>Tanggal:</strong> <?= $order['date']; ?></p>
                    <p><strong>No HP:</strong> <?= $order['number']; ?></p>
                    <p><strong>Email:</strong> <?= $order['email']; ?></p>
                    <p><strong>Alamat:</strong> <?= $order['address']; ?> (<?= $order['address_type']; ?>)</p>
                    <p><strong>Metode Pembayaran:</strong> <?= strtoupper($order['method']); ?></p>
                    <p><strong>Produk:</strong> ID <?= $order['product_id']; ?></p>
                    <p><strong>Jumlah:</strong> <?= $order['qty']; ?> pcs</p>
                    <p><strong>Harga Satuan:</strong> Rp<?= number_format($order['price']); ?></p>
                    <p><strong>Total Bayar:</strong> <span style="color:darkblue">Rp<?= number_format($total); ?></span></p>
                    <p><strong>Status Pembayaran:</strong> <span style="color:<?= $order['payment_status'] == 'completed' ? 'green' : 'orange'; ?>">
                        <?= $order['payment_status']; ?></span></p>
                </div>
                <form method="post">
                    <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                    <select name="update_status">
                        <option disabled selected><?= $order['payment_status']; ?></option>
                        <option value="pending">pending</option>
                        <option value="completed">completed</option>
                    </select>
                    <div class="flex-btn">
                        <button type="submit" name="update_order" class="btn">Perbarui</button>
                        <button type="submit" name="delete_order" class="btn" onclick="return confirm('Yakin ingin menghapus pesanan ini?');">Hapus</button>
                    </div>
                </form>
            </div>
            <?php 
                }
            } else {
                echo '<div class="empty"><p>Tidak ada pesanan saat ini.</p></div>';
            }
            ?>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="script.js"></script>
<?php include '../components/alert.php'; ?>
</body>
</html>
