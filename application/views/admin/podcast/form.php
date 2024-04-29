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
							<form id="myForm" action="<?php echo admin_url('Manage_podcast/update_action'); ?>" method="post"
								enctype="multipart/form-data">
							<?php } else { ?>
								<form id="myForm" class="forms-sample" action="<?php echo admin_url('Manage_podcast/create_action'); ?>"
									method="post" enctype="multipart/form-data">
									<!-- <form class="forms-sample" action="#"
									method="post" enctype="multipart/form-data"> -->
								<?php } ?>
								<!-- <div class="form-group">
								<label>Category</label>
								<select class="form-control" name="podcast_cat_id" id="podcast_cat_id" required>
									<option value="">Select Category</option>
									<?php if (!empty($category)) {
										foreach ($category as $item) { ?>
									<option value="<?= $item->id ?>" <?php if ($item->id == @$podcast_cat_id) { echo "selected"; } ?>><?= ucfirst($item->category_name) ?></option>
									<?php }
									} ?>
								</select>
							</div> -->
								<div class="form-group">
									<label>Podcast Name <span style="color:red;">*</span><span id="podcast_name_err"></span></label>
									<input class="form-control" type="text" placeholder="Example: Podcast Name"
										name="podcast_name" id="podcast_name" value="<?= @$podcast_name; ?>" required>
								</div>
								<div class="form-group">
									<label>Podcast Description <span style="color:red;">*</span></label>
									<textarea class="form-control" name="podcast_description"
										id="podcast_description"><?= @$podcast_description ?></textarea>
								</div>
								<div class="form-group">
									<label>Singer <span style="color:red;">*</span></label>
									<input class="form-control" type="text" placeholder="Example: Singer Name"
										name="podcast_singer_name" id="podcast_singer_name" value="<?= @$podcast_singer_name; ?>" required>
								</div>

								<div class="form-group">
									<label>Singer Image <span style="color:red;">*</span></label>
									<input type="file" name="singer_image" id="singer_image" class="form-control">
									<input type="hidden" name="old_simage" value="<?= @$podcast_singer_image ?>">
								</div>
								<?php if ($button == 'Update') {
									if (!empty($podcast_singer_image)) { ?>
										<div class="form-group">
											<img src="<?php echo base_url() ?>/uploads/podcast/singer_image/<?= @$podcast_singer_image ?>"
												style="width: 150px;">
										</div>
									<?php } else { ?>
										<div class="form-group">
											<img src="<?php echo base_url() ?>/uploads/no_image.png" style="width: 150px;">
										</div>
									<?php }
								} ?>


								<div class="form-group">
									<label>Cover Image <span style="color:red;">*</span></label>
									<input type="file" name="cover_image" id="cover_image" class="form-control">
									<input type="hidden" name="old_image" value="<?= @$podcast_cover_image ?>">
								</div>
								<?php if ($button == 'Update') {
									if (!empty($podcast_cover_image)) { ?>
										<div class="form-group">
											<img src="<?php echo base_url() ?>/uploads/podcast/cover_image/<?= @$podcast_cover_image ?>"
												style="width: 150px;">
										</div>
									<?php } else { ?>
										<div class="form-group">
											<img src="<?php echo base_url() ?>/uploads/no_image.png" style="width: 150px;">
										</div>
									<?php }
								} ?>
								<div class="form-group">
									<label>Podcast File <span style="color:red;">*</span></label>
									<input type="file" name="podcast_file" id="podcast_file" class="form-control">
									<input type="hidden" name="old_file" value="<?= @$podcast_file ?>">
								</div>
								<?php if ($button == 'Update') {
									if (!empty($podcast_file)) { ?>
										<div class="form-group">
											<!-- <img src="<?php echo base_url() ?>/uploads/podcast/podcast_file/<?= @$podcast_file ?>" style="width: 150px;"> -->
											<audio controls>
												<source
													src="<?php echo base_url() ?>/uploads/podcast/podcast_file/<?= @$podcast_file ?>">
											</audio>
										</div>
									<?php } else { ?>
										<div class="form-group">
											<img src="<?php echo base_url() ?>/uploads/no-audio.jpg" style="width: 150px;">
										</div>
									<?php }
								} ?>
								<!-- <div class="form-group">
								<label>Podcast Contents <span> </span></label>
								<div class="panel panel-default">
									  <div class="panel-body">
										<table class="table jobsites" id="purchaseTableclone1">
											<tr class="color">
												<th>Contents <span style="color:red;">*</span></th>
												<th><button type="button" class="btn btn-info" onclick="add_row()" >Add Content</button> </th>
											</tr>
											<tbody id="clonetable_feedback1">
												<?php if ($button == 'Create') { ?>
												<tr>
													<td style="width: 72%;"><input type="text" name="content_title[]" id="content_title1" class="form-control" placeholder="Content Title" required></td>
													<td><input type="file" name="podcast_file[]" id="podcast_file1" class="form-control" required></td>
													<td><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return remove(this)">X</a></td>
												</tr>
												<?php } else {
													if (!empty($pod_content)) {
														$rows = 1;
														foreach ($pod_content as $key) { ?>
												<tr>
													<td style="width: 72%;"><input type="text" name="content_title[]" id="content_title<?= $rows; ?>" class="form-control" placeholder="Content Title" value="<?= $key->content_title; ?>" required></td>
													<td>
														<audio controls><source src="<?php echo base_url() ?>/uploads/podcast/podcast_file/<?= $key->podcast_file; ?>"></audio>
														<input type="hidden" name="old_podcast_file[]" value="<?= $key->podcast_file; ?>">
													</td>
													<td><input type="file" name="podcast_file[]" id="podcast_file<?= $rows; ?>" class="form-control" value="<?= $key->podcast_file; ?>"></td>
													<td><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return remove(this)">X</a></td>
												</tr>
												<?php }
													}
												} ?>
											</tbody>
										</table>
									  </div>
								</div>
							  </div> -->
								<input type="hidden" name="id" value="<?php echo $id; ?>">
								<input type="hidden" name="button" value="<?php echo $button; ?>">
								<input type="hidden" name="user_id"
									value="<?php echo @$_SESSION['afrebay_admin']['id']; ?>">
								<div class="mt-4">
									<button class="btn btn-primary submit_button" type="submit">Submit</button>
									<!-- <button class="btn btn-primary submit_button" type="button" onclick="return add_update_podcast();">Submit</button> -->
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
	.showSubPrice {
		display: none;
	}

	.showProdKey {
		display: none;
	}

	.showPriceKey {
		display: none;
	}

	.showPaystackField {
		display: none;
	}
