function add_update_podcast(){
    // alert(11);
     $('.submit_button').attr('disabled', true);
    $('#loader').show();
     var admin_url = $('#admin_url').val();
     // var old_image=$("#old_image").val();
    var podcast_name = $("#podcast_name").val().trim();
    var podcast_description = $("#podcast_description").val().trim();
    var podcast_singer_name = $("#podcast_singer_name").val().trim();




    var singer_image = $('#singer_image')[0].files[0];
    var cover_image = $('#cover_image')[0].files[0];


    var podcast_file = $('#podcast_file')[0].files[0];
    var id = $("#id").val();   


    if(podcast_name == "") {
        $("#podcast_name_err").fadeIn().html("Please enter Prayer Heading").css('color','red');
        setTimeout(function(){$("#podcast_name_err").html("&nbsp;");},3000);
        $("#podcast_name").focus();
        return false;
    }

    

    var form_data= new FormData();
    form_data.append('podcast_name',podcast_name); 
    form_data.append('podcast_description',podcast_description); 
    form_data.append('podcast_singer_name',podcast_singer_name); 
    form_data.append('cover_image',cover_image); 
    form_data.append('singer_image',singer_image); 
    form_data.append('podcast_file',podcast_file); 
    // form_data.append('old_image',old_image);
    form_data.append('id',id);
    $.ajax({
        type:'post',
        cache:false,
        contentType: false,   
        processData:false,
        url:admin_url+'Manage_podcast/create_action',
        data:form_data,
        success:function(returndata) {
            if(returndata == 1 ) {
                // location.reload();
                location.href = admin_url+ 'Manage_podcast/manage_podcast';

            } else {
                // $("#edit_prayer_name_err").fadeIn().html("This title already exits").css('color','red');
                // setTimeout(function(){$("#edit_prayer_name_err").html("&nbsp;");},3000);
                // $("#edit_prayer_name").focus();
                return false;
            }
        },
        complete: function () {
            $('#loader').hide();
            // Re-enable submit button after AJAX request is complete
            // $(".dataTables_processing card").show();
                $('.submit_button').attr('disabled', false);
        }
    })
}



function create_event() {
    $('.submit_button').attr('disabled', true);
    $('#loader').show();
    var admin_url = $('#admin_url').val();
    var user_id = $('#user_id').val();
    var event_title = $('#event_title').val();
    var event_desc = CKEDITOR.instances['event_desc'].getData();
    var event_location = $('#event_location').val();
    var event_datetime = $('#event_datetime').val();


    if(event_title == "") {
      	$("#event_title_err").fadeIn().html("Please Enter Event Title").css("color","red");
        setTimeout(function(){$("#event_title_err").fadeOut("&nbsp;");},2000);
        $("#event_title").focus();
        return false;
    }

    if(event_desc == "") {
        $("#event_desc_err").fadeIn().html("Please Enter title").css("color","red");
        setTimeout(function(){$("#event_desc_err").fadeOut("&nbsp;");},2000);
        $("#event_desc").focus();
        return false;
    }

    if(event_location == "") {
        $("#event_location_err").fadeIn().html("Please Enter title").css("color","red");
        setTimeout(function(){$("#event_location_err").fadeOut("&nbsp;");},2000);
        $("#event_location").focus();
        return false;
    }

    if(event_datetime == "") {
        $("#event_datetime_err").fadeIn().html("Please Enter title").css("color","red");
        setTimeout(function(){$("#event_datetime_err").fadeOut("&nbsp;");},2000);
        $("#event_datetime").focus();
        return false;
    }

    var form_data= new FormData();
    var event_image=$('#event_image')[0].files[0];
    form_data.append('event_image', event_image);
    form_data.append('user_id', user_id);
    form_data.append('event_title', event_title);
    form_data.append('event_desc', event_desc);
    form_data.append('event_location', event_location);
    form_data.append('event_datetime', event_datetime);
    $.ajax({
        type:"post",
        url:admin_url+"Manage_podcast/create_action",
        cache:false,
        contentType: false,   
        processData:false,
        async:false,
        data:form_data,
        success:function(returndata) {
            if(returndata==1) {
                location.reload();
            } else {
                $("#event_title_err").fadeIn().html("This events title already exits ").css("color","red");
                setTimeout(function(){$("#event_title_err").fadeOut("&nbsp;");},2000)
                $("#event_title").focus();
                return false;
            }
        },
        complete: function () {
            $('#loader').hide();
            // Re-enable submit button after AJAX request is complete
            // $(".dataTables_processing card").show();
                $('.submit_button').attr('disabled', false);
        }
    });
}

