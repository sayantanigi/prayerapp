<style>
    .modal-active {
        display: inline-block;
        top: 64%
    }

    .Donate_Btn {
        top: 105% !important;
    }

    .ytp-title-link {
        display: none !important;
    }
</style>
<section class="container Data_Container">
    <div class="row">
        <div class="col-12">
            <h1><?= $title ?></h1>
        </div>
    </div>
</section>
<section class="main_section py-0 px-lg-5 ">
    <div class="container-fluid">
        <div class="row">
            <?php
            if ($portfolio) {
            $i = 1;
            foreach ($portfolio as $value) {
                $string = strip_tags($value['description']);
                if (strlen($string) > 500) {
                    $stringCut = substr($string, 0, 900);
                    $endPoint = strrpos($stringCut, ' ');
                    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                    $string .= '    <a href="'.base_url().'portfolio_details/'.$value['id'].'" style="display: contents;">Learn More</a>';
                }
            ?>
            <div class="col-md-12 mb-5">
                <div class="row">
                    <?php if ($i % 2 == 0) { ?>
                    <div class="col-md-8 d-flex align-items-center text-justify" style="height: 256px;"><?= $string?></div>
                    <?php } ?>
                    <div class="col-md-4">
                        <div class="prayer_images" style="height: 256px">
                            <?php if (!file_exists("uploads/portfolio/image/" . $value['file_link'])) { ?>
                            <iframe src="<?= $value['file_link'] ?>" style="width: 100%; height: 256px; border-radius: 15px;"></iframe>
                            <?php } else { ?>
                            <img src="<?php echo base_url() ?>/uploads/portfolio/image/<?= $value['file_link'] ?>" style="height: 256px">
                            <?php } ?>
                            <div class="prayer_images_content">
                                <span>
                                <i class="fa fa-area-chart" aria-hidden="true"></i>
                                <?php if (@$value['file_type'] == '1') {
                                    echo "Video";
                                } else {
                                    echo "Image";
                                } ?>
                                </span>
                                <p style="bottom: 35px; position: absolute;">
                                    <a href="<?= base_url() ?>portfolio_details/<?= $value['id'] ?>"><?= $value['title'] ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php if ($i % 2 != 0) { ?>
                    <div class="col-md-8 d-flex align-items-center text-justify" style="height: 256px;"><?= $string?></div>
                    <?php } ?>
                </div>
            </div>
            <?php $i++; } } ?>
        </div>
    </div>
</section>
<section class="banner" style="margin-top: 20px;">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(window).on('load', function () {
        $('.ytp-title-link').remove();
    });
</script>