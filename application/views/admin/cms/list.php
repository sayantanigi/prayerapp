<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title"><?= $heading; ?></h3>
                </div>
                <div class="col-auto text-right"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <table id="table" class="table table-hover table-center mb-0 example_datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add CMS</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Title <span style="color:red;">*</span> <span id="title_err"></span></label>
                                <input class="form-control" type="text" name="title" id="title">
                            </div>
                            <div class="form-group">
                                <label>Description <span style="color:red;">*</span> <span id="description_err"></span></label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-primary" type="button" onclick="return create_cms();">Submit</button>
                                <a href="#" class="btn btn-link" data-dismiss="modal">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit cms</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">

                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Title <span style="color:red;">*</span> <span id="edit_title_err"></span></label>
                                <input class="form-control" type="text" name="title" id="edit_title">
                            </div>
                            <div class="form-group">
                                <label>Description <span style="color:red;">*</span> <span id="edit_description_err"></span></label>
                                <textarea class="form-control" name="description1" id="edit_description"></textarea>
                            </div>

                            <input type="hidden" name="id" id="id">
                            <div class="mt-4">
                                <button class="btn btn-primary" type="button" onclick="return update_cms();">Save Changes</button>
                                <a href="#" class="btn btn-link" data-dismiss="modal">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="viewModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View cms</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div id="show_description"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    var url = '<?= admin_url('Manage_cms/ajax_manage_page') ?>';
    var actioncolumn = 3;
</script>

<script type="text/javascript" src="<?= base_url('dist/assets/custom_js/cms.js') ?>"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
//CKEDITOR.replace('description');
CKEDITOR.replace('description', {
    filebrowserUploadUrl: "<?php echo base_url()?>home/ck_upload",
    filebrowserUploadMethod: "form",
    removePlugins: 'easyimage',
});
//CKEDITOR.replace('description1');
CKEDITOR.replace('description1', {
    filebrowserUploadUrl: "<?php echo base_url()?>admin/Manage_cms/ck_upload",
    filebrowserUploadMethod: "form",
    removePlugins: 'easyimage',
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(window).scroll(function () {
        var filter_inputs = $('#filter_inputs');
        var table_wrapper = $('#table_wrapper .row:nth-child(1)');
        var table_header = $('#table thead');
        scroll = $(window).scrollTop();
        if (scroll >= 100) {
            table_wrapper.addClass('sticky_thead');
            table_header.addClass('sticky_thead1');
        } else {
            table_wrapper.removeClass('sticky_thead');
            table_header.removeClass('sticky_thead1');
        }
    });

    $('#refreshForm').click(function () {
        $('#categorySearch').trigger("reset");
        $('.filter_search_data6').val('').trigger('change');
    })
</script>
<style>
    .sticky_thead1 {
        position: sticky;
        top: 96px;
        background: #fff;
        z-index: 100;
    }
</style>