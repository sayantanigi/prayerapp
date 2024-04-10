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
        <div class="card filter-card" id="filter_inputs" style="display: block">
            <div class="card-body pb-0">
                <form id="categorySearch" action="#" method="post">
                    <div class="row filter-row">
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Donation Date</label>
                                <div class="cal-icon2">
                                    <!--  datetimepicker -->
                                    <input class="form-control filter_search_data5" type="date" name="from_date" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Create Date</label>
                                <div class="cal-icon2">
                                    <input class="form-control filter_search_data7" type="date" name="to_date" value="">
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
                                        <th>Image</th>
                                        <th>Donation Name</th>
                                        <th>Description</th>
                                        <th>Amount</th>
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
<!--  Add mmodal -->
<div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Donation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Donation Title <span style="color:red;">*</span> <span id="d_title_err"></span></label>
                                <input class="form-control" type="text" name="d_title" id="d_title">
                            </div>
                            <div class="form-group">
                                <label>Donation Description <span style="color:red;">*</span> <span id="d_description_err"></span></label>
                                <textarea class="form-control" name="d_description" id="d_description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Donation Amount <span style="color:red;">*</span> <span id="d_amount_err"></span></label>
                                <input class="form-control" type="text" name="d_amount" id="d_amount">
                            </div>
                            <div class="form-group">
                                <label>Donation Image </label>
                                <input class="form-control" type="file" name="d_image" id="d_image">
                            </div>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo @$_SESSION['afrebay_admin']['id']; ?>">
                            <div class="mt-4">
                                <button class="btn btn-primary" type="button" onclick="return create_donation();">Add Donation</button>
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
                <h4 class="modal-title">Edit Donation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Donation Title <span style="color:red;">*</span><span id="edit_d_title_err"></span></label>
                                <input class="form-control" type="text" name="d_title" id="edit_d_title">
                            </div>
                            <div class="form-group">
                                <label>Donation Description <span style="color:red;">*</span> <span id="edit_d_description_err"></span></label>
                                <input class="form-control" type="text" name="d_description" id="edit_d_description">
                            </div>
                            <div class="form-group">
                                <label>Donation Amount <span style="color:red;">*</span> <span id="edit_d_amount_err"></span></label>
                                <input class="form-control" type="text" name="d_amount" id="edit_d_amount">
                            </div>
                            <div class="form-group">
                                <label>Donation Image </label>
                                <input class="form-control" type="file" name="d_image" id="edit_d_image">
                            </div>
                            <div id="show_img"> </div>
                            <input type="hidden" name="old_image" id="old_image">
                            <input type="hidden" name="id" id="id">
                            <div class="mt-4">
                                <button class="btn btn-primary" type="button" onclick="return update_donation();">Save Changes</button>
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
var url = '<?= admin_url('Manage_donation/ajax_manage_page')?>';
var actioncolumn=3;
</script>
<script type="text/javascript" src="<?= base_url('dist/assets/custom_js/donation.js')?>"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('d_description');
    CKEDITOR.replace('edit_d_description');
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
$(window).scroll(function(){
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
</script>