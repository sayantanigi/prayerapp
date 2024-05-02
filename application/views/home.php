<div id="carouselExampleIndicators" class="carousel slide Custom_Carousel" data-ride="carousel">
    <!-- <ol class="carousel-indicators">
    <?php
    $i = 1;
    foreach ($banner as $slprayer) { ?>
        <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>" class="active"></li>
        <?php $i++;
    } ?>
    </ol> -->
    <div id="carrousel" class="carousel-inner">
        <?php if (!empty($banner)) {
        $j = 1;
        foreach ($banner as $slprayer) { ?>
        <div data-pause="true" data-interval="10000" class="carousel-item <?php if ($j == '1') { echo "active"; } ?>">
            <!-- Paypal Button Start -->
            <!-- <form action="https://www.sandbox.paypal.com/donate" method="post" target="_top" class="Donate_Btn">
                <input type="hidden" name="hosted_button_id" value="U3JU8K97MQJ22" />
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" style="width: 150px;" />
            </form> -->
            <!-- <form action="https://www.paypal.com/donate" method="post" target="_top" class="Donate_Btn">
                <input type="hidden" name="hosted_button_id" value="26SNJ5EJNG542" />
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" style="width: 150px;" />
            </form> -->
            <form action="https://www.sandbox.paypal.com/donate" method="post" target="_top" class="Donate_Btn">
                <input type="hidden" name="hosted_button_id" value="TEBN89P7ZHHL8" />
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" style="width: 150px;" />
            </form>
            <!-- Paypal Button End -->
            <?php
            $allowed = array('JPEG', 'PNG', 'JPG', 'GIF', 'jpeg', 'jpg', 'png', 'gif');
            $filename = $slprayer['image'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!empty($slprayer['image']) && file_exists("uploads/banner/" . $slprayer['image'])) {
                if (in_array($ext, $allowed)) { ?>
                    <img src="<?= base_url() ?>uploads/banner/<?= $slprayer['image'] ?>" alt="" style="height: 750px">
                <?php } else { ?>
                    <video width="100%" class="elVideo" loop="loop" autoplay playsInline muted id='video-slider-<?= $j ?>'>
                        <source src="<?= base_url() ?>uploads/banner/<?= $slprayer['image'] ?>" type="video/mp4">
                    </video>
                    <!-- <div class="vcontrol">
                        <button class="video-control-<?= $j?>">
                            <span class="video-control-play">
                                <span class="video-control-symbol" aria-hidden="true"><i class="fa fa-play" aria-hidden="true"></i></span>
                            </span>
                            <span class="video-control-pause">
                                <span class="video-control-symbol" aria-hidden="true"><i class="fa fa-pause" aria-hidden="true"></i></span>
                            </span>
                        </button>
                    </div> -->
                    <div class="sliderText"><?= $slprayer['page_name'] ?></div>
                    <div class="downloadLink">
                        <a class="idownloadLink" href="https://apps.apple.com/us/app/120-army-prayer/id6478201470">
                            <img src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""> App Store
                        </a>
                        <a class="gdownloadLink" href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer">
                            <img src="<?= base_url() ?>assets/images/playstoreicon.png" alt=""> Play Store
                        </a>
                    </div>
                <?php }
            } else { ?>
                <img src="<?= base_url() ?>uploads/no_image.png?>" alt="" style="height: 750px">
            <?php } ?>
        </div>
        <?php $j++; } } ?>
    </div>
    <div class="container-fluid containerVideobg">
        <div class="videoSliderBackground"></div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev" onclick="$('#carrousel').carousel('prev')">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next" onclick="$('#carrousel').carousel('next')">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<section class="main_section py-5 px-lg-5 "
    style="background-image: url(<?= base_url() ?>uploads/prayer/<?= $ourprayerEvents->bg_image ?>); background-size: cover;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="main_section_left">
                    <h3 class="text-white"><?php echo $ourprayerEvents->bg_heading ?></h3>
                    <div class="row">
                        <?php
                        if ($prayerEvents) {
                            $i = 1;
                            foreach ($prayerEvents as $events) { ?>
                                <div class="col-md-4 mt-4 mb-4">
                                    <div class="prayer_images">
                                        <?php if (!empty($events['prayer_image'])) { ?>
                                            <img src="<?= base_url() ?>uploads/prayer/<?= $events['prayer_image'] ?>" alt=""
                                                style="height: 256px">
                                        <?php } else { ?>
                                            <img src="<?= base_url() ?>uploads/no_image.png" alt="" style="height: 250px">
                                        <?php } ?>
                                        <div class="prayer_images_content">
                                            <span><i class="fa fa-area-chart" aria-hidden="true"></i> Event</span>
                                            <p>
                                                <a
                                                    href="<?= base_url() ?>event_details/<?= $events['id'] ?>"><?= $events['prayer_name'] ?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++;
                            }
                        } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="main_section_left eventBox">
                    <h3>Future Events</h3>
                    <?php
                    $nowDate = date('Y-m-d');
                    $futureDate = $this->db->query("SELECT distinct(prayer_datetime) FROM all_prayers WHERE prayer_datetime > '" . $nowDate . "' AND status = 1 AND is_delete = 1 ORDER BY prayer_datetime ASC limit 4")->result_array();
                    foreach ($futureDate as $day) { ?>
                        <h5><?= date('D', strtotime($day['prayer_datetime'])) ?></h5>
                        <?php
                        $getPrayer = $this->db->query("SELECT * FROM all_prayers WHERE prayer_datetime = '" . $day['prayer_datetime'] . "' AND status = 1 AND is_delete = 1 ORDER BY prayer_datetime ASC limit 1")->result_array();
                        foreach ($getPrayer as $prayer) { ?>
                            <ul>
                                <li>
                                    <?php
                                    $prayer_datetime = date('Y-m-d h:i A', strtotime($prayer['prayer_datetime']));
                                    $prayer_date = date('F d l', strtotime($prayer_datetime));
                                    $date = explode(' ', $prayer_date);
                                    ?>
                                    <h4><?= $date[1] ?><span><?= $date[0] ?></span></h4>
                                    <div class="right_event">
                                        <p><?= $prayer['prayer_name'] ?></p>
                                        <span><i class="fa fa-map-marker"
                                                aria-hidden="true"></i><?= $prayer['prayer_location'] ?></span>
                                    </div>
                                </li>
                            </ul>
                        <?php }
                    } ?>
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
                <p>Discover a faith enhancing spiritual journey with our Prayer App, your all-in-one faithful
                    companion.</p>
                <div class="qr_sec d-flex">
                    <div class="icon_flex">
                        <a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer"><img
                                src="<?= base_url() ?>assets/images/playstoreicon.png" alt=""> Play Store</a>
                        <a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470"><img
                                src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""> App Store</a>
                    </div>
                    <div class="qr_code">
                        <img src="<?= base_url() ?>assets/images/qr_code.png" alt=""
                            style="width: 100px; height:100px;">
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
                    <a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer"> <img
                            src="<?= base_url() ?>assets/images/playstoreicon.png" alt=""></a>
                    <a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470"><img
                            src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section>