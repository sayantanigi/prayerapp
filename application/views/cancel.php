<style>
.modal-active{display:inline-block;top:32%}
.Donate_Btn {top: 105% !important;}
</style>
<?php $settings = $this->db->query("SELECT * FROM setting")->row(); ?>
<section class="container Data_Container">
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