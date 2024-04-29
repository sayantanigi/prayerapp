<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title"><?php echo $heading?></h3>
                        </div>
                    </div>
                </div>
                <?php //echo "<pre>"; print_r($pod_main); die();?>
                <div class="card">
                    <div class="card-body">
                        <!--<div class="form-group">-->
                        <!--    <?php $get_cat_name = $this->Crud_model->get_single('category',"id = '".$pod_main->podcast_cat_id."'");?>-->
                        <!--    <p><b>Category Name:</b> <?= $get_cat_name->category_name ?></p>-->
                        <!--</div>-->
                        <div class="form-group">
                            <p><b>Podcast Name:</b> <?= $pod_main->podcast_name ?></p>
                        </div>
                        <div class="form-group">
                            <label><b>Podcast Description:</b> <?= $pod_main->podcast_description ?></label>
                        </div>
                        <div class="form-group">
                            <label><b>Cover Image</b></label>
                            <?php if($pod_main->podcast_cover_image) { ?>
                            <img src="<?php echo base_url()?>/uploads/podcast/cover_image/<?= $pod_main->podcast_cover_image?>" style="width: 150px;">
                            <?php } else {?>
                            <img src="<?php echo base_url()?>/uploads/no_image.png" style="width: 150px;">
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label><b>Podcast File</b></label>
                            <?php if($pod_main->podcast_file) { ?>
                            <!-- <img src="<?php echo base_url()?>/uploads/podcast/podcast_file/<?= $pod_main->podcast_file?>" style="width: 150px;"> -->
                            <audio controls><source src="<?php echo base_url()?>/uploads/podcast/podcast_file/<?= $pod_main->podcast_file?>"></audio>
                            <?php } else {?>
                            <img src="<?php echo base_url()?>/uploads/no_image.png" style="width: 150px;">
                            <?php } ?>
                        </div>
                        <!-- <div class="form-group">
                            <label><b>Podcast Contents</b><span> </span></label>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table class="table jobsites" id="purchaseTableclone1">
                                        <tbody id="clonetable_feedback1">
                                            <?php if(!empty($pod_content)) {
                                            $rows=1;
                                            foreach ($pod_content as $key) { ?>
                                            <tr>
                                                <td style="width: 72%;"><p><?= $key->content_title; ?></p></td>
                                                <td>
                                                    <audio controls><source src="<?php echo base_url()?>/uploads/podcast/podcast_file/<?= $key->podcast_file; ?>"></audio>
                                                </td>
                                            </tr>
                                            <?php } }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.showSubPrice {display: none;}
.showProdKey {display: none;}
.showPriceKey {display: none;}
.showPaystackField {display: none;}
</style>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    CKEDITOR.replace('podcast_description');
</script>
<script >
function add_row() {
    var y=document.getElementById('clonetable_feedback1');
    var new_row = y.rows[0].cloneNode(true);
    var len = y.rows.length;
    new_number=Math.round(Math.exp(Math.random()*Math.log(10000000-0+1)))+0;
    var inp3 = new_row.cells[0].getElementsByTagName('input')[0];
    inp3.value = '';
    inp3.id = 'service'+(len+1);
    var submit_btn =$('#submit').val();
    y.appendChild(new_row);
}

function remove(row) {
    var y=document.getElementById('purchaseTableclone1');
    var len = y.rows.length;
    if(len>2) {
        var i= (len-1);
        document.getElementById('purchaseTableclone1').deleteRow(i);
    }
}

function only_number(event) {
    var x = event.which || event.keyCode;
    console.log(x);
    if((x >= 48 ) && (x <= 57 ) || x == 8 | x == 9 || x == 13 || x == 46) {
        return;
    } else {
        event.preventDefault();
    }
}

function only_numbers(event) {
    var x = event.which || event.keyCode;
    console.log(x);
    if((x >= 48 ) && (x <= 57 ) || x == 8 | x == 9 || x == 13) {
        return;
    } else {
        event.preventDefault();
    }
}
</script>
