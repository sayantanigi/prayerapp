<style>
.modal-active {display: inline-block;top: 64%;}
.Donate_Btn {top: 105% !important;}
.ytp-title-link {display: none !important;}
@media only screen and (max-width: 425px) {
    .TextData {
        height: auto !important;
        margin: 20px 0;
    }
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
    <?php
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { ?>
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
                                <p style="top: 165px; position: relative;width: 100%;">
                                    <a href="<?= base_url() ?>portfolio_details/<?= $value['id'] ?>"><?= $value['title'] ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 d-flex align-items-center text-justify TextData" style="height: 256px;"><?= $string?></div>
                </div>
            </div>
            <?php $i++; } } ?>
        </div>
    <?php } else { ?>
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
                    <div class="col-md-8 d-flex align-items-center text-justify TextData" style="height: 256px;"><?= $string?></div>
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
                                <p style="top: 165px; position: relative;width: 100%;">
                                    <a href="<?= base_url() ?>portfolio_details/<?= $value['id'] ?>"><?= $value['title'] ?></a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php if ($i % 2 != 0) { ?>
                    <div class="col-md-8 d-flex align-items-center text-justify TextData" style="height: 256px;"><?= $string?></div>
                    <?php } ?>
                </div>
            </div>
            <?php $i++; } } ?>
        </div>
    <?php } ?>
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