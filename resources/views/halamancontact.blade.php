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
</body>
