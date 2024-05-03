<style>
.modal-active{display:inline-block;top:140%}
.Donate_Btn {top: 105% !important;}
.ytp-title-link{display: none !important;}
</style>
<section class="container Data_Container">
    <div class="row">
        <div class="col-12">
            <h1 style="text-align: left;"><?= $portfolioDetails->title ?></h1>
            <?php if(!file_exists("uploads/portfolio/image/".$portfolioDetails->file_link)) { ?>
            <iframe src="<?= $portfolioDetails->file_link?>" style="height: 400px;width: 100%;"></iframe>
            <?php } else {?>
            <img src="<?php echo base_url()?>/uploads/portfolio/image/<?= $portfolioDetails->file_link?>" style="width: 100%;height: 400px;">
            <?php } ?>
            <div><?= $portfolioDetails->description ?></div>
        </div>
    </div>
</section>
<section class="banner">
    <div class="container">
        <div class="banner_inner">
            <h1>Try our Prayer app for more things to do</h1>
            <div class="d-flex icon_flex align-items-center">
                <a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer" class="mb-2"><img
                        src="<?= base_url() ?>assets/images/playstoreicon.png" alt=""> Play Store</a>
                <a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470" class="mb-2"><img
                        src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""> App Store</a>
            </div>
        </div>
    </div>
</section>