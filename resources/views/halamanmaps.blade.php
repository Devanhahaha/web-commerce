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

    <section class="page-section bg-light" id="maps">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Maps</h2>
                <h3 class="section-subheading text-muted">Letak Lokasi Toko Devan Cell</h3>
            </div>
            <iframe class="map-iframe"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.2823222185093!2d108.1775344735584!3d-6.485887263409887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ec900744dcb7f%3A0xca7a6436039e7dd9!2sDevan%20Cell!5e0!3m2!1sid!2sid!4v1709803859898!5m2!1sid!2sid"
                allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                title="Google Maps showing the location of Devan Cell">
            </iframe>
    </section>
</body>