function getValue(id) {      
    var admin_url = $("#admin_url").val();
    $.ajax({
        type:'post',
        cache:false,
        url:admin_url+'Manage_podcast/get_value',
        data:{
            id:id,
        },
        success:function(returndata) {
            console.log(returndata);
            var obj=$.parseJSON(returndata);
            $("#edit_event_title").val(obj.event_title);
            $("#edit_event_datetime").val(obj.event_datetime);
            $("#edit_event_location").val(obj.event_location);
            CKEDITOR.instances.edit_event_desc.setData(obj.event_desc);
            $("#show_img").html(obj.image);
            $("#old_image").val(obj.old_image);
            $("#id").val(obj.id);
            
        }
    })
}

function update_event() {
    var admin_url = $("#admin_url").val();
    var old_image=$("#old_image").val();
    var event_title = $("#edit_event_title").val().trim();
    var event_datetime = $("#edit_event_datetime").val().trim();
    var event_location = $("#edit_event_location").val().trim();
    var event_desc = CKEDITOR.instances['edit_event_desc'].getData();
    var event_image = $('#edit_event_image')[0].files[0];
    var id = $("#id").val();   

    if(event_title == "") {
        $("#edit_event_title_err").fadeIn().html("Please enter title").css('color','red');
        setTimeout(function(){$("#edit_event_title_err").html("&nbsp;");},3000);
        $("#edit_event_title").focus();
        return false;
    }

    if(event_datetime == "") {
        $("#edit_event_datetime_err").fadeIn().html("Please enter title").css('color','red');
        setTimeout(function(){$("#edit_event_datetime_err").html("&nbsp;");},3000);
        $("#edit_event_datetime").focus();
        return false;
    }

    if(event_location == "") {
        $("#edit_event_location_err").fadeIn().html("Please enter title").css('color','red');
        setTimeout(function(){$("#edit_event_location_err").html("&nbsp;");},3000);
        $("#edit_event_location").focus();
        return false;
    }

    if(event_desc == "") {
        $("#edit_event_desc_err").fadeIn().html("Please enter title").css('color','red');
        setTimeout(function(){$("#edit_event_desc_err").html("&nbsp;");},3000);
        $("#edit_event_desc").focus();
        return false;
    }

    var form_data= new FormData();
    form_data.append('event_image',event_image);
    form_data.append('event_title',event_title); 
    form_data.append('event_datetime',event_datetime);
    form_data.append('event_location',event_location);
    form_data.append('event_desc',event_desc);
    form_data.append('old_image',old_image);
    form_data.append('id',id);
    $.ajax({
        type:'post',
        cache:false,
        contentType: false,   
        processData:false,
        url:admin_url+'Manage_podcast/update_action',
        data:form_data,
        success:function(returndata) {
            if(returndata == 1 ) {
                location.reload();
            } else {
                $("#edit_event_title_err").fadeIn().html("This title already exits").css('color','red');
                setTimeout(function(){$("#edit_event_title_err").html("&nbsp;");},3000);
                $("#edit_event_title").focus();
                return false;
            }
        }
    })
}

function podcastDetails(id) {      
    var admin_url = $("#admin_url").val();
    $.ajax({
        type:'post',
        cache:false,
        url:admin_url+'Manage_podcast/view',
        data:{
          id:id,
        },
        success:function(returndata) {
            var obj=$.parseJSON(returndata);
            $("#show_description").html(obj.description);
        }
    })
}

function podcastDelete(obj,cid) {
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
                    url:admin_url+'Manage_podcast/delete',
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