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
                <?php //echo "<pre>"; print_r($portfolio_main); die();?>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <p><b>Portfolio Name:</b> <?= $portfolio_main->title ?></p>
                        </div>
                        <div class="form-group">
                            <label><b>Portfolio Description:</b> <?= $portfolio_main->description ?></label>
                        </div>
                        <div class="form-group">
                            <label><b>Portfolio File</b></br></label>
                        </div>
                        <div class="form-group">
                            <?php if(!file_exists("uploads/portfolio/image/".$portfolio_main->file_link)) { ?>
                            <iframe src="<?= $portfolio_main->file_link?>" style="height:290px; width:515px;"></iframe>
                            <?php } else {?>
                            <img src="<?php echo base_url()?>/uploads/portfolio/image/<?= $portfolio_main->file_link?>" style="width: 150px;">
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>