</style>
<script>
var url = '<?= admin_url('Manage_podcast/ajax_manage_page')?>';
var actioncolumn=3;
</script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script type="text/javascript" src="<?= base_url('dist/assets/custom_js/podcast.js')?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
	CKEDITOR.replace('podcast_description');
</script>
<script>
document.getElementById("myForm").addEventListener("submit", function(event) {
  // Show loader when form is submitted
//   document.getElementById("loader").style.display = "block";
$('#loader').show();
});
</script>
<script>



	function add_row() {
		var y = document.getElementById('clonetable_feedback1');
		var new_row = y.rows[0].cloneNode(true);
		var len = y.rows.length;
		new_number = Math.round(Math.exp(Math.random() * Math.log(10000000 - 0 + 1))) + 0;
		var inp3 = new_row.cells[0].getElementsByTagName('input')[0];
		inp3.value = '';
		inp3.id = 'service' + (len + 1);
		var submit_btn = $('#submit').val();
		y.appendChild(new_row);
	}

	function remove(row) {
		var y = document.getElementById('purchaseTableclone1');
		var len = y.rows.length;
		if (len > 2) {
			var i = (len - 1);
			document.getElementById('purchaseTableclone1').deleteRow(i);
		}
	}

	function only_number(event) {
		var x = event.which || event.keyCode;
		console.log(x);
		if ((x >= 48) && (x <= 57) || x == 8 | x == 9 || x == 13 || x == 46) {
			return;
		} else {
			event.preventDefault();
		}
	}

	function only_numbers(event) {
		var x = event.which || event.keyCode;
		console.log(x);
		if ((x >= 48) && (x <= 57) || x == 8 | x == 9 || x == 13) {
			return;
		} else {
			event.preventDefault();
		}
	}
</script>