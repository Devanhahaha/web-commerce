<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>DEVAN CELL</title>
    <!-- icon-->
    <link rel="icon" type="image/x-icon" href="assets/logo-tab.png" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        .payment-img {
            height: 100px !important;
        }
    </style>
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-text3.svg" alt="..." /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#product">Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="#payment">Payment</a></li>
                    <li class="nav-item"><a class="nav-link" href="#maps">Maps</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item">
                        <a class="btn btn-primary nav-link" href="{{ route('login') }}">Sign In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container">
            <div class="masthead-heading text-uppercase">Welcome To DEVAN CELL </div>
            <a class="btn btn-primary btn-xl text-uppercase" href="#services">Tell Me More</a>
        </div>
    </header>
    <!-- Services-->
    <section class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Services</h2>
                <h3 class="section-subheading text-muted">Devan Cellular Menyediakan Pelayanan.</h3>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-credit-card fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Pulsa</h4>
                    <p class="text-muted">Selamat datang di layanan Pulsa dan Pembayaran Menyediakan Kemudahan dan
                        Kepuasan untuk Setiap Transaksi Anda!</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-globe fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Paket Data</h4>
                    <p class="text-muted">Nikmati Browsing, Streaming, dan Gaming Tanpa Khawatir Kuota Habis! Promo
                        Paket Data Terbaik Ada di Sini!</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-money-bill fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Bayar Tagihan</h4>
                    <p class="text-muted">Hindari Keterlambatan Bayar Tagihan dengan Layanan Kami yang Cepat dan Aman!
                        Segera Coba Sekarang!</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-wrench fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Service Handphone</h4>
                    <p class="text-muted">Dapatkan Kembali Performa Terbaik Handphone Anda! Service Handphone
                        Profesional dan Berpengalaman!</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Shop</h4>
                    <p class="text-muted">Layanan Lengkap untuk Hidup Lebih Praktis! Paket Data, Bayar Tagihan, Service
                        Handphone, dan Produk Berkualitas Hanya untuk Anda!</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Portfolio Grid-->
    <section class="page-section bg-light" id="product">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Product</h2>
                <h3 class="section-subheading text-muted">Lengkapi Hidupmu dengan Produk Berkualitas! Promo Menarik
                    untuk Semua Produk, Hanya di Toko Kami!</h3>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-6 mb-4">
                    <!-- Portfolio item 1-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal1">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/samsung.jpg" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">Handphone</div>
                            <div class="portfolio-caption-subheading text-muted">Illustration</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4">
                    <!-- Portfolio item 2-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal2">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/hedset.jpg" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">Headset</div>
                            <div class="portfolio-caption-subheading text-muted">Graphic Design</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4">
                    <!-- Portfolio item 3-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal3">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/charger 1.jpg" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">Charger</div>
                            <div class="portfolio-caption-subheading text-muted">Identity</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4 mb-lg-0">
                    <!-- Portfolio item 4-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal4">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/usb.jpg" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">Kabel USB</div>
                            <div class="portfolio-caption-subheading text-muted">Branding</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4 mb-sm-0">
                    <!-- Portfolio item 5-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal5">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/kasing.jpg" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">Kasing HP</div>
                            <div class="portfolio-caption-subheading text-muted">Website Design</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <!-- Portfolio item 6-->
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal6">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="assets/img/portfolio/power bank.jpg" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">Power Bank</div>
                            <div class="portfolio-caption-subheading text-muted">Photography</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--payment-->
    <section class="page-section" id="payment">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Payment</h2>
                <h3 class="section-subheading text-muted">Pilihan metode pembayaran yang memudahkan anda.</h3>
                <div class="payment-image">
                    <img class="img-fluid payment-img" src="assets/img/payment/dana.png" alt=" " />
                    <img class="img-fluid payment-img" src="assets/img/payment/virtuala.png" alt=" " />
                    <img class="img-fluid payment-img" src="assets/img/payment/shopeepay.jpeg" alt=" " />
                    <img class="img-fluid payment-img" src="assets/img/payment/alfamart.jpeg" alt=" " />
                    <img class="img-fluid payment-img" src="assets/img/payment/indomaret.jpeg" alt=" ">
                </div>
    </section>
    <!--Maps-->
    <section class="page-section bg-light" id="maps">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Maps</h2>
                <h3 class="section-subheading text-muted">Letak Lokasi Toko Devan Cell</h3>
            </div>
            <iframe class="text-center" width="1300" height="700"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.2823222185093!2d108.1775344735584!3d-6.485887263409887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ec900744dcb7f%3A0xca7a6436039e7dd9!2sDevan%20Cell!5e0!3m2!1sid!2sid!4v1709803859898!5m2!1sid!2sid"
                width="1100" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
    <!-- Clients-->
    {{-- <div class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3 col-sm-6 my-3">
                        <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/microsoft.svg" alt="..." aria-label="Microsoft Logo" /></a>
                    </div>
                    <div class="col-md-3 col-sm-6 my-3">
                        <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/google.svg" alt="..." aria-label="Google Logo" /></a>
                    </div>
                    <div class="col-md-3 col-sm-6 my-3">
                        <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/facebook.svg" alt="..." aria-label="Facebook Logo" /></a>
                    </div>
                    <div class="col-md-3 col-sm-6 my-3">
                        <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="assets/img/logos/ibm.svg" alt="..." aria-label="IBM Logo" /></a>
                    </div>
                </div>
            </div>
        </div> --}}
    <!-- Contact-->
    @include('chatting')
    <div class="text-center position-fixed bottom-0 end-0 m-3">
        <button class="btn btn-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#chatDrawer"
            aria-controls="chatDrawer">
            Chat
        </button>
    </div>
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        var socket = io('http://localhost:3000');

        $('#kirim').click(function() {
            let name = $('#nama').val();
            let pesan = $('#description').val();
            socket.emit('chat', {
                sender: name,
                message: pesan
            });
        })

        var messages = document.getElementById('message');

        socket.on('chat', function(msg) {
            console.log(msg);
            var item = document.createElement('li');
            item.classList.add('whatsapp');
            item.innerHTML = `<h5>${msg.sender}</h5><span>${msg.message}</span>`;
            messages.appendChild(item);
            window.scrollTo(0, document.body.scrollHeight);
        });

        socket.on('adminReply', function(msg) {
            console.log(msg);
            var item = document.createElement('li');
            item.classList.add('admin-reply');
            item.innerHTML = `<h5>${msg.sender}</h5><span>${msg.message}</span>`;
            messages.appendChild(item);
            window.scrollTo(0, document.body.scrollHeight);
        });

        socket.on('chat', function(msg) {
    // Tampilkan pesan di layar admin
    var adminMessage = document.createElement('div');
    adminMessage.innerHTML = `<strong>${msg.sender}:</strong> ${msg.message}`;
    document.getElementById('admin-messages').appendChild(adminMessage);
});
    </script>
    <section class="page-section" id="contact" style="background-color: #343a40; color: white;">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Hubungi Kami</h2>
                <h3 class="section-subheading text-muted">Jika Anda Mengalami Hal Yang Tidak Diinginkan, Silahkan
                    Hubungi Kami</h3>
            </div>
            <div class="row align-items-stretch mb-5">
                <div class="col-md-12">
                    <div class="text-center">
                        <p>Jika Anda memerlukan bantuan, silakan hubungi admin kami:</p>
                        <p><strong>Email:</strong> devanherdiansyah74@gmail.com</p>
                        <p><strong>Telepon:</strong> 083157174554</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer-->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start">Copyright &copy; Your Website 2023</div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Twitter"><i
                            class="fab fa-twitter"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Facebook"><i
                            class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i
                            class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                    <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Portfolio Modals-->
    <!-- Portfolio item 1 modal popup-->
    <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg"
                        alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">Samsung</h2>
                                <p class="item-intro text-muted">Inovasi Tiada Henti dengan Samsung.</p>
                                <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/samsung.jpg"
                                    alt="..." />
                                <p>Rasakan kecanggihan yang menyatu dalam genggaman Anda dengan Samsung Galaxy. Dengan
                                    desain elegan dan fitur revolusioner, smartphone ini siap menemani setiap langkah
                                    perjalanan Anda.</p>
                                <ul class="list-inline">
                                    <li>
                                        <strong>Client:</strong>
                                        Threads
                                    </li>
                                    <li>
                                        <strong>Category:</strong>
                                        Illustration
                                    </li>
                                </ul>
                                <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal"
                                    type="button">
                                    <i class="fas fa-xmark me-1"></i>
                                    Close Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio item 2 modal popup-->
    <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg"
                        alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">Headset</h2>
                                <p class="item-intro text-muted">Suara Jernih, Pengalaman Tanpa Batas</p>
                                <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/hedset.jpg"
                                    alt="..." />
                                <p>Nikmati setiap nada dengan headset berkualitas tinggi yang memberikan kejernihan
                                    suara dan kenyamanan maksimal. Dengan teknologi noise-cancelling, tenggelam dalam
                                    musik tanpa gangguan dari dunia luar.</p>
                                <ul class="list-inline">
                                    <li>
                                        <strong>Client:</strong>
                                        Explore
                                    </li>
                                    <li>
                                        <strong>Category:</strong>
                                        Graphic Design
                                    </li>
                                </ul>
                                <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal"
                                    type="button">
                                    <i class="fas fa-xmark me-1"></i>
                                    Close Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio item 3 modal popup-->
    <div class="portfolio-modal modal fade" id="portfolioModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg"
                        alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">Charger</h2>
                                <p class="item-intro text-muted">Isi Daya dalam Sekejap.</p>
                                <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/charger 1.jpg"
                                    alt="..." />
                                <p>Jangan biarkan perangkat Anda kehabisan daya. Dengan charger cepat, nikmati pengisian
                                    yang lebih cepat dan efisien. Tetap produktif dan terhubung tanpa harus menunggu
                                    lama.</p>
                                <ul class="list-inline">
                                    <li>
                                        <strong>Client:</strong>
                                        Finish
                                    </li>
                                    <li>
                                        <strong>Category:</strong>
                                        Identity
                                    </li>
                                </ul>
                                <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal"
                                    type="button">
                                    <i class="fas fa-xmark me-1"></i>
                                    Close Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio item 4 modal popup-->
    <div class="portfolio-modal modal fade" id="portfolioModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg"
                        alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">Kabel USB</h2>
                                <p class="item-intro text-muted">Konektivitas Tanpa Batas.</p>
                                <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/usb.jpg"
                                    alt="..." />
                                <p>Nikmati konektivitas yang cepat dan andal dengan kabel USB berkualitas tinggi.
                                    Transfer data dengan mudah dan isi daya perangkat Anda dengan efisien menggunakan
                                    kabel USB yang tahan lama dan serbaguna.</p>
                                <ul class="list-inline">
                                    <li>
                                        <strong>Client:</strong>
                                        Lines
                                    </li>
                                    <li>
                                        <strong>Category:</strong>
                                        Branding
                                    </li>
                                </ul>
                                <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal"
                                    type="button">
                                    <i class="fas fa-xmark me-1"></i>
                                    Close Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio item 5 modal popup-->
    <div class="portfolio-modal modal fade" id="portfolioModal5" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg"
                        alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">Kasing HP</h2>
                                <p class="item-intro text-muted">Perlindungan Maksimal, Gaya Optimal.</p>
                                <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/kasing.jpg"
                                    alt="..." />
                                <p>Jaga smartphone Anda tetap aman dan tampil gaya dengan casing HP berkualitas tinggi.
                                    Perlindungan maksimal dari benturan, goresan, dan debu dengan desain yang elegan dan
                                    modern.</p>
                                <ul class="list-inline">
                                    <li>
                                        <strong>Client:</strong>
                                        Southwest
                                    </li>
                                    <li>
                                        <strong>Category:</strong>
                                        Website Design
                                    </li>
                                </ul>
                                <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal"
                                    type="button">
                                    <i class="fas fa-xmark me-1"></i>
                                    Close Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio item 6 modal popup-->
    <div class="portfolio-modal modal fade" id="portfolioModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-bs-dismiss="modal"><img src="assets/img/close-icon.svg"
                        alt="Close modal" /></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details-->
                                <h2 class="text-uppercase">Power Bank</h2>
                                <p class="item-intro text-muted">Daya Tahan Tinggi.</p>
                                <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/power bank.jpg"
                                    alt="..." />
                                <p>Dengan kapasitas besar, power bank kami memastikan Anda tetap terhubung sepanjang
                                    hari tanpa khawatir kehabisan baterai.</p>
                                <ul class="list-inline">
                                    <li>
                                        <strong>Client:</strong>
                                        Window
                                    </li>
                                    <li>
                                        <strong>Category:</strong>
                                        Photography
                                    </li>
                                </ul>
                                <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal"
                                    type="button">
                                    <i class="fas fa-xmark me-1"></i>
                                    Close Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
