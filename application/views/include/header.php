<!DOCTYPE html>
<html>
<?php $settings = $this->db->query("SELECT * FROM setting")->row(); ?>
<head>
    <title>120 ARMY - Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="<?= base_url() ?>uploads/logo/<?= $settings->favicon ?>">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;500;600;700;800&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css'>
    <style>
        .Donate_Btn,.downloadLink{width:100%;position:absolute}.Donate_Btn,.downloadLink,.modal,.sliderText{position:absolute}.right_event span i{margin-right:10px}.Donate_Btn{height:auto;top:90%;right:50%;transform:translate(50%,-50%);font-size:25px;font-weight:bolder;padding:5px 25px;cursor:pointer;pointer-events:all;z-index:100;text-decoration:none;color:var(--Primary);text-align:center}.downloadLink,.sliderText *{text-align:center;color:#fff;font-size:30px}.downloadLink{top:70%}.gdownloadLink,.idownloadLink{background:#fff;width:12%;display:inline-block;border-radius:25px;padding:10px 0;color:#000;font-size:20px;text-decoration:none}.gdownloadLink img,.idownloadLink img{width:30px!important;height:30px!important}@media screen and (max-width:1024px){.sliderText *{font-size:22px!important}.gdownloadLink,.idownloadLink{font-size:15px;text-decoration:none!important;color:#000!important}.gdownloadLink img,.idownloadLink img{width:26px!important;height:26px!important}}@media screen and (max-width:768px){.sliderText *{font-size:25px!important;width:90%}.gdownloadLink,.idownloadLink{min-width:150px;font-size:20px;text-decoration:none!important;color:#000!important}.gdownloadLink img,.idownloadLink img{width:30px!important;height:30px!important}}@media screen and (max-width:425px){.sliderText *{font-size:20px!important;width:90%}}@media screen and (max-width:375px){.sliderText *{font-size:20px!important;width:90%}.gdownloadLink,.idownloadLink{font-size:15px}}.carousel-item-next,.carousel-item-prev,.carousel-item.active{display:flex;align-items:center;justify-content:center}.sliderText{width:100%;height:100vh;display:flex;align-items:center;justify-content:center}.downloadLink a:hover{color:#000!important;text-decoration:none!important}.modal,.modal-overlay{top:0;left:0;width:100%;height:100%;visibility:hidden}.modal{z-index:10000}.modal.is-visible{visibility:visible}.modal-overlay{position:fixed;z-index:10;background:hsla(0,0%,0%,.5);opacity:0;transition:visibility 0s linear .3s,opacity .3s}.modal.is-visible .modal-overlay{opacity:1;visibility:visible;transition-delay:0s}.modal-wrapper{position:absolute;z-index:9999;top:6em;left:35%;width:900px;margin-left:-16em;background-color:#fff;box-shadow:0 0 1.5em hsla(0,0%,0%,.35)}.modal-transition{transition:.3s .12s;transform:translateY(-10%);opacity:0}.modal.is-visible .modal-transition{transform:translateY(0);opacity:1}.modal-content,.modal-header{padding:1em}.modal-header{position:relative;background-color:#fff;box-shadow:0 1px 2px hsla(0,0%,0%,.06);border-bottom:1px solid #e8e8e8}.modal-close{position:absolute;top:0;right:0;padding:0 1em;color:#aaa;background:0 0;border:0}.modal-close:hover{color:#777}.modal-heading{font-size:1.125em;margin:0;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.modal-content>:first-child{margin-top:0}.modal-content>:last-child{margin-bottom:0}.modal-active{display:inline-block;top:210%}.carousel-control-next,.carousel-control-prev{width:5%!important}
        .footer_main{padding:50px 0 0!important}.contact__form-agree input:hover,.contact__form-agree label:hover{cursor:pointer}.contact__form-agree label a:hover,.contact__info-text p a:hover{color:#db3636}.contact__form-input input,.contact__form-input select,.contact__form-input textarea{width:100%;height:56px;line-height:54px;padding:0 23px;background:#f3f4f8;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;border:2px solid #f3f4f8;color:#0e1133;font-size:15px;margin-bottom:20px}.contact__form-input input::placeholder,.contact__form-input textarea::placeholder{font-size:15px;color:#6d6e75}.contact__form-input input:focus,.contact__form-input textarea:focus{border-color:#db3636;outline:0;background:#fff}.contact__form-input textarea{height:180px;padding:23px 25px;line-height:1.1;resize:none;margin-bottom:13px}.contact__form-agree{padding-left:5px}.contact__form-agree input{margin:0;appearance:none;-moz-appearance:none;display:block;width:14px;height:14px;background:#fff;border:1px solid #b9bac1;outline:0;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}.contact__form-agree input:checked{position:relative;background-color:#db3636;border-color:transparent}.contact__form-agree input:checked::after{box-sizing:border-box;content:"\f00c";position:absolute;font-family:"Font Awesome 5 Pro";font-size:10px;color:#fff;top:46%;left:50%;-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.contact__form-agree label{padding-left:8px;color:#53545b}.contact__form-agree label a{font-weight:600;padding-left:4px;color:#db3636!important}.contact__info-inner{padding:45px 70px 45px 40px;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;-webkit-box-shadow:0 30px 50px 0 rgba(1,11,60,.1);-moz-box-shadow:0 30px 50px 0 rgba(1,11,60,.1);box-shadow:0 30px 50px 0 rgba(1,11,60,.1);position:relative;z-index:1}.contact__info-icon svg{fill:none;stroke:#db3636;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.contact__info-icon svg.map{width:16px;height:20px}.contact__info-icon svg.call,.contact__info-icon svg.mail{width:18px;height:18px}.contact__info-text h4{font-size:20px;font-weight:600;margin-bottom:6px}.contact__info-text p{margin-bottom:0;color:#53545b}.contact__social h4{font-size:20px;font-weight:600;margin-bottom:13px}.contact__social ul li a{display:inline-block;width:40px;height:40px;line-height:44px;text-align:center;font-size:13px;color:#0e1133;background:#f3f4f8;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}.contact__social ul li a.fb{color:#285da1;background:rgba(40,93,161,.1)}.contact__social ul li a.fb:hover{color:#fff;background:#285da1}.contact__social ul li a.tw{color:#03a9f4;background:rgba(3,169,244,.1)}.contact__social ul li a.tw:hover{color:#fff;background:#03a9f4}.contact__social ul li a.pin{color:#d8163f;background:rgba(216,22,63,.1)}.contact__social ul li a.pin:hover{color:#fff;background:#d8163f}.contact__social ul li a.linkedin{color:#0077b5;background:#0077b53d}.contact__social ul li a.linkedin:hover{color:#fff;background:#0077b5}.contact__social ul li a.instagram{color:#ff8400;background:#ffddb9}.contact__social ul li a.instagram:hover{color:#fff;background:linear-gradient(45deg,#f9ce34 0,#ee2a7b 50%,#6228d7 100%)}.contact__social ul li a.baha{color:#053eff;background:#c4d1ff}.contact__social ul li a.baha:hover{color:#fff;background:#053eff}.contact__icon{margin-bottom:28px}.contact__icon svg{width:70px;height:70px;backface-visibility:hidden;-webkit-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);-o-transform:translate3d(0,0,0);transform:translate3d(0,0,0);-webkit-transition:transform .3s cubic-bezier(.21, .6, .44, 2.18);-moz-transition:transform .3s cubic-bezier(.21, .6, .44, 2.18);-ms-transition:transform .3s cubic-bezier(.21, .6, .44, 2.18);-o-transition:transform .3s cubic-bezier(.21, .6, .44, 2.18);transition:transform .3s cubic-bezier(.21, .6, .44, 2.18)}.contact__icon svg .st0{fill:none;stroke:#db3636;stroke-width:.5;stroke-linecap:round;stroke-linejoin:round}.contact__item{padding:50px 80px 62px;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;-webkit-box-shadow:0 40px 50px 0 rgba(1,11,60,.08);-moz-box-shadow:0 40px 50px 0 rgba(1,11,60,.08);box-shadow:0 40px 50px 0 rgba(1,11,60,.08);position:relative;z-index:1}.contact__item:hover .contact__icon svg{-webkit-transform:translate3d(0,-10px,0);-moz-transform:translate3d(0,-10px,0);-ms-transform:translate3d(0,-10px,0);-o-transform:translate3d(0,-10px,0);transform:translate3d(0,-10px,0)}.contact__title{font-size:26px;margin-bottom:8px}.contact__content p{font-size:16px;color:#53545b;margin-bottom:30px}.contact__shape img{position:absolute}.contact__shape img.contact-shape-1{bottom:75px;left:-30px;z-index:-1}.contact__shape img.contact-shape-2{top:30px;right:-30px}.contact__shape img.contact-shape-3{right:-45%;top:50%}@media only screen and (min-width:1400px) and (max-width:1600px){.contact__shape img.contact-shape-3{right:-20%}}@media only screen and (min-width:1200px) and (max-width:1399px){.contact__shape img.contact-shape-3{right:-10%}}@media only screen and (min-width:992px) and (max-width:1199px){.contact__shape img.contact-shape-2{right:-20px}.contact__shape img.contact-shape-3{right:-5%}}@media only screen and (min-width:768px) and (max-width:991px){.contact__info-inner{margin-top:50px}.contact__item{padding-left:30px;padding-right:30px}.contact__shape img.contact-shape-2{right:-20px}.contact__shape img.contact-shape-3{right:-5%}}@media only screen and (min-width:576px) and (max-width:767px){.contact__info-inner{margin-top:50px}.contact__shape img.contact-shape-2{right:-20px}.contact__shape img.contact-shape-3{right:-5%}}@media (max-width:575px){.contact__info-inner{margin-top:50px;padding-right:35px}.contact__item{padding-left:20px;padding-right:20px}.contact__shape img.contact-shape-2,.contact__shape img.contact-shape-3{right:0}}.contact__shape img.contact-shape-4{right:180px;bottom:-21%}.contact__shape img.contact-shape-5{left:0;bottom:142px}#form-messages{text-align:center;margin-top:10px}.contact__social ul li{display:inline-block;margin-right:4px!important}.e_cerror,.e_error,.termsCheckSubmit{display:none}.e-btn{display:inline-block;height:50px;line-height:52px;text-align:center;padding:0 25px;color:#fff;background:#631b1d;border:none;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;font-weight:500;text-transform:capitalize}
        .footer_main{padding:50px 0 0!important}.vcontrol button{position:absolute;left:43%;bottom:0;min-width:0;border:none;border-radius:40px;height:30px;top:82%;right:50%;transform:translate(50%,-50%);font-size:15px;font-weight:bolder;padding:0;pointer-events:all;z-index:100;text-decoration:none;color:#ffffff91;text-align:center;width:100px;background:0 0}.vcontrol button.playing .video-control-play,.vcontrol button:not(.playing) .video-control-pause{display:none}.video-control-symbol{font:35px Apple Color Emoji;vertical-align:0}@media screen and (min-width:375px){.vcontrol button{left:25%}}@media screen and (min-width:425px){.vcontrol button{left:28%}}@media screen and (min-width:768px){.vcontrol button{left:38%}}@media screen and (min-width:1024px){.vcontrol button{left:41%}}@media screen and (min-width:1440px){.vcontrol button{left:44%}}@media screen and (min-width:2560px){.vcontrol button{left:46%}}
        .contact__social ul li a.youtube:hover {color: #fff; background: red;}
    </style>
</head>
<body>
    <div class="modal">
        <div class="modal-overlay modal-toggle"></div>
        <div class="modal-wrapper modal-transition">
            <div class="modal-header">
                <button class="modal-close modal-toggle">x</button>
            </div>
            <div class="modal-body">
                <h2 class="modal-heading"></h2>
                <div class="modal-content"></div>
            </div>
        </div>
    </div>
    <?php
    $link = $_SERVER['PHP_SELF'];
    $link_array = explode('/',$link);
    $page = end($link_array);
    ?>
    <header class="main_header <?php if($page != 'index.php') { echo "sub_header"; }?>">
        <div class="container h-100">
            <nav class="navbar navbar-expand-lg p-0 h-100">
                <a class="navbar-brand" href="<?= base_url() ?>">
                    <img src="<?= base_url() ?>uploads/logo/<?= $settings->logo ?>" alt="">
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
                            <a class="nav-link active" aria-current="page" href="<?= base_url() ?>portfolio">Portfolios </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= base_url() ?>guidelines">Prayer Guidelines</a>
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