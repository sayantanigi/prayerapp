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
    <style>
    .contact__form-agree input:hover,.contact__form-agree label:hover{cursor:pointer}.contact__form-agree label a:hover,.contact__info-text p a:hover{color:#db3636}.contact__form-input input,.contact__form-input select,.contact__form-input textarea{width:100%;height:56px;line-height:54px;padding:0 23px;background:#f3f4f8;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;border:2px solid #f3f4f8;color:#0e1133;font-size:15px;margin-bottom:20px}.contact__form-input input::placeholder,.contact__form-input textarea::placeholder{font-size:15px;color:#6d6e75}.contact__form-input input:focus,.contact__form-input textarea:focus{border-color:#db3636;outline:0;background:#fff}.contact__form-input textarea{height:180px;padding:23px 25px;line-height:1.1;resize:none;margin-bottom:13px}.contact__form-agree{padding-left:5px}.contact__form-agree input{margin:0;appearance:none;-moz-appearance:none;display:block;width:14px;height:14px;background:#fff;border:1px solid #b9bac1;outline:0;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}.contact__form-agree input:checked{position:relative;background-color:#db3636;border-color:transparent}.contact__form-agree input:checked::after{box-sizing:border-box;content:"\f00c";position:absolute;font-family:"Font Awesome 5 Pro";font-size:10px;color:#fff;top:46%;left:50%;-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.contact__form-agree label{padding-left:8px;color:#53545b}.contact__form-agree label a{font-weight:600;padding-left:4px;color:#db3636!important}.contact__info-inner{padding:45px 70px 45px 40px;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;-webkit-box-shadow:0 30px 50px 0 rgba(1,11,60,.1);-moz-box-shadow:0 30px 50px 0 rgba(1,11,60,.1);box-shadow:0 30px 50px 0 rgba(1,11,60,.1);position:relative;z-index:1}.contact__info-icon svg{fill:none;stroke:#db3636;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.contact__info-icon svg.map{width:16px;height:20px}.contact__info-icon svg.call,.contact__info-icon svg.mail{width:18px;height:18px}.contact__info-text h4{font-size:20px;font-weight:600;margin-bottom:6px}.contact__info-text p{margin-bottom:0;color:#53545b}.contact__social h4{font-size:20px;font-weight:600;margin-bottom:13px}.contact__social ul li a{display:inline-block;width:40px;height:40px;line-height:44px;text-align:center;font-size:13px;color:#0e1133;background:#f3f4f8;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}.contact__social ul li a.fb{color:#285da1;background:rgba(40,93,161,.1)}.contact__social ul li a.fb:hover{color:#fff;background:#285da1}.contact__social ul li a.tw{color:#03a9f4;background:rgba(3,169,244,.1)}.contact__social ul li a.tw:hover{color:#fff;background:#03a9f4}.contact__social ul li a.pin{color:#d8163f;background:rgba(216,22,63,.1)}.contact__social ul li a.pin:hover{color:#fff;background:#d8163f}.contact__icon{margin-bottom:28px}.contact__icon svg{width:70px;height:70px;backface-visibility:hidden;-webkit-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);-o-transform:translate3d(0,0,0);transform:translate3d(0,0,0);-webkit-transition:transform .3s cubic-bezier(.21, .6, .44, 2.18);-moz-transition:transform .3s cubic-bezier(.21, .6, .44, 2.18);-ms-transition:transform .3s cubic-bezier(.21, .6, .44, 2.18);-o-transition:transform .3s cubic-bezier(.21, .6, .44, 2.18);transition:transform .3s cubic-bezier(.21, .6, .44, 2.18)}.contact__icon svg .st0{fill:none;stroke:#db3636;stroke-width:.5;stroke-linecap:round;stroke-linejoin:round}.contact__item{padding:50px 80px 62px;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;-webkit-box-shadow:0 40px 50px 0 rgba(1,11,60,.08);-moz-box-shadow:0 40px 50px 0 rgba(1,11,60,.08);box-shadow:0 40px 50px 0 rgba(1,11,60,.08);position:relative;z-index:1}.contact__item:hover .contact__icon svg{-webkit-transform:translate3d(0,-10px,0);-moz-transform:translate3d(0,-10px,0);-ms-transform:translate3d(0,-10px,0);-o-transform:translate3d(0,-10px,0);transform:translate3d(0,-10px,0)}.contact__title{font-size:26px;margin-bottom:8px}.contact__content p{font-size:16px;color:#53545b;margin-bottom:30px}.contact__shape img{position:absolute}.contact__shape img.contact-shape-1{bottom:75px;left:-30px;z-index:-1}.contact__shape img.contact-shape-2{top:30px;right:-30px}.contact__shape img.contact-shape-3{right:-45%;top:50%}@media only screen and (min-width:1400px) and (max-width:1600px){.contact__shape img.contact-shape-3{right:-20%}}@media only screen and (min-width:1200px) and (max-width:1399px){.contact__shape img.contact-shape-3{right:-10%}}@media only screen and (min-width:992px) and (max-width:1199px){.contact__shape img.contact-shape-2{right:-20px}.contact__shape img.contact-shape-3{right:-5%}}@media only screen and (min-width:768px) and (max-width:991px){.contact__info-inner{margin-top:50px}.contact__item{padding-left:30px;padding-right:30px}.contact__shape img.contact-shape-2{right:-20px}.contact__shape img.contact-shape-3{right:-5%}}@media only screen and (min-width:576px) and (max-width:767px){.contact__info-inner{margin-top:50px}.contact__shape img.contact-shape-2{right:-20px}.contact__shape img.contact-shape-3{right:-5%}}@media (max-width:575px){.contact__info-inner{margin-top:50px;padding-right:35px}.contact__item{padding-left:20px;padding-right:20px}.contact__shape img.contact-shape-2,.contact__shape img.contact-shape-3{right:0}}.contact__shape img.contact-shape-4{right:180px;bottom:-21%}.contact__shape img.contact-shape-5{left:0;bottom:142px}#form-messages{text-align:center;margin-top:10px}.contact__social ul li{display:inline-block;margin-right:4px!important}.e_cerror,.e_error,.termsCheckSubmit{display:none}.e-btn{display:inline-block;height:50px;line-height:52px;text-align:center;padding:0 25px;color:#fff;background:#631b1d;border:none;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;font-weight:500;text-transform:capitalize}
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
            <div class="col-md-6 col-sm-12 form">
                <div class="contact__wrapper">
                    <div class="section__title-wrapper mb-40">
                        <h2 class="section__title" style="margin-top: 25px;color: #000;">Get in touch</h2>
                    </div>
                    <p class="e_error" style="color: #db3636;">* All fields are mandatory</p>
                    <p class="e_cerror" style="color: #db3636;">* Please check checkbox</p>
                    <div class="contact__form">
                        <form id="contact-form">
                            <div class="row">
                                <div class="col-xxl-6 col-xl-6 col-md-6">
                                    <div class="contact__form-input">
                                        <input class="from-control" type="text" id="name" name="name" placeholder="Your Name" required="">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-md-6">
                                    <div class="contact__form-input">
                                        <input class="from-control" type="text" id="email" name="email" placeholder="Your Email" required="">
                                    </div>
                                </div>
                                <div class="col-xxl-6">
                                    <div class="contact__form-input">
                                        <input class="from-control" type="text" id="subject" name="subject" placeholder="Subject" required="">
                                    </div>
                                </div>
                                <div class="col-xxl-6">
                                    <div class="contact__form-input">
                                        <input class="from-control" type="text" id="phone" name="phone" placeholder="Contact Number" required="" maxlength="10">
                                    </div>
                                </div>
                                <div class="col-xxl-12">
                                    <div class="contact__form-input">
                                        <textarea class="from-control" id="message" name="message" placeholder="Enter Your Message" required=""></textarea>
                                    </div>
                                </div>
                                <div class="col-xxl-12">
                                    <div class="contact__btn">
                                        <button type="button" class="e-btn" onclick="send_message()">Send your message</button>
                                    </div>
                                </div>
                                <div class="success_msg"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 data">
                <div class="contact__info white-bg p-relative z-index-1 rounded">
                    <div class="contact__info-inner white-bg">
                        <ul>
                            <li style="list-style: none;">
                                <div class="contact__info-item d-flex align-items-start mb-35" style="margin-bottom: 35px;">
                                    <div class="contact__info-icon mr-15" style="margin-right: 15px;">
                                        <svg class="map" viewBox="0 0 24 24">
                                            <path class="st0" d="M21,10c0,7-9,13-9,13s-9-6-9-13c0-5,4-9,9-9S21,5,21,10z"></path>
                                            <circle class="st0" cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <div class="contact__info-text">
                                        <h4 class="text-dark"> Office Address</h4>
                                        <p><?= $settings->address; ?></p>
                                    </div>
                                </div>
                            </li>
                            <li style="list-style: none;">
                                <div class="contact__info-item d-flex align-items-start mb-35" style="margin-bottom: 35px;">
                                    <div class="contact__info-icon mr-15" style="margin-right: 15px;">
                                        <svg class="mail" viewBox="0 0 24 24">
                                            <path class="st0" d="M4,4h16c1.1,0,2,0.9,2,2v12c0,1.1-0.9,2-2,2H4c-1.1,0-2-0.9-2-2V6C2,4.9,2.9,4,4,4z"></path>
                                            <polyline class="st0" points="22,6 12,13 2,6 "></polyline>
                                        </svg>
                                    </div>
                                    <div class="contact__info-text">
                                        <h4 class="text-dark">Email us directly</h4>
                                        <p><a href="mailto:<?= $settings->email; ?>"><?= $settings->email; ?></a></p>
                                    </div>
                                </div>
                            </li>
                            <li style="list-style: none;">
                                <div class="contact__info-item d-flex align-items-start mb-35" style="margin-bottom: 35px;">
                                    <div class="contact__info-icon mr-15" style="margin-right: 15px;">
                                        <svg class="call" viewBox="0 0 24 24">
                                            <path class="st0" d="M22,16.9v3c0,1.1-0.9,2-2,2c-0.1,0-0.1,0-0.2,0c-3.1-0.3-6-1.4-8.6-3.1c-2.4-1.5-4.5-3.6-6-6  c-1.7-2.6-2.7-5.6-3.1-8.7C2,3.1,2.8,2.1,3.9,2C4,2,4.1,2,4.1,2h3c1,0,1.9,0.7,2,1.7c0.1,1,0.4,1.9,0.7,2.8c0.3,0.7,0.1,1.6-0.4,2.1  L8.1,9.9c1.4,2.5,3.5,4.6,6,6l1.3-1.3c0.6-0.5,1.4-0.7,2.1-0.4c0.9,0.3,1.8,0.6,2.8,0.7C21.3,15,22,15.9,22,16.9z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="contact__info-text">
                                        <h4 class="text-dark">Phone</h4>
                                        <p><a href="tel:<?= $settings->phone; ?>"><?= $settings->phone; ?></a></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="contact__social">
                            <h4 class="text-dark">Follow Us</h4>
                            <ul>
                                <li><a href="<?= @$settings->fb_link; ?>" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="<?= @$settings->tw_link; ?>" class="tw"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="<?= @$settings->insta_link; ?>" class="pin"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            </ul>
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
    </footer>
    <script src="<?= base_url() ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/owl.carousel.js"></script>
    <script>
        function send_message() {
            var name = $('#name').val();
            var email = $('#email').val();
            var subject = $('#subject').val();
            var phone = $('#phone').val();
            var message = $('#message').val();

            if (name == "" || email == "" || subject == "" || phone == "" || message == "") {
                $('.e_error').fadeIn('slow');
                setTimeout(() => {
                    $('.e_error').fadeOut('slow');
                }, 5000);
            } else {
                $.ajax({
                    url: '<?php echo base_url("home/contactFormSubmit") ?>',
                    type: 'post',
                    data: {
                        name: name,
                        email: email,
                        subject: subject,
                        phone: phone,
                        message: message
                    },
                    success: function(response) {
                        if (response == 1) {
                            $('.success_msg').html('<p style="color: green; margin-top: 25px;">Thank You for Contacting Us. We will get back to you soon.</p>');
                            $('#contact-form')[0].reset();
                            setTimeout(() => {
                                location.reload();
                            }, 5000);
                        } else {
                            $('.success_msg').text('<p style="color=#db3636; margin-top: 25px;">Opps! something went wrong. Please try again later.</p>');
                            $('#contact-form')[0].reset();
                            setTimeout(() => {
                                location.reload();
                            }, 5000);
                        }

                    }
                });
            }
        }
    </script>
</body>

</html>