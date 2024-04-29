<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css"> -->
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
						<form id="myForm" action="<?php echo admin_url('product/update_action'); ?>" method="post" enctype="multipart/form-data">
						<?php } else { ?>
						<form id="myForm" class="forms-sample" action="<?php echo admin_url('product/create_action'); ?>" method="post" enctype="multipart/form-data">
						<?php } ?>
							<div class="form-group">
								<label>Product Category<span style="color:red;">*</span> <span id="pro_cat_id_err"></span></label>
								<select class="form-control select" name="pro_cat_id" id="pro_cat_id">
									<option value="">Select Category</option>
									<?php
									if(!empty($category)){
										foreach($category as $item){ ?>
											<option value="<?= $item->id?>" <?php if ($item->id == @$pro_cat_id) { echo "selected"; } ?>><?= ucfirst($item->category_name)?></option>
									<?php } } ?>
								</select>
							</div>
							<div class="form-group">
								<label>Product Name <span style="color:red;">*</span> <span id="pro_name_err"></span></label>
								<input class="form-control" type="text" name="pro_name" id="pro_name" value="<?= @$pro_name?>">
							</div>
							<div class="form-group">
								<label>Product Description<span style="color:red;">*</span> <span id="pro_desc_err"></span></label>
								<textarea class="form-control" name="pro_desc" id="pro_desc"><?= @$pro_desc ?></textarea>
							</div>
							<div class="form-group">
								<div class="col-sm-4" style="padding: 0px 10px 10px 0px; float: left;">
									<label>MRP<span style="color:red;">*</span> <span id="pro_mrp_err"></span></label>
									<input class="form-control" type="text" name="pro_mrp" id="pro_mrp" value="<?= @$mrp?>">
								</div>
								<div class="col-sm-4" style="padding: 0px 10px 10px 0px; float: left;">
									<label>Discount (%)<span style="color:red;">*</span> <span id="pro_discount_err"></span></label>
									<input class="form-control" type="text" name="pro_discount" id="pro_discount" value="<?= @$discount?>">
								</div>
								<div class="col-sm-4" style="padding: 0 0 10px 0; float: left;">
									<label>Final Price<span style="color:red;">*</span> <span id="final_price_err"></span></label>
									<input class="form-control" type="text" name="final_price" id="final_price" readonly value="<?= @$final_price?>">
								</div>
							</div>
							<div class="form-group">
								<label>Product Image</label>
								<input class="form-control" type="file" name="pro_image[]" id="pro_image" multiple>
							</div>
							<?php
							$getProdImage = $this->db->query("SELECT * FROM product_image WHERE prod_id = '".$id."'")->result_array();
							if(!empty($getProdImage)){
								foreach ($getProdImage as $img) { ?>
								<img class="img-circle_<?php echo $img['id']?>" src="<?= base_url()?>/uploads/product/<?= $img['pro_image']?>" style="width: 100px; display: inline-block; height: 70px;">
								<img class="img-circle-close_<?php echo $img['id']?> img-responsive" src="<?php echo base_url('uploads/close-icon.png'); ?>" onclick="deleteProdImg(<?php echo $img['id']?>);" style="width: 15px;height: 15px;position: relative;top: -35px;right: 10px;cursor: pointer;"/>
								<input type="hidden" name="old_image[]" value="<?= $img['pro_image'] ?>">
							<?php }
							}
							?>
							<input type="hidden" name="id" value="<?php echo @$id; ?>">
							<input type="hidden" name="button" value="<?php echo $button; ?>">
							<input type="hidden" name="user_id" value="<?php echo @$_SESSION['afrebay_admin']['id']; ?>">
							<div class="mt-4">
								<button class="btn btn-primary submit_button" type="submit">Submit</button>
								<a href="<?= admin_url('Product') ?>" class="btn btn-link">Cancel</a>
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
var url = '<?= admin_url('Product/ajax_manage_page')?>';
var actioncolumn=3;
</script>
<script type="text/javascript" src="<?= base_url('dist/assets/custom_js/product.js')?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('pro_desc');
    CKEDITOR.replace('edit_pro_desc');
</script>
<script>
document.getElementById("myForm").addEventListener("submit", function(event) {
	$('#loader').show();
});
$(window).scroll(function() {
    var filter_inputs = $('#filter_inputs');
    var table_wrapper = $('#table_wrapper .row:nth-child(1)');
    var table_header = $('#table thead');
    scroll = $(window).scrollTop();
    if (scroll >= 100) {
        filter_inputs.addClass('sticky_thead');
        table_wrapper.addClass('sticky_thead1');
        table_header.addClass('sticky_thead2');
    } else {
        filter_inputs.removeClass('sticky_thead');
        table_wrapper.removeClass('sticky_thead1');
        table_header.removeClass('sticky_thead2');
    }
});

$('#refreshForm').click(function(){
    $('#categorySearch').trigger("reset");
    $('.filter_search_data6').val('').trigger('change');
})

$('#pro_discount').keyup(function() {
    var pro_mrp = $('#pro_mrp').val();
    var pro_discount = $('#pro_discount').val();
    var discountPrice = pro_mrp * (pro_discount/100);
    var finalPrice = pro_mrp - discountPrice;
    $('#final_price').val(finalPrice.toFixed(2))
})
$('#pro_mrp').keyup(function() {
    var pro_mrp = $('#pro_mrp').val();
    var pro_discount = $('#pro_discount').val();
    var discountPrice = pro_mrp * (pro_discount/100);
    var finalPrice = pro_mrp - discountPrice;
    $('#final_price').val(finalPrice.toFixed(2))
})

$('#edit_pro_discount').keyup(function() {
    var pro_mrp = $('#edit_pro_mrp').val();
    var pro_discount = $('#edit_pro_discount').val();
    var discountPrice = pro_mrp * (pro_discount/100);
    var finalPrice = pro_mrp - discountPrice;
    $('#edit_final_price').val(finalPrice.toFixed(2))
})
$('#edit_pro_mrp').keyup(function() {
    var pro_mrp = $('#edit_pro_mrp').val();
    var pro_discount = $('#edit_pro_discount').val();
    var discountPrice = pro_mrp * (pro_discount/100);
    var finalPrice = pro_mrp - discountPrice;
    $('#edit_final_price').val(finalPrice.toFixed(2))
})
function deleteProdImg(pi_id) {
    var id = pi_id;
	$('.img-circle_'+id).css('display','none');
    $('.img-circle-close_'+id).css('display','none');
    $.ajax({
        url:"<?php echo base_url()?>admin/product/delete_product_image",
        method:"POST",
        data:{id: id},
        beforeSend : function(){},
        success:function(data) {}
    })
}
</script>
