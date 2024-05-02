<section class="container Data_Container">
    <div class="row">
        <div class="col-12">
            <h1 style="text-align: left;"><?= $prayerEvents->prayer_name ?></h1>
            <div>
                <p><?= $prayerEvents->prayer_subheading ?></p>
            </div>
            <div><?= $prayerEvents->prayer_description ?></div>
        </div>
        <div class="col-12">
            <!-- <img style="width: 100%; height: 500px; object-fit: cover;"
                src="" /> -->
            <?php if (!empty($prayerEvents->prayer_image)) { ?>
                <img style="width: 100%; height: 500px; object-fit: cover; border-radius: 20px;"
                    src="<?= base_url() ?>uploads/prayer/<?= $prayerEvents->prayer_image ?>">
            <?php } else { ?>
                <img style="width: 100%; height: 500px; object-fit: cover;" src="<?= base_url() ?>uploads/no_image.png"
                    alt="" style="height: 250px">
            <?php } ?>
        </div>
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