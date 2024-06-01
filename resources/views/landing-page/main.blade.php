<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Siwarga</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/landing-page/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/landing-page/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/landing-page/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/landing-page/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/landing-page/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/landing-page/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('css/style-landing-page.css') }}" rel="stylesheet">

    <!-- =======================================================
    * Template Name: FlexStart
    * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
    * Updated: Mar 17 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>
    @include('landing-page.header')

    @yield('hero')

    @yield('main')

    @include('landing-page.footer')

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/landing-page/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('vendor/landing-page/aos/aos.js') }}"></script>
    <script src="{{ asset('vendor/landing-page/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/landing-page/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/landing-page/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/landing-page/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/landing-page/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/landing-page.js') }}"></script>
</body>

</html>
