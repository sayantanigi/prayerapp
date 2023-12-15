function create_event() {
    var admin_url = $('#admin_url').val();
    var user_id = $('#user_id').val();
    var prayer_name = $('#prayer_name').val();
    var prayer_description= CKEDITOR.instances['prayer_description'].getData();
    var prayer_subheading = $('#prayer_subheading').val();
    var prayer_location = $('#prayer_location').val();
    var prayer_datetime = $('#prayer_datetime').val();

    if(prayer_name == "") {
      	$("#prayer_name_err").fadeIn().html("Please Enter Prayer Name").css("color","red");
        setTimeout(function(){$("#prayer_name_err").fadeOut("&nbsp;");},2000);
        $("#prayer_name").focus();
        return false;
    }

    if(prayer_subheading == "") {
        $("#prayer_subheading_err").fadeIn().html("Please Enter Prayer Sub Heading").css("color","red");
        setTimeout(function(){$("#prayer_subheading_err").fadeOut("&nbsp;");},2000);
        $("#prayer_subheading").focus();
        return false;
    }

    if(prayer_description == "") {
        $("#prayer_description_err").fadeIn().html("Please Enter Prayer Description").css("color","red");
        setTimeout(function(){$("#prayer_description_err").fadeOut("&nbsp;");},2000);
        $("#prayer_description").focus();
        return false;
    }

    if(prayer_location == "") {
        $("#prayer_location_err").fadeIn().html("Please Enter Prayer Location").css("color","red");
        setTimeout(function(){$("#prayer_location_err").fadeOut("&nbsp;");},2000);
        $("#prayer_location").focus();
        return false;
    }

    if(prayer_datetime == "") {
        $("#prayer_datetime_err").fadeIn().html("Please Enter Prayer Date Time").css("color","red");
        setTimeout(function(){$("#prayer_datetime_err").fadeOut("&nbsp;");},2000);
        $("#prayer_datetime").focus();
        return false;
    }

    var form_data= new FormData();
    var prayer_image=$('#prayer_image')[0].files[0];
    form_data.append('prayer_image', prayer_image);
    form_data.append('user_id', user_id);
    form_data.append('prayer_name', prayer_name);
    form_data.append('prayer_subheading', prayer_subheading);
    form_data.append('prayer_description', prayer_description);
    form_data.append('prayer_location', prayer_location);
    form_data.append('prayer_datetime', prayer_datetime);
    $.ajax({
        type:"post",
        url:admin_url+"Manage_prayers/create_action",
        cache:false,
        contentType: false,   
        processData:false,
        async:false,
        data:form_data,
        success:function(returndata) {
            if(returndata==1) {
                location.reload();
            } else {
                $("#prayer_name_err").fadeIn().html("This prayer already exits ").css("color","red");
                setTimeout(function(){$("#prayer_name_err").fadeOut("&nbsp;");},2000)
                $("#prayer_name").focus();
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
        url:admin_url+'Manage_prayers/get_value',
        data:{
            id:id,
        },
        success:function(returndata) {
            console.log(returndata);
            var obj=$.parseJSON(returndata);
            $("#edit_prayer_name").val(obj.prayer_name);
            $("#edit_prayer_subheading").val(obj.prayer_subheading);
            CKEDITOR.instances.edit_prayer_description.setData(obj.prayer_description);
            $("#edit_prayer_location").val(obj.prayer_location);
            $("#edit_prayer_datetime").val(obj.prayer_datetime);
            $("#show_img").html(obj.image);
            $("#old_image").val(obj.old_image);
            $("#id").val(obj.id);
            
        }
    })
}

function update_event() {
    var admin_url = $("#admin_url").val();
    var old_image=$("#old_image").val();
    var prayer_name = $("#edit_prayer_name").val().trim();
    var prayer_datetime = $("#edit_prayer_datetime").val();
    var prayer_description = CKEDITOR.instances['edit_prayer_description'].getData();
    var prayer_location = $("#edit_prayer_location").val();
    var prayer_subheading = $("#edit_prayer_subheading").val().trim();
    var prayer_image = $('#edit_prayer_image')[0].files[0];
    var id = $("#id").val();   

    if(prayer_name == "") {
        $("#edit_prayer_name_err").fadeIn().html("Please enter Prayer Name").css('color','red');
        setTimeout(function(){$("#edit_prayer_name_err").html("&nbsp;");},3000);
        $("#edit_prayer_name").focus();
        return false;
    }

    if(prayer_subheading == "") {
        $("#edit_prayer_subheading_err").fadeIn().html("Please enter title").css('color','red');
        setTimeout(function(){$("#edit_prayer_subheading_err").html("&nbsp;");},3000);
        $("#edit_prayer_subheading").focus();
        return false;
    }

    if(prayer_description == "") {
        $("#edit_prayer_description_err").fadeIn().html("Please enter description").css('color','red');
        setTimeout(function(){$("#edit_prayer_description_err").html("&nbsp;");},3000);
        $("#edit_prayer_description").focus();
        return false;
    }

    if(prayer_location == "") {
        $("#edit_prayer_location_err").fadeIn().html("Please enter location").css('color','red');
        setTimeout(function(){$("#edit_prayer_location_err").html("&nbsp;");},3000);
        $("#edit_prayer_location").focus();
        return false;
    }

    if(prayer_datetime == "") {
        $("#edit_prayer_datetime_err").fadeIn().html("Please enter Date Time").css('color','red');
        setTimeout(function(){$("#edit_prayer_datetime_err").html("&nbsp;");},3000);
        $("#edit_prayer_datetime").focus();
        return false;
    }

    var form_data= new FormData();
    form_data.append('prayer_image',prayer_image);
    form_data.append('prayer_name',prayer_name); 
    form_data.append('prayer_datetime',prayer_datetime);
    form_data.append('prayer_description',prayer_description);
    form_data.append('prayer_subheading',prayer_subheading);
    form_data.append('prayer_location',prayer_location);
    form_data.append('old_image',old_image);
    form_data.append('id',id);
    $.ajax({
        type:'post',
        cache:false,
        contentType: false,   
        processData:false,
        url:admin_url+'Manage_prayers/update_action',
        data:form_data,
        success:function(returndata) {
            if(returndata == 1 ) {
                location.reload();
            } else {
                $("#edit_prayer_name_err").fadeIn().html("This title already exits").css('color','red');
                setTimeout(function(){$("#edit_prayer_name_err").html("&nbsp;");},3000);
                $("#edit_prayer_name").focus();
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
        url:admin_url+'Manage_prayers/view',
        data:{
          id:id,
        },
        success:function(returndata) {
            var obj=$.parseJSON(returndata);
            $("#show_description").html(obj.description);
        }
    })
}

function eventDelete(obj,cid) {
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
                    url:admin_url+'Manage_prayers/delete',
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