<!DOCTYPE html>
<html>
<?php $settings = $this->db->query("SELECT * FROM setting")->row();?>
<head>
    <title>120 ARMY - Home</title>
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
        .right_event span i {margin-right: 10px;}
        .Donate_Btn {width: 100%;height: auto;top: 90%;right: 50%;transform: translate(50%, -50%);position: absolute;font-size: 25px;font-weight: bolder;padding: 5px 25px;cursor: pointer;pointer-events: all;z-index: 100;text-decoration: none;color: var(--Primary); text-align: center;}
    </style>
</head>
<body>
    <header class="main_header">
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
    
    <div id="carouselExampleIndicators" class="carousel slide Custom_Carousel" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php 
            $i = 1; 
            foreach ($banner as $slprayer) { ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i?>" class="active"></li>
            <?php $i++; } ?>
        </ol>

        <div id="carrousel" class="carousel-inner">
        <?php if(!empty($banner)) { 
            $j = 1;
            foreach ($banner as $slprayer) { ?>
            <div data-pause="true" data-interval="10000" class="carousel-item <?php if($j == '1') { echo "active";}?>">
                <!-- Paypal Button Start -->
                <form action="https://www.sandbox.paypal.com/donate" method="post" target="_top" class="Donate_Btn">
                    <input type="hidden" name="hosted_button_id" value="U3JU8K97MQJ22" />
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" style="width: 150px;"/>
                </form>
                <!-- Paypal Button End -->
                <?php 
                $allowed = array('JPEG', 'PNG', 'JPG', 'GIF', 'jpeg', 'jpg', 'png', 'gif');
                $filename = $slprayer['image'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!empty($slprayer['image']) && file_exists("uploads/banner/".$slprayer['image'])) { 
                if (in_array($ext, $allowed)) { ?>
                    <img src="<?= base_url()?>uploads/banner/<?= $slprayer['image']?>" alt="" style="height: 750px">
                <?php } else { ?>
                    <video width="100%" class="elVideo" loop="loop" autoPlay playsInline muted id='video-slider-<?= $j?>'>
                        <source src="<?= base_url()?>uploads/banner/<?= $slprayer['image']?>" type="video/mp4">
                    </video>
                    <div style="text-align: center;color: #fff;position: absolute;top: 30%;width: 90%;font-size: 30px;left: 60px;"><?= $slprayer['page_name']?></div>
                    <div style=" text-align: center; color: #fff; position: absolute; top: 70%; width: 100%; font-size: 30px;">
                        <a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470" style="background: #fff;width: 12%;display: inline-block;border-radius: 25px;padding: 10px 0;color: #000;font-size: 20px;text-decoration: none;">
                            <img src="<?= base_url() ?>assets/images/iphoneicon.png" alt="" style="width: 30px; height: 30px;"> App Store
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer" style="background: #fff;width: 12%;display: inline-block;border-radius: 25px;padding: 10px 0;color: #000;font-size: 20px;text-decoration: none;">
                            <img src="<?= base_url() ?>assets/images/playstoreicon.png" alt="" style="width: 30px; height: 30px;"> Play Store
                        </a>
                    </div>
                    
                <?php } } else { ?>
                <img src="<?= base_url()?>uploads/no_image.png?>" alt="" style="height: 750px">
                <?php } ?>
            </div>
        <?php $j++; } } ?>
        </div>
        <div class="container-fluid containerVideobg">
            <div class="videoSliderBackground"></div>
        </div>
    </div>

    <section class="main_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="main_section_left">
                        <h3>Our Prayer Events</h3>
                        <div class="row">
                        <?php
                        if ($prayerEvents) {
                            $i = 1;
                            foreach ($prayerEvents as $events) { ?>
                            <div class="col-md-6 mt-4 mb-4">
                                <div class="prayer_images">
                                    <?php if (!empty($events['prayer_image'])) { ?>
                                        <img src="<?= base_url() ?>uploads/prayer/<?= $events['prayer_image'] ?>" alt="" style="height: 256px">
                                    <?php } else { ?>
                                        <img src="<?= base_url() ?>uploads/no_image.png" alt="" style="height: 256px">
                                    <?php } ?>
                                    <div class="prayer_images_content">
                                        <span><i class="fa fa-area-chart" aria-hidden="true"></i> Event</span>
                                        <p>
                                            <a href="#"><?= $events['prayer_name'] ?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; } } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="main_section_left">
                        <h3>Future Events</h3>
                        <?php
                        $nowDate = date('Y-m-d');
                        $futureDate = $this->db->query("SELECT distinct(prayer_datetime) FROM all_prayers WHERE prayer_datetime > '".$nowDate."' ORDER BY prayer_datetime ASC")->result_array();
                        foreach ($futureDate as $day) { ?>
                        <h5><?= date('D', strtotime($day['prayer_datetime']))?></h5>
                        <?php 
                        $getPrayer = $this->db->query("SELECT * FROM all_prayers WHERE prayer_datetime = '".$day['prayer_datetime']."'")->result_array();
                        foreach ($getPrayer as $prayer) { ?>
                        <ul>
                            <li>
                                <?php 
                                $prayer_datetime = date('Y-m-d h:i A', strtotime($prayer['prayer_datetime']));
                                $prayer_date = date('F d l', strtotime($prayer_datetime));
                                $date = explode(' ', $prayer_date);
                                ?>
                                <h4><?= $date[1]?><span><?= $date[0]?></span></h4>
                                <div class="right_event">
                                    <p><?= $prayer['prayer_name']?></p>
                                    <span><i class="fa fa-map-marker" aria-hidden="true"></i><?= $prayer['prayer_location']?></span>
                                </div>
                            </li>
                        </ul>
                        <?php } } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="download_appsec_outer" id="download_appsec_outer">
        <div class="row">
            <div class="col-xl-4 col-md-6 col-sm-12">
                <div class="download_appsec_content">
                    <h3>Download This App</h3>
                    <p>Discover a faith enhancing spiritual journey with our Prayer App, your all-in-one faithful companion.</p>
                    <div class="qr_sec d-flex">
                        <div class="icon_flex">
                            <a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer"><img src="<?= base_url() ?>assets/images/playstoreicon.png" alt=""> Play Store</a>
                            <a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470"><img src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""> App Store</a>
                        </div>
                        <div class="qr_code">
                            <img src="<?= base_url() ?>assets/images/qr_code.png" alt="" style="width: 100px; height:100px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-6 col-sm-12">
                <div class="download_appsec"> </div>
            </div>
        </div>
    </section>

    <section class="red_zone">
        <div class="container">
            <div class="row">
                <div class="col red_zone_data">
                    <h3>Organize your prayer schedule on the Click To Prayer App</h3>
                    <div class="Store_Icon">
                        <a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer"> <img src="<?= base_url() ?>assets/images/playstoreicon.png" alt=""></a>
                        <a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470"><img src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""></a>
                    </div>
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
                        <a href="#">What is Prayer App?</a>
                        <a href="#">How does Prayer App work?</a>
                        <a href="#">Legal notice, privacy policy and cookies</a>
                    </div>
                    <div class="f_content  mt-5 d-flex">
                        <h2>Download the Prayer App</h2>
                        <ul class="app_sec">
                            <li><a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470"><img src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""></a></li>
                            <li><a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer"><img src="<?= base_url() ?>assets/images/playstoreicon.png" alt=""></a></li>
                        </ul>
                        <ul class="app_sec social_sec">
                            <li><a href="<?= @$settings->fb_link; ?>" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="<?= @$settings->tw_link; ?>" class="tw"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="<?= @$settings->insta_link; ?>" class="pin"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="f_content F_Logo">
                        <a href="<?= base_url() ?>" class="text-end">
                            <img src="<?= base_url() ?>uploads/logo/<?= $settings->flogo?>">
                        </a>
                    </div>
                    <div class="f_content mt-5 text-end F_Logo">
                        <a href="javascript:void(0)">Copyright © <?= date('Y') ?> 120Army</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?= base_url() ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/owl.carousel.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.1/js/bootstrap.min.js'></script>
    <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
    <script>
        $(document).ready(function() {
            $('a[href = "#"]').click(function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $('#download_appsec_outer').offset().top
                }, 500);
            });
        });
</script>
</body>
</html>