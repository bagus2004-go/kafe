<?php 
    include 'components/connection.php';
?>
<style type="text/css">
    <?php include 'style.css';?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Coffee Shop - Halaman Tentang Kami</title>
</head>
<body>
    <?php include 'components/header.php';?>
    <div class="main">
        <div class="banner">
            <h1>Tentang Kami</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a><span>/Tentang kami</span>
        </div>
        <div class="about-category">
            <div class="box">
                <img src="img/3.jpg">
                <div class="detail">
                    <span>Kopi</span>
                    <h1>Americano</h1>
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
            </div>
            <div class="box">
                <img src="img/4.jpg">
                <div class="detail">
                    <span>Kopi</span>
                    <h1>Cappucino</h1>
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
            </div>
            <div class="box">
                <img src="img/5.jpg">
                <div class="detail">
                    <span>Kopi</span>
                    <h1>Long Black</h1>
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
            </div>
            <div class="box">
                <img src="img/6.jpg">
                <div class="detail">
                    <span>Kopi</span>
                    <h1>Vanilla Latte</h1>
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
            </div>
        </div>
        <section class="services">
            <div class="title">
                <img src="img/download.png" class="logo">
                <h1>Kenapa memilih kami</h1>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="img/icon.png">
                    <div class="detail">
                        <h3>penghematan besar</h3>
                        <p>hemat banyak setiap pesanan</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon1.png">
                    <div class="detail">
                        <h3>Dukungan 24*7</h3>
                        <p>dukungan satu-satu</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon2.png">
                    <div class="detail">
                        <h3>voucher hadiah</h3>
                        <p>voucher di setiap perayaan</p>
                    </div>
                </div>
                <div class="box">
                    <img src="img/icon3.png">
                    <div class="detail">
                        <h3>Pengiriman gratis</h3>
                        <p>pengiriman barang gratis</p>
                    </div>
                </div>
            </div>
        </section>
        <div class="about">
            <div class="row">
                <div class="img-box"> 
                    <img src="img/3.png">
                </div>
                <div class="detail">
                    <h1>Kunjungi tempat kami</h1>
                    <p>tempat kami adalah tempat terbaik untuk membeli kopi. dimana kamu bisa mengekspresikan diri sesuka mungkin. 
                        kenyamanan dan kepuasan adalah prioritas kami.</p>
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
            </div>
        </div>
        <div class="testimonial-container">
            <div class="title">
                <img src="img/download.png" class="logo">
                <h1>apa yang orang katakan tentang kami</h1>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
            </div>
            <div class="container">
                <div class="testimonial-item active">
                    <img src="img/testi1.jpg">
                    <h1>Tung Tung Sahur</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur tenetur aperiam esse. Eum nam, dolores laudantium natus, quia vel dicta a eaque quod fuga velit modi nihil possimus nostrum ea.</p>
                </div>
                <div class="testimonial-item">
                    <img src="img/testi2.jpg">
                    <h1>Tralalero Tralala</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur tenetur aperiam esse. Eum nam, dolores laudantium natus, quia vel dicta a eaque quod fuga velit modi nihil possimus nostrum ea.</p>
                </div>
                <div class="testimonial-item">
                    <img src="img/testi3.jpg">
                    <h1>Cimpanzini Bananini</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur tenetur aperiam esse. Eum nam, dolores laudantium natus, quia vel dicta a eaque quod fuga velit modi nihil possimus nostrum ea.</p>
                </div>
                <div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
                <div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
            </div>
        </div>
        <?php include 'components/footer.php';?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <script type="text/javascript">
        let slides = document.querySelectorAll('.testimonial-item');
        let index = 0;
        function nextSlide() {
            slides[index].classList.remove('active');
            index = (index + 1) % slides.length;
            slides[index].classList.add('active');
        }
        function prevSlide() {
            slides[index].classList.remove('active');
            index = (index - 1 + slides.length) % slides.length;
            slides[index].classList.add('active');
        }
    </script>
    <?php include 'components/alert.php';?>
</body>
</html>