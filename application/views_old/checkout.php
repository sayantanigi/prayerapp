<!DOCTYPE html>
<html>
<?php $settings = $this->db->query("SELECT * FROM setting")->row();?>
<head>
    <title>120 ARMY - Contact</title>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <script src="https://www.paypal.com/sdk/js?client-id=BAAuRnUHRl1nhJdpVO7zOV_Js7uyVas4i1lKppDunkVYoDDOGTNPPg7zENXJPrlog71GvFNRf6Z_2di8go&components=hosted-buttons&enable-funding=venmo&currency=USD"></script>
    <div id="paypal-container-S9DZ7JWNC8WL6"></div>
    <script>
        paypal.HostedButtons({
            hostedButtonId: "S9DZ7JWNC8WL6",
        }).render("#paypal-container-S9DZ7JWNC8WL6")
    </script>
    <!-- <section class="container Data_Container">
        <div class="row">
            <div class="col-md-12 col-sm-12 form">
                <div class="contact__wrapper">
                    <div class="section__title-wrapper mb-40">
                        <h2 class="section__title" style="margin-top: 25px;color: #000;">Payment Canceled</h2>
                    </div>
                    <div class="contact__form">
                        <p>You have canceled your recent payment on 120 Army.<p>
                        <p>We apologize for any inconvenience this may have caused. If you have any questions or concerns regarding the cancellation, please don't hesitate to contact our customer support team at <a href="mailto:<?= $settings->email; ?>"><?= $settings->email; ?></a> or Call Us on <a href="tel:<?= $settings->phone; ?>"><?= $settings->phone; ?></a>
                        <div class="col-xxl-12">
                            <div class="contact__btn">
                                <a href="<?= base_url()?>"><button type="button" class="e-btn">Go To Home Page</button></a>
                            </div>
                        </div>
                    </div>
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
                    <a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470"><img src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""> App Store</a>
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
                            <li><a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470">AppStore</a></li>
                            <li>/</li>
                            <li><a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer">Google Play</a></li>
                        </ul>
                        <ul class="app_sec social_sec">
                            <li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="f_content">
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
    </footer> -->
</body>
</html>
<script>
    window.setTimeout(function(){
        $('#amount').prop('readonly', true);
        $('#amount').val('<?= $total?>');
    }, 1100);
</script>