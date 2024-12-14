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
                    <li class="nav-item"><a class="btn btn-primary nav-link"
                            href="{{ route('halamanhome.index') }}">Home</a></li>
                    <li class="nav-item"><a class="btn btn-primary nav-link"
                            href="{{ route('halamanservices.index') }}">Services</a></li>
                    <li class="nav-item"><a class="btn btn-primary nav-link"
                            href="{{ route('halamanproduct.index') }}">Product</a></li>
                    <li class="nav-item"><a class="btn btn-primary nav-link"
                            href="{{ route('halamanpayment.index') }}">Payment</a></li>
                    <li class="nav-item"><a class="btn btn-primary nav-link"
                            href="{{ route('halamanmaps.index') }}">Maps</a></li>
                    <li class="nav-item"><a class="btn btn-primary nav-link"
                            href="{{ route('halamancontact.index') }}">Contact</a></li>
                    <li class="nav-item"><a class="btn btn-primary nav-link" href="{{ route('login') }}">Sign In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead" id="home">
        <div class="container">
            <div class="masthead-heading text-uppercase">Welcome To DEVAN CELL </div>
            <a class="btn btn-primary btn-xl text-uppercase" href="{{ route('halamanservices.index') }}">Tell Me
                More</a>
        </div>
    </header>
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
    <!-- Footer-->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start">Copyright &copy; Devcom Project 3 2024</div>
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
    <dialog id="portfolioModal1" class="portfolio-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <button class="close-modal" type="button" aria-label="Close" onclick="closeModal('portfolioModal1')">
                    <img src="assets/img/close-icon.svg" alt="Close modal" />
                </button>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="modal-body">
                                <!-- Project details -->
                                <h2 class="text-uppercase">Samsung</h2>
                                <p class="item-intro text-muted">Inovasi Tiada Henti dengan Samsung.</p>
                                <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/samsung.jpg"
                                    alt="Samsung Galaxy smartphone" />
                                <p>
                                    Rasakan kecanggihan yang menyatu dalam genggaman Anda dengan Samsung Galaxy.
                                    Dengan desain elegan dan fitur revolusioner, smartphone ini siap menemani
                                    setiap langkah perjalanan Anda.
                                </p>
                                <ul class="list-inline">
                                    <li>
                                        <strong>Client:</strong> Threads
                                    </li>
                                    <li>
                                        <strong>Category:</strong> Illustration
                                    </li>
                                </ul>
                                <button class="btn btn-primary btn-xl text-uppercase" type="button"
                                    onclick="closeModal('portfolioModal1')">
                                    <i class="fas fa-xmark me-1"></i> Close Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </dialog>
    <!-- Portfolio item 2 modal popup-->
    <dialog id="portfolioModal1" class="portfolio-modal">
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
    </dialog>
    <!-- Portfolio item 3 modal popup-->
    <dialog id="portfolioModal1" class="portfolio-modal">
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
    </dialog>
    <!-- Portfolio item 4 modal popup-->
    <dialog id="portfolioModal1" class="portfolio-modal">
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
    </dialog>
    <!-- Portfolio item 5 modal popup-->
    <dialog id="portfolioModal1" class="portfolio-modal">
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
    </dialog>
    <!-- Portfolio item 6 modal popup-->
    <dialog id="portfolioModal1" class="portfolio-modal">
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
    </dialog>
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
