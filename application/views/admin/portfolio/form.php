<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css"> -->
<style type="text/css">
	#loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}
#loader img {
    width: 50px;
    height: 50px;
}
#loader p {
    margin-top: 10px;
    font-size: 16px;
}
</style>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="row">
			<div class="col-xl-12">
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="page-title"><?php echo $heading ?></h3>
						</div>
					</div>
				</div>

				<div id="loader" style="display:none;">
					<img src="<?= base_url() ?>uploads/loading.gif" alt="Loading...">
					<p>Please wait...</p>
				</div>

				<div class="card">
					<div class="card-body">
						<?php if ($button == 'Update') { ?>
						<form id="myForm" action="<?php echo admin_url('Manage_portfolio/update_action'); ?>" method="post" enctype="multipart/form-data">
						<?php } else { ?>
						<form id="myForm" class="forms-sample" action="<?php echo admin_url('Manage_portfolio/create_action'); ?>" method="post" enctype="multipart/form-data">
						<?php } ?>
							<div class="form-group">
								<label>Portfolio Title <span style="color:red;">*</span><span id="title_err"></span></label>
								<input class="form-control" type="text" placeholder="Example: Portfolio Title" name="title" id="title" value="<?= @$title; ?>" required>
							</div>
							<div class="form-group">
								<label>Portfolio Description <span style="color:red;">*</span></label>
								<textarea class="form-control" name="description" id="description"><?= @$description ?></textarea>
							</div>
							<div class="form-group">
								<label>Portfolio Type <span style="color:red;">*</span></label>
								<select class="form-control" name="file_type" id="file_type" required>
									<option value="">Select Type</option>
									<option value="1" <?php if (@$file_type == '1') { echo "selected"; } ?>>Video Link</option>
									<option value="2" <?php if (@$file_type == '2') { echo "selected"; } ?>>File Upload</option>
								</select>
							</div>
							<div class="form-group ytlink" <?php if(@$file_type == '1') { echo "style='display: block'"; }?>>
								<label>Youtube Link <span style="color:red;">*</span></label>
								<input class="form-control" type="text" placeholder="Example: https://www.youtube.com/embed/eI4an8aSsgw" name="file_link" id="file_link" value="<?= @$file_link; ?>">
							</div>

							<div class="form-group imageupload" <?php if(@$file_type == '2') { echo "style='display: block'"; }?>>
								<div class="form-group">
									<label>Upload Image <span style="color:red;">*</span></label>
									<input type="file" name="file_image" id="file_image" class="form-control">
									<input type="hidden" name="old_image" value="<?= @$file_link ?>">
								</div>
								<?php if ($button == 'Update') {
									if (file_exists("uploads/portfolio/image/".$file_link) && !empty($file_link)) { ?>
										<div class="form-group">
											<img src="<?php echo base_url() ?>/uploads/portfolio/image/<?= @$file_link ?>" style="width: 150px;">
										</div>
									<?php } else { ?>
										<div class="form-group">
											<img src="<?php echo base_url() ?>/uploads/no_image.png" style="width: 150px;">
										</div>
									<?php }
								} ?>
							</div>
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="button" value="<?php echo $button; ?>">
							<input type="hidden" name="user_id" value="<?php echo @$_SESSION['afrebay_admin']['id']; ?>">
							<input type="hidden" name="old_image1" value="<?= @$file_link ?>">
							<div class="mt-4">
								<button class="btn btn-primary submit_button" type="submit">Submit</button>
								<a href="<?= admin_url('manage_podcast') ?>" class="btn btn-link">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.ytlink {display: none;}
	.imageupload {display: none;}
</style>
<script>
var url = '<?= admin_url('Manage_portfolio/ajax_manage_page')?>';
var actioncolumn=3;
</script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script type="text/javascript" src="<?= base_url('dist/assets/custom_js/portfolio.js')?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
	CKEDITOR.replace('description');
</script>
<script>
document.getElementById("myForm").addEventListener("submit", function(event) {
	// Show loader when form is submitted
	// document.getElementById("loader").style.display = "block";
	$('#loader').show();
});

function only_numbers(event) {
	var x = event.which || event.keyCode;
	console.log(x);
	if ((x >= 48) && (x <= 57) || x == 8 | x == 9 || x == 13) {
		return;
	} else {
		event.preventDefault();
	}
}
$("#file_type").change(function(){
	if($("#file_type").val() == "1") {
		$(".imageupload").hide();
		$(".ytlink").show();
		$("#file_link").val('');
		$("#file_link").prop('required',true);
		$("#file_image").val('');
		$("#old_image").val('');
		$("#file_image").removeAttr('required');
	} else if($("#file_type").val() == "2") {
		$(".ytlink").hide();
		$(".imageupload").show();
		$("#file_link").val('');
		$("#file_image").val('');
		$("#file_link").removeAttr('required');
		$("#file_image").attr('required',true);
	} else {
		$(".imageupload").hide();
		$(".ytlink").hide();
		$("#file_link").prop('required',false);
		$("#file_image").prop('required',false);
		$("#file_link").val('');
		$("#file_image").val('');
	}
})
</script>