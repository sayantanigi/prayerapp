function portfolioDelete(obj, cid) {
    var admin_url = $('#admin_url').val();
    $.confirm({
        title: 'Confirm!',
        content: confirmTextDelete,
        buttons: {
            confirm: function () {
                $(".id" + cid).fadeOut();
                var datastring = "cid=" + cid;
                $.ajax({
                    type: "POST",
                    url: admin_url + 'Manage_portfolio/delete',
                    data: datastring,
                    cache: false,
                    success: function (returndata) {
                        if (returndata = 1) {
                            location.reload();
                            table.draw();
                        } else if (returndata = 0) {
                            location.reload();
                            table.draw();
                        }
                    }
                });
            },
            cancel: function () {
                location.reload();
            },
        }
    });
}