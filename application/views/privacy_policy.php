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
        .modal,.modal-overlay{top:0;left:0;width:100%;height:100%;visibility:hidden}.modal{position:absolute;z-index:10000}.modal.is-visible{visibility:visible}.modal-overlay{position:fixed;z-index:10;background:hsla(0,0%,0%,.5);opacity:0;transition:visibility 0s linear .3s,opacity .3s}.modal.is-visible .modal-overlay{opacity:1;visibility:visible;transition-delay:0s}.modal-wrapper{position:absolute;z-index:9999;top:6em;left:35%;width:900px;margin-left:-16em;background-color:#fff;box-shadow:0 0 1.5em hsla(0,0%,0%,.35)}.modal-transition{transition:.3s .12s;transform:translateY(-10%);opacity:0}.modal.is-visible .modal-transition{transform:translateY(0);opacity:1}.modal-content,.modal-header{padding:1em}.modal-header{position:relative;background-color:#fff;box-shadow:0 1px 2px hsla(0,0%,0%,.06);border-bottom:1px solid #e8e8e8}.modal-close{position:absolute;top:0;right:0;padding:0 1em;color:#aaa;background:0 0;border:0}.modal-close:hover{color:#777}.modal-heading{font-size:1.125em;margin:0;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.modal-content>:first-child{margin-top:0}.modal-content>:last-child{margin-bottom:0}.modal-active{display:inline-block;top:141%}
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
                    <a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470"><img src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""> App Store</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer_main">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php 
                    $getFAQlist = $this->db->query("SELECT * FROM faq WHERE status = '1'")->result_array();
                    if(!empty($getFAQlist)) { ?>
                    <div class="f_content">
                        <h2>More About Prayer App</h2>
                        <?php foreach ($getFAQlist as $value) { ?>
                        <a href="javascript:void(0)" onclick="showContent(<?= $value['id']?>)"><?= $value['question']?></a>    
                        <?php } ?>
                    </div>
                    <?php } ?>
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

            $('.modal-close').click(function(){
                $('.modal').removeClass('is-visible modal-active');
            })
        });

        function showContent(id) {
            $.ajax({
                type:'post',
                cache:false,
                url: '<?= base_url() ?>api/Home/get_faq',
                data:{id:id},
                success:function(returndata) {
                    var obj=$.parseJSON(returndata); 
                    console.log(obj);
                    $(".modal-heading").html(obj.question);
                    $(".modal-content").html(obj.answer);
                    $('.modal').addClass('is-visible modal-active');
                }
            })
        }
    </script>
</body>
</html>