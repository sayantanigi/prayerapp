<!DOCTYPE html>
<html>
<?php $settings = $this->db->query("SELECT * FROM setting")->row();?>
<head>
    <title>120 ARMY - Privacy Policy</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="<?= base_url() ?>uploads/logo/<?= $settings->favicon?>">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;500;600;700;800&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
    <style>
        dl, ol, ul {margin-left: 55px !important;}
        .Data_Container *{color: #000 !important;}
    </style>
</head>

<body>
    <header class="main_header sub_header">
        <div class="container h-100">
            <nav class="navbar navbar-expand-lg p-0 h-100">
                <a class="navbar-brand" href="<?= base_url() ?>">
                <img src="<?= base_url() ?>uploads/logo/<?= $settings->logo?>" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 m-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= base_url() ?>about_us">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= base_url() ?>terms_and_condition">Terms and Condition</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>privacy_policy">Privacy Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>contact">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <section class="container Data_Container">
        <div class="row">
            <div class="col-12">
                <h1><?= $content->title?></h1>
                <div><?= $content->description?></div>
            </div>
        </div>
        </div>
    </section>

    <section class="banner">
        <div class="container">
            <div class="banner_inner">
                <h1>Try our Prayer app for more things to do</h1>
                <div class="d-flex icon_flex">
                    <a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer"><img src="<?= base_url() ?>assets/images/playstoreicon.png" alt=""> Play Store</a>
                    <a href=""><img src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""> App Store</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer_main">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="f_content">
                        <h2>More About Prayer App</h2>
                        <a href="">What is Prayer App?</a>
                        <a href="">How does Prayer App work?</a>
                        <a href="">Legal notice, privacy policy and cookies</a>
                    </div>
                    <div class="f_content  mt-5 d-flex">
                        <h2>Download the Prayer App</h2>
                        <ul class="app_sec">
                            <li><a href="">AppStore</a></li>
                            <li>/</li>
                            <li><a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer">Google Play</a></li>
                        </ul>
                        <ul class="app_sec social_sec">
                            <li><a href="<?= @$settings->fb_link; ?>" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="<?= @$settings->tw_link; ?>" class="tw"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="<?= @$settings->insta_link; ?>" class="pin"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="f_content">
                        <!-- <h2 class="text-end">Other projects</h2> -->
                        <a href="" class="text-end">
                        <img src="<?= base_url() ?>uploads/logo/<?= $settings->flogo?>" alt="">
                        </a>
                    </div>
                    <div class="f_content mt-5 text-end">
                        <a href="">Copyright © <?= date('Y') ?> 120Army</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="<?= base_url() ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/owl.carousel.js"></script>
    <script>
        $('#banner_inner').owlCarousel({
            items: 1,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            smartSpeed: 1500,
            loop: true,
        })
    </script>
</body>

</html>