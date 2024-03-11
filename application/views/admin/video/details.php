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
                <?php //echo "<pre>"; print_r($vid_main); die();?>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <p><b>Video Name:</b> <?= $vid_main->videos_name ?></p>
                        </div>
                        <div class="form-group">
                            <label><b>Podcast Description:</b> <?= $vid_main->videos_description ?></label>
                        </div>
                        <div class="form-group">
                            <label><b>Video File</b></label>
                            <?php if($vid_main->videos_file) { ?>
                            <video width="320" height="240" controls>
								<source src="<?php echo base_url()?>/uploads/videos/videos_file/<?= @$vid_main->videos_file?>">
							</video>
                            <?php } else {?>
                            <img src="<?php echo base_url()?>/uploads/no_image.png" style="width: 150px;">
                            <?php } ?>
                        </div>
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
