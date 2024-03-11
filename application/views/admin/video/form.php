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
				<div class="card">
					<div class="card-body">
	            		<?php if($button=='Update') { ?>
	        			<form action="<?php echo admin_url('Manage_videos/update_action'); ?>" method="post" enctype="multipart/form-data" id="videoForm">
	            		<?php } else { ?>
	    				<form class="forms-sample" action="<?php echo admin_url('Manage_videos/create_action'); ?>" method="post" enctype="multipart/form-data">
	            		<?php } ?>
	            			<!-- <div class="form-group">
								<label>Category</label>
								<select class="form-control" name="videos_cat_id" id="videos_cat_id" required>
									<option value="">Select Category</option>
                                    <?php if(!empty($category)){
                                    foreach($category as $item){ ?>
                                    <option value="<?= $item->id?>" <?php if($item->id == @$videos_cat_id) {echo "selected";}?>><?= ucfirst($item->category_name)?></option>
                                    <?php } } ?>
								</select>
							</div> -->
							<div class="form-group">
								<label>Video Name</label>
								<input class="form-control" type="text" placeholder="Example: Video Name" name="videos_name" value="<?= @$videos_name;?>" required>
							</div>
							<div class="form-group">
								<label>Video Description</label>
								<textarea class="form-control" name="videos_description" id="videos_description"><?= @$videos_description ?></textarea>
							</div>
							<!-- <div class="form-group">
								<label>Video Type</label>
								<select class="form-control" name="videos_type" id="videos_type" required>
									<option value="">Choose an option</option>
									<option value="1" <?php if(@$videos_type == 1) { echo "selected";}?>>Video File</option>
									<option value="2" <?php if(@$videos_type == 2) { echo "selected";}?>>Video Link</option>
								</select>
							</div> -->
							<?php if(@$button=='Update') { 
								if(!empty(@$videos_file)) { ?>
							<div class="form-group">
								<video width="320" height="240" controls>
									<source src="<?php echo base_url()?>/uploads/videos/videos_file/<?= @$videos_file?>">
								</video>
							</div>
							<?php } else { ?>
							<div class="form-group">
								<!--<img src="<?php echo base_url()?>/uploads/no_image.png" style="width: 150px;">-->
							</div>
							<?php } } ?>

							<?php if(@$button=='Update') { 
								if(!empty(@$video_cover_image)) { ?>
							<div class="form-group">
								<video width="320" height="240" controls>
									<source src="<?php echo base_url()?>/uploads/videos/cover_image/<?= @$video_cover_image?>">
								</video>
							</div>
							<?php } else { ?>
							<div class="form-group">
								<!--<img src="<?php echo base_url()?>/uploads/no_image.png" style="width: 150px;">-->
							</div>
							<?php } } ?>

							<div class="form-group videoFile">
								<label>Video File</label>
								<input type="file" name="videos_file" id="videos_file" class="form-control">
							</div>
							<!--<div class="form-group videoLink">-->
							<!--	<label>Video Link</label>-->
							<!--	<input type="text" name="videos_link" id="videos_link" class="form-control" value="<?= @$videos_link?>">-->
							<!--</div>-->
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="button" value="<?php echo $button; ?>">
							<input type="hidden" name="user_id" value="<?php echo @$_SESSION['afrebay_admin']['id']; ?>">
							<input type="hidden" name="old_videos_file" value="<?php echo @$videos_file; ?>">
							<div class="mt-4">
								<button class="btn btn-primary" type="submit">Submit</button>
								<a href="<?= admin_url('manage_videos')?>" class="btn btn-link">Cancel</a>
							</div>
						</form>
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
/*.videoFile, .videoLink {display: none;}*/
</style>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
	CKEDITOR.replace('videos_description');
</script>
<script >
/*function add_row() {
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
}*/

// $(document).ready(function() {
// 	$("#videos_type").change(function(){
// 		if($(this).val() == 1) {
// 			$(".videoFile").show();
// 			$(".videoLink").hide();
// 		} else if($(this).val() == 2) {
// 			$(".videoFile").hide();
// 			$(".videoLink").show();
// 		} else {
// 			$(".videoFile").hide();
// 			$(".videoLink").hide();
// 		}
// 	})

// 	var type = $("#videos_type").val();
// 	if(type == 1) {
// 		$(".videoFile").show();
// 		$(".videoLink").hide();
// 	} else if (type == 2) {
// 		$(".videoFile").hide();
// 		$(".videoLink").show();
// 	} else {
// 		$(".videoFile").hide();
// 		$(".videoLink").hide();
// 	}
// })

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

// function submitForm(e) {
// 	if($("#videos_type").val() == '2') {
// 		alert();
// 		e.preventDefault();
//         return false;
// 	}
// }

$("#videoForm").submit(function(e) {
    if($("#videos_type").val() == '2') {
		var link = $('#videos_link').val();
		const domainName = link.match(/(?:http(?:s)?:\/\/)?(?:w{3}\.)?([^\.]+)/i)[1];
		alert(domainName);
		if(domainName == 'youtu' || domainName == 'youtube') {
			var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
			var match = link.match(regExp);
			if (match&&match[7].length == 11) {
				var b = match[7];
				alert(b);
			}
		} else if(domainName == 'facebook') {
			var regExp = /facebook\.com\/(?:photo.php\?v=|video\/embed\?video_id=|v\/?)(\d+)/gi;
			var match = link.match(regExp);
			alert(match[7]);
			return false;
		} else if(domainName == 'instagram') {

		} else if(domainName == 'vimeo') {

		} else {
			alert("Url incorrect");
			return false;
		}
	}
});
</script>
