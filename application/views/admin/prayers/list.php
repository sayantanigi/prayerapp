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
                                <label>Prayer Date</label>
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
                                        <th>Prayer Name</th>
                                        <th>Sub Heading</th>
                                        <th>Description</th>
                                        <th>Date</th>
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
                <h4 class="modal-title">Add Prayer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Prayer Name <span style="color:red;">*</span> <span id="prayer_name_err"></span></label>
                                <input class="form-control" type="text" name="prayer_name" id="prayer_name">
                            </div>
                            <div class="form-group">
                                <label>Prayer Sub Heading<span style="color:red;">*</span> <span id="prayer_subheading_err"></span></label>
                                <input class="form-control" type="text" name="prayer_subheading" id="prayer_subheading">
                            </div>
                            <div class="form-group">
                                <label>Prayer Description <span style="color:red;">*</span> <span id="prayer_description_err"></span></label>
                                <textarea class="form-control" name="prayer_description" id="prayer_description"></textarea>
                            </div>  
                            <div class="form-group">
                                <label>Prayer Location <span style="color:red;">*</span> <span id="prayer_location_err"></span></label>
                                <input class="form-control" type="text" name="prayer_location" id="prayer_location">
                            </div>                          
                            <div class="form-group">
                                <label>Prayer Date and Time <span style="color:red;">*</span> <span id="prayer_datetime_err"></span></label>
                                <input class="form-control" type="datetime-local" name="prayer_datetime" id="prayer_datetime">
                            </div>
                            <div class="form-group">
                                <label>Prayer Image</label>
                                <input class="form-control" type="file" name="prayer_image" id="prayer_image">
                            </div>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo @$_SESSION['afrebay_admin']['id']; ?>">
                            <div class="mt-4">
                                <button class="btn btn-primary" type="button" onclick="return create_event();">Add Prayer</button>
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
                <h4 class="modal-title">Edit Prayer</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Prayer Title <span style="color:red;">*</span><span id="edit_prayer_name_err"></span></label>
                                <input class="form-control" type="text" name="prayer_name" id="edit_prayer_name">
                            </div>
                            <div class="form-group">
                                <label>Prayer Sub Heading<span style="color:red;">*</span> <span id="edit_prayer_subheading_err"></span></label>
                                <input class="form-control" type="text" name="prayer_subheading" id="edit_prayer_subheading">
                            </div>
                            <div class="form-group">
                                <label>Prayer Description <span style="color:red;">*</span> <span id="edit_prayer_description_err"></span></label>
                                <input class="form-control" type="text" name="prayer_description" id="edit_prayer_description">
                            </div>
                            <div class="form-group">
                                <label>Prayer Location <span style="color:red;">*</span> <span id="edit_prayer_location_err"></span></label>
                                <input class="form-control" type="text" name="prayer_location" id="edit_prayer_location">
                            </div>
                            <div class="form-group">
                                <label>Prayer Date and Time <span style="color:red;">*</span> <span id="edit_prayer_datetime_err"></span></label>
                                <input class="form-control" type="datetime-local" name="prayer_datetime" id="edit_prayer_datetime" value="">
                            </div>
                            <div class="form-group">
                                <label>Prayer Image</label>
                                <input class="form-control" type="file" name="prayer_image" id="edit_prayer_image">
                            </div>
                            <div id="show_img"> </div>
                            <input type="hidden" name="old_image" id="old_image">
                            <input type="hidden" name="id" id="id">
                            <div class="mt-4">
                                <button class="btn btn-primary" type="button" onclick="return update_event();">Save Changes</button>
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
var url = '<?= admin_url('Manage_prayers/ajax_manage_page')?>';
var actioncolumn=3;
</script>
<script type="text/javascript" src="<?= base_url('dist/assets/custom_js/prayers.js')?>"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('prayer_description');
    CKEDITOR.replace('edit_prayer_description');
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

$(document).ready(function(){
    $('#event_duration').keypress(validateNumber);
    $('#edit_event_duration').keypress(validateNumber);
});

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    console.log(key);
    if (event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 58) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
        return true;
    }
};

</script>
