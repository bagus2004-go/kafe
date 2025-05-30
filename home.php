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
    <title>Coffee Shop - halaman rumah</title>
</head>
<body>
    <?php include 'components/header.php';?>
    <div class="main">
        <section class="home-section">
            <div class="slider">
                <div class="slider__slider slide1">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>selamat datang di coffee shop</h1>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                        <a href="view_products.php" class="btn">Beli sekarang</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide2">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>selamat datang di coffee shop</h1>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                        <a href="view_products.php" class="btn">Beli sekarang</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide3">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>selamat datang di coffee shop</h1>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                        <a href="view_products.php" class="btn">Beli sekarang</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide4">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>selamat datang di coffee shop</h1>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                        <a href="view_products.php" class="btn">Beli sekarang</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="slider__slider slide5">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>selamat datang di coffee shop</h1>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                        <a href="view_products.php" class="btn">Beli sekarang</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
                <!-- slide end -->
                <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
                <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
            </div>
        </section>
        <!-- home slider end -->
        <section class="thumb">
            <div class="box-container">
                <div class="box">
                    <img src="img/thumb1.jpg">
                    <h3>Kopi Panas</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="img/thumb2.jpg">
                    <h3>Es Kopi</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="img/thumb.jpg">
                    <h3>Roti</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="box">
                    <img src="img/thumb3.jpg">
                    <h3>Biji Kopi</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
            </div>
        </section>
        <section class="container">
            <div class="box-container">
                <div class="box">
                    <img src="img/about-us.jpg">
                </div>
                <div class="box">
                    <img src="img/download.png">
                    <span>kopi</span>
                    <h1>hemat sampai 50%</h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                </div>
            </div>
        </section>
        <section class="shop">
            <div class="title">
                <img src="img/download.png">
                <h1>Produk Terlaris</h1>
            </div>
            <div class="row">
                <img src="img/about.jpg">
                <div class="row-detail">
                    <img src="img/basil.jpg">
                    <div class="top-footer">
                        <h1>Segelas kopi untuk awali hari</h1>
                    </div>
                </div>
            </div>
            <div class="box-container">
                <div class="box">
                    <img src="img/card.jpg">
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
                <div class="box">
                    <img src="img/card1.jpg">
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
                <div class="box">
                    <img src="img/card2.jpg">
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
                <div class="box">
                    <img src="img/card3.jpg">
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
                <div class="box">
                    <img src="img/card4.jpg">
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
                <div class="box">
                    <img src="img/card5.jpg">
                    <a href="view_products.php" class="btn">beli sekarang</a>
                </div>
            </div>
        </section>
        <section class="shop-category">
            <div class="box-container">
                <div class="box">
                    <img src="img/1.jpg">
                    <div class="detail">
                        <span>PENAWARAN BESAR</span>
                        <h1>ekstra diskon 15%</h1>
                        <a href="view_products.php" class="btn">beli sekarang</a>
                    </div>
                </div>
                <div class="box">
                    <img src="img/2.jpg">
                    <div class="detail">
                        <span>Rasa yang baru</span>
                        <h1>Kopi rumahan</h1>
                        <a href="view_products.php" class="btn">beli sekarang</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="services">
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
        <section class="brand">
            <div class="box-container">
                <div class="box">
                    <img src="img/brand1.png">
                </div>
                <div class="box">
                    <img src="img/brand2.png">
                </div>
                <div class="box">
                    <img src="img/brand3.png">
                </div>
                <div class="box">
                    <img src="img/brand4.png">
                </div>
                <div class="box">
                    <img src="img/brand.png">
                </div>
            </div>
        </section>
        <?php include 'components/footer.php';?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php';?>
</body>
</html>