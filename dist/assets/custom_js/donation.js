function create_donation() {
    var admin_url = $('#admin_url').val();
    var user_id = $('#user_id').val();
    var d_title = $('#d_title').val();
    var d_description = CKEDITOR.instances['d_description'].getData();
    var d_amount = $('#d_amount').val();

    if(d_title == "") {
      	$("#d_title_err").fadeIn().html("Please Enter Donation Name").css("color","red");
        setTimeout(function(){$("#d_title_err").fadeOut("&nbsp;");},2000);
        $("#d_title").focus();
        return false;
    }
    if(d_description == "") {
        $("#d_description_err").fadeIn().html("Please Enter Donation Description").css("color","red");
        setTimeout(function(){$("#d_description_err").fadeOut("&nbsp;");},2000);
        $("#d_description").focus();
        return false;
    }
    if(d_amount == "") {
        $("#d_amount_err").fadeIn().html("Please Enter Donation Amount").css("color","red");
        setTimeout(function(){$("#d_amount_err").fadeOut("&nbsp;");},2000);
        $("#d_amount").focus();
        return false;
    }
    var form_data = new FormData();
    var d_image=$('#d_image')[0].files[0];
    form_data.append('d_image', d_image);
    form_data.append('user_id', user_id);
    form_data.append('d_title', d_title);
    form_data.append('d_description', d_description);
    form_data.append('d_amount', d_amount);
    $.ajax({
        type:"post",
        url:admin_url+"Manage_donation/create_action",
        cache:false,
        contentType: false,
        processData:false,
        async:false,
        data:form_data,
        success:function(returndata) {
            if(returndata==1) {
                location.reload();
            } else {
                $("#d_title_err").fadeIn().html("This donation already exits ").css("color","red");
                setTimeout(function(){$("#d_title_err").fadeOut("&nbsp;");},2000)
                $("#d_title").focus();
                return false;
            }
        }
    });
}

function getValue(id) {
    var admin_url = $("#admin_url").val();
    $.ajax({
        type:'post',
        cache:false,
        url:admin_url+'Manage_donation/get_value',
        data:{
            id:id,
        },
        success:function(returndata) {
            console.log(returndata);
            var obj=$.parseJSON(returndata);
            $("#edit_d_title").val(obj.d_title);
            CKEDITOR.instances.edit_d_description.setData(obj.d_description);
            $("#show_img").html(obj.d_image);
            $("#old_image").val(obj.old_image);
            $("#id").val(obj.id);
            $("#edit_d_amount").val(obj.d_amount);
        }
    })
}

function update_donation() {
    var admin_url = $("#admin_url").val();
    var old_image=$("#old_image").val();
    var d_title = $("#edit_d_title").val().trim();
    var d_description = CKEDITOR.instances['edit_d_description'].getData();
    var d_amount = $("#edit_d_amount").val().trim();
    var d_image = $('#edit_d_image')[0].files[0];
    var id = $("#id").val();

    if(d_title == "") {
        $("#edit_d_title_err").fadeIn().html("Please enter Prayer Name").css('color','red');
        setTimeout(function(){$("#edit_d_title_err").html("&nbsp;");},3000);
        $("#edit_d_title").focus();
        return false;
    }
    if(d_description == "") {
        $("#edit_d_description_err").fadeIn().html("Please enter description").css('color','red');
        setTimeout(function(){$("#edit_d_description_err").html("&nbsp;");},3000);
        $("#edit_d_description").focus();
        return false;
    }
    if(d_amount == "") {
        $("#edit_d_amount_err").fadeIn().html("Please Enter Donation Amount").css("color","red");
        setTimeout(function(){$("#edit_d_amount_err").fadeOut("&nbsp;");},2000);
        $("#edit_d_amount").focus();
        return false;
    }
    var form_data= new FormData();
    form_data.append('d_image',d_image);
    form_data.append('d_title',d_title);
    form_data.append('d_description',d_description);
    form_data.append('d_amount',d_amount);
    form_data.append('old_image',old_image);
    form_data.append('id',id);
    $.ajax({
        type:'post',
        cache:false,
        contentType: false,
        processData:false,
        url:admin_url+'Manage_donation/update_action',
        data:form_data,
        success:function(returndata) {
            if(returndata == 1 ) {
                location.reload();
            } else {
                $("#edit_d_title_err").fadeIn().html("This donation already exits").css('color','red');
                setTimeout(function(){$("#edit_d_title_err").html("&nbsp;");},3000);
                $("#edit_d_title").focus();
                return false;
            }
        }
    })
}

function view_data(id) {
    var admin_url = $("#admin_url").val();
    $.ajax({
        type:'post',
        cache:false,
        url:admin_url+'Manage_donation/view',
        data:{
          id:id,
        },
        success:function(returndata) {
            var obj=$.parseJSON(returndata);
            $("#show_description").html(obj.description);
        }
    })
}

function donationDelete(obj,cid) {
    var admin_url=$('#admin_url').val();
    $.confirm({
        title: 'Confirm!',
        content: confirmTextDelete,
        buttons: {
            confirm: function () {
                $(".id"+cid).fadeOut();
                var datastring="cid="+cid;
                $.ajax({
                    type:"POST",
                    url:admin_url+'Manage_donation/delete',
                    data:datastring,
                    cache:false,
                    success:function(returndata) {
                        if(returndata = 1){
                            location.reload();
                            table.draw();
                        } else if(returndata = 0){
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