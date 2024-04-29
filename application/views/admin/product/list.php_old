<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title"><?= $heading;?></h3>
                </div>
                <div class="col-auto text-right">
                    <a class="btn btn-white filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a>
                    <a href="#" class="btn btn-primary add-button ml-3" data-toggle="modal" data-target="#createModal">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <div id="loader" style="display:none;">
					<img src="<?= base_url() ?>uploads/loading.gif" alt="Loading...">
					<p>Please wait...</p>
				</div>
        <div class="card filter-card" id="filter_inputs" style="display: block">
            <div class="card-body pb-0">
                <form id="categorySearch" action="#" method="post">
                    <div class="row filter-row">
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control select filter_search_data6" name="">
                                    <option value="">Select Category</option>
                                    <?php
                                    if(!empty($get_category)){
                                        foreach($get_category as $item){ ?>
                                            <option value="<?= $item->id?>"><?= ucfirst($item->category_name)?></option>
                                    <?php } } ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label>Created Date</label>
                                    <div class="cal-icon2">
                                        <input class="form-control  filter_search_data5" type="date" name="from_date" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <a class="btn btn-primary btn-block" id="refreshForm" href="javascript:void(0)" style="line-height: 35px;">Refresh</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <table id="table" class="table table-hover table-center mb-0 example_datatable" >
                                    <thead class="sticky ">
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Product Description</th>
                                            <th>Category Name</th>
                                            <th>MRP</th>
                                            <th>Discount (%)</th>
                                            <th>Final Price</th>
                                            <th>Created Date</th>
                                            <th>Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Add mmodal -->
<div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Product Category<span style="color:red;">*</span> <span id="category_id_err"></span></label>
                                <select class="form-control select" name="category_id" id="category_id">
                                    <option value="">Select Category</option>
                                    <?php
                                    if(!empty($get_category)){
                                        foreach($get_category as $item){ ?>
                                            <option value="<?= $item->id?>"><?= ucfirst($item->category_name)?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product Name <span style="color:red;">*</span> <span id="pro_name_err"></span></label>
                                <input class="form-control" type="text" name="pro_name" id="pro_name">
                            </div>
                            <div class="form-group">
                                <label>Product Description<span style="color:red;">*</span> <span id="pro_desc_err"></span></label>
                                <input class="form-control" type="text" name="pro_desc" id="pro_desc">
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4" style="padding: 0px 10px 10px 0px; float: left;">
                                    <label>MRP<span style="color:red;">*</span> <span id="pro_mrp_err"></span></label>
                                    <input class="form-control" type="text" name="pro_mrp" id="pro_mrp">
                                </div>
                                <div class="col-sm-4" style="padding: 0px 10px 10px 0px; float: left;">
                                    <label>Discount (%)<span style="color:red;">*</span> <span id="pro_discount_err"></span></label>
                                    <input class="form-control" type="text" name="pro_discount" id="pro_discount">
                                </div>
                                <div class="col-sm-4" style="padding: 0 0 10px 0; float: left;">
                                    <label>Final Price<span style="color:red;">*</span> <span id="final_price_err"></span></label>
                                    <input class="form-control" type="text" name="final_price" id="final_price" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Product Image</label>
                                <input class="form-control" type="file" name="pro_image[]" id="pro_image" multiple>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary" type="button" onclick="return create_product();">Add Product</button>
                                <a href="#" class="btn btn-link" data-dismiss="modal">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  end add modal -->
<!--  edit mmodal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="#" id="myForm" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Product Category<span style="color:red;">*</span> <span id="edit_category_id_err"></span></label>
                                <select class="form-control select1" name="category_id" id="edit_category_id">
                                    <option value="">Select Category</option>
                                    <?php
                                    if(!empty($get_category)){
                                        foreach($get_category as $item){ ?>
                                            <option value="<?= $item->id?>"><?= ucfirst($item->category_name)?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product Name <span style="color:red;">*</span> <span id="edit_pro_name_err"></span></label>
                                <input class="form-control" type="text" name="pro_name" id="edit_pro_name">
                            </div>
                            <div class="form-group">
                                <label>Product Description<span style="color:red;">*</span> <span id="edit_pro_desc_err"></span></label>
                                <input class="form-control" type="text" name="pro_desc" id="edit_pro_desc">
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4" style="padding: 0px 10px 10px 0px; float: left;">
                                    <label>MRP<span style="color:red;">*</span> <span id="edit_pro_mrp_err"></span></label>
                                    <input class="form-control" type="text" name="pro_mrp" id="edit_pro_mrp">
                                </div>
                                <div class="col-sm-4" style="padding: 0px 10px 10px 0px; float: left;">
                                    <label>Discount (%)<span style="color:red;">*</span> <span id="edit_pro_discount_err"></span></label>
                                    <input class="form-control" type="text" name="pro_discount" id="edit_pro_discount">
                                </div>
                                <div class="col-sm-4" style="padding: 0 0 10px 0; float: left;">
                                    <label>Final Price<span style="color:red;">*</span> <span id="edit_final_price_err"></span></label>
                                    <input class="form-control" type="text" name="final_price" id="edit_final_price" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Product Image</label>
                                <input class="form-control" type="file" name="pro_image" id="edit_pro_image">
                            </div>
                            <div id="show_img"> </div>
                            <input type="hidden" name="old_image" id="old_image">
                            <input type="hidden" name="id" id="id">
                            <div class="mt-4">
                                <button class="btn btn-primary" type="button" onclick="return update_product();">Save Changes</button>
                                <a href="#" class="btn btn-link" data-dismiss="modal">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  end edit modal -->
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


// $("#myForm").on("click", function(event) {
//       // Show loader when form is clicked
//       alert(2);
//       $("#loader").show();
//     });



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
</script>
