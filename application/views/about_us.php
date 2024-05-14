<style>
.modal-active{display:inline-block;top:93%}
.Donate_Btn {top: 105% !important;}
@media (max-width: 2560px) {
    .Donate_Btn{
        top: auto !important;
    }
}
@media (max-width: 1440px) {
    .Donate_Btn{
        top: auto !important;
    }
}
@media (max-width: 1024px) {
    .Donate_Btn{
        top: auto !important;
    }
}
@media (max-width: 768px) {
    .Donate_Btn{
        top: auto !important;
    }
}
@media (max-width: 425px) {
    .Donate_Btn{
        top: auto !important;
    }
}
@media (max-width: 375px) {
    .Donate_Btn{
        top: auto !important;
    }
}
@media (max-width: 320px) {
    .Donate_Btn {
        top: auto !important;
    }
}
</style>
<section class="container Data_Container">
    <div class="row">
        <div class="col-12">
            <h1><?= $content->title ?></h1>
            <div><?= $content->description ?></div>
        </div>
    </div>
    </div>
</section>
<section class="blesings_sec">
    <!-- Paypal Button Start -->
    <form action="https://www.sandbox.paypal.com/donate" method="post" target="_top" class="Donate_Btn">
        <input type="hidden" name="hosted_button_id" value="53LPWMUF3QSC4" />
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" name="submit"
            title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button"
            style="width: 150px;" />
    </form>
    <!-- Paypal Button End -->
    <h3 style="margin-top: 50px;">Your help is a Blessing</h3>
    <p>Quisque lobortis volutpat pellentesque. Quisque vehicula lorem in nibh lobortis, et ornare odio pellentesque.
        Proin id aliquet ipsum. Donec lacinia lorem iaculis, posuere velit vel, viverra diam.</p>
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