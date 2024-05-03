<style>
.modal-active{display:inline-block;top:93%}
.Donate_Btn {top: 105% !important;}
.content{ overflow-y: scroll; height: 600px; padding: 20px;scrollbar-width: thin; scrollbar-color: #ffffff #741623;}
.content img{width: 100% !important; height: 450px !important;}
</style>
<section class="container Data_Container">
    <div class="row">
        <div class="col-12">
            <h1><?= $guidelines->title ?></h1>
            <div class="content"><?= $guidelines->description ?></div>
        </div>
    </div>
    </div>
</section>
<section class="banner" style="margin-top: 20px;">
    <div class="container">
        <div class="banner_inner">
            <h1>Try our Prayer app for more things to do</h1>
            <div class="d-flex icon_flex align-items-center">
                <a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer" class="mb-2"><img src="<?= base_url() ?>assets/images/playstoreicon.png" alt=""> Play Store</a>
                <a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470" class="mb-2"><img src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""> App Store</a>
            </div>
        </div>
    </div>
</section>