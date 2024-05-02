<?php $settings = $this->db->query("SELECT * FROM setting")->row(); ?>
<footer class="footer_main">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php
                $getFAQlist = $this->db->query("SELECT * FROM faq WHERE status = '1'")->result_array();
                if (!empty($getFAQlist)) { ?>
                <div class="f_content">
                    <h2>More About Prayer App</h2>
                    <?php foreach ($getFAQlist as $value) { ?>
                        <a href="javascript:void(0)" onclick="showContent(<?= $value['id'] ?>)"><?= $value['question'] ?></a>
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
                        <li><a href="<?= @$settings->fb_link; ?>" target="_blank" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="<?= @$settings->tw_link; ?>" target="_blank" class="tw"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="<?= @$settings->insta_link; ?>" target="_blank" class="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="<?= @$settings->lnkd_link; ?>" target="_blank" class="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        <!-- <li><a href="<?= @$settings->baha_link; ?>" target="_blank" class="baha"><i class="fa fa-behance" aria-hidden="true"></i></a></li> -->
                        <li><a href="<?= @$settings->youtube_link; ?>" target="_blank" class="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                        <li><a href="<?= @$settings->ptrs_link; ?>" target="_blank" class="pin"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="f_content F_Logo">
                    <a href="<?= base_url() ?>" class="text-end">
                        <img src="<?= base_url() ?>uploads/logo/<?= $settings->flogo ?>">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="f_content mt-5 text-end F_Logo" style="padding: 15px 0;margin: 0 !important; background: #741623;">
        <div class="copyright" style="color: #fff;text-align: left;width: 48%;display: inline-block;float: left;margin-left: 60px;"> Copyright © <?= date('Y') ?> 120Army</div>
        <div class="developer" style="color: #fff;text-align: right;width: 38%;display: inline-block;margin-right: 60px;">Designed &amp; Developed By <a href="http://www.goigi.com/" class="igi-link" style="color: #08cbfe; display: inline-block;" target="_blank">GOIGI.COM</a></div>
    </div>
</footer>
<script src="<?= base_url() ?>assets/js/jquery-3.6.0.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/js/owl.carousel.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.1/js/bootstrap.min.js'></script>
<script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
<script src="<?= base_url();?>dist/assets/notify/notify.min.js"></script>
<?php if($this->session->flashdata('message')) { ?>
<script type="text/javascript">
    var sessionMessage = '<?php echo $this->session->flashdata('message'); ?>';
    $.notify(sessionMessage,{ position:"top right",className: 'success' });
</script>
<?php unset($_SESSION['message']); ?>
<?php } ?>
<script>
<?php
/*$j = 1;
foreach ($banner as $slprayer) { ?>
const videoElement<?= $j ?> = document.querySelector('#video-slider-<?= $j ?>');
const playPauseButton<?= $j ?> = document.querySelector('.video-control-<?= $j?>');

playPauseButton<?= $j ?>.addEventListener('click', () => {
    playPauseButton<?= $j ?>.classList.toggle('playing');
    if (playPauseButton<?= $j ?>.classList.contains('playing')) {
        videoElement<?= $j ?>.play();
    }
    else {
        videoElement<?= $j ?>.pause();
    }
});

videoElement<?= $j ?>.addEventListener('ended', () => {
    playPauseButton<?= $j ?>.classList.remove('playing');
});
<?php $j++; } */?>

$(document).ready(function () {
    $('a[href = "#"]').click(function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $('#download_appsec_outer').offset().top
        }, 500);
    });
    $('.modal-close').click(function () {
        $('.modal').removeClass('is-visible modal-active');
    })
});

function showContent(id) {
    $.ajax({
        type: 'post',
        cache: false,
        url: '<?= base_url() ?>api/Home/get_faq',
        data: { id: id },
        success: function (returndata) {
            var obj = $.parseJSON(returndata);
            console.log(obj);
            $(".modal-heading").html(obj.question);
            $(".modal-content").html(obj.answer);
            $('.modal').addClass('is-visible modal-active');
        }
    })
}

function send_message() {
    var email = $('#email').val();
    var name = $('#name').val();
    var subject = $('#subject').val();
    var phone = $('#phone').val();
    var message = $('#message').val();
    if (email == "") {
        $('.e_error').fadeIn('slow');
        setTimeout(() => {
                $('.e_error').fadeOut('slow');
        }, 5000);
    } else if(name == ""){
        $('.e_error').fadeIn('slow');
        setTimeout(() => {
                $('.e_error').fadeOut('slow');
        }, 5000);
    } else if(subject == ""){
        $('.e_error').fadeIn('slow');
        setTimeout(() => {
                $('.e_error').fadeOut('slow');
        }, 5000);
    } else if(phone == ""){
        $('.e_error').fadeIn('slow');
        setTimeout(() => {
                $('.e_error').fadeOut('slow');
        }, 5000);
    } else if(message == ""){
        $('.e_error').fadeIn('slow');
        setTimeout(() => {
                $('.e_error').fadeOut('slow');
        }, 5000);
    } else {
        $.ajax({
            url: '<?php echo base_url("home/contactFormSubmit") ?>',
            type: 'post',
            data: {name: name, email: email, subject: subject, phone: phone, message: message,},
            success: function (response) {
                if (response == 1) {
                    $('.success_msg').html('<p style="color: green; margin-top: 25px;">Your details has been sent.</p>');
                    $('#contact-form')[0].reset();
                        setTimeout(() => {
                        // location.reload();
                    }, 5000);
                } else {
                    $('.success_msg').html('<p style="color=#db3636; margin-top: 25px;">Opps! something went wrong. Please try again later.</p>');
                    $('#contact-form')[0].reset();
                    setTimeout(() => {
                        // location.reload();
                    }, 5000);
                }
            }
        });
    }
}

function delete_account() {
    var email = $('#email').val();
    if (email == "") {
        $('.e_error').fadeIn('slow');
        setTimeout(() => {
            $('.e_error').fadeOut('slow');
        }, 5000);
    } else {
        $.ajax({
            url: '<?php echo base_url("home/deleteFormSubmit") ?>',
            type: 'post',
            data: {email: email},
            success: function(response) {
                if (response == 1) {
                    $('.success_msg').html('<p style="color: green; margin-top: 25px;">Your account is permananetly deleted.</p>');
                    $('#contact-form')[0].reset();
                    setTimeout(() => {
                        location.reload();
                    }, 5000);
                } else {
                    $('.success_msg').html('<p style="color=#db3636; margin-top: 25px;">Opps! something went wrong. Please try again later.</p>');
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