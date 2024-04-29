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
                    <a href="<?= admin_url('manage_videos/create')?>" class="btn btn-primary add-button">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card filter-card" id="filter_inputs" style="display: none;">
            <div class="card-body pb-0">
                <form id="categorySearch" action="#" method="post">
                    <div class="row filter-row">
                        <div class="col-sm-6 col-md-5 d-none">
                            <div class="form-group">
                                <label></label>
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
                        <!-- <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Event Date</label>
                                <div class="cal-icon2">
                                    <input class="form-control  filter_search_data5" type="date" name="from_date" value="">
                                </div>
                            </div>
                        </div> -->
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Create Date</label>
                                <div class="cal-icon2">
                                    <input class="form-control  filter_search_data7" type="date" name="to_date" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2">
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
                                        <th>Cover Image</th>
                                        <!-- <th>Category</th> -->
                                        <th>Videos Title</th>
                                        <th>Videos Description</th>
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
<script>
var url = '<?= admin_url('Manage_videos/ajax_manage_page')?>';
var actioncolumn=3;
</script>
<script type="text/javascript" src="<?= base_url('dist/assets/custom_js/videos.js')?>"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('podcast_desc');
    CKEDITOR.replace('edit_podcast_desc');
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

$('#refreshForm').click(function(){
    $('#categorySearch').trigger("reset");
    $('.filter_search_data6').val('').trigger('change');
})
</script>
