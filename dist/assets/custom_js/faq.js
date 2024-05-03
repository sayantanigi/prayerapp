function create_faq() {
    var admin_url = $('#admin_url').val();
    var user_id = $('#user_id').val();
    var question = $('#question').val();
    var answer = CKEDITOR.instances['answer'].getData();

    if(question == "") {
      	$("#question_err").fadeIn().html("Please Enter Donation Name").css("color","red");
        setTimeout(function(){$("#question_err").fadeOut("&nbsp;");},2000);
        $("#question").focus();
        return false;
    }
    if(answer == "") {
        $("#answer_err").fadeIn().html("Please Enter Donation Description").css("color","red");
        setTimeout(function(){$("#answer_err").fadeOut("&nbsp;");},2000);
        $("#answer").focus();
        return false;
    }

    var form_data = new FormData();
    form_data.append('user_id', user_id);
    form_data.append('question', question);
    form_data.append('answer', answer);
    $.ajax({
        type:"post",
        url:admin_url+"Manage_faq/create_action",
        cache:false,
        contentType: false,
        processData:false,
        async:false,
        data:form_data,
        success:function(returndata) {
            if(returndata==1) {
                location.reload();
            } else {
                $("#question_err").fadeIn().html("This FAQ already exits ").css("color","red");
                setTimeout(function(){$("#question_err").fadeOut("&nbsp;");},2000)
                $("#question").focus();
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
        url:admin_url+'Manage_faq/get_value',
        data:{
            id:id,
        },
        success:function(returndata) {
            //console.log(returndata);
            var obj=$.parseJSON(returndata);
            $("#edit_question").val(obj.question);
            CKEDITOR.instances.edit_answer.setData(obj.answer);
            $("#id").val(obj.id);
        }
    })
}

function update_faq() {
    var admin_url = $("#admin_url").val();
    var question = $("#edit_question").val().trim();
    var answer = CKEDITOR.instances['edit_answer'].getData();
    var id = $("#id").val();

    if(question == "") {
        $("#edit_question_err").fadeIn().html("Please enter Prayer Name").css('color','red');
        setTimeout(function(){$("#edit_question_err").html("&nbsp;");},3000);
        $("#edit_question").focus();
        return false;
    }
    if(answer == "") {
        $("#edit_answer_err").fadeIn().html("Please enter description").css('color','red');
        setTimeout(function(){$("#edit_answer_err").html("&nbsp;");},3000);
        $("#edit_answer").focus();
        return false;
    }
    var form_data= new FormData();
    form_data.append('question',question);
    form_data.append('answer',answer);
    form_data.append('id',id);
    $.ajax({
        type:'post',
        cache:false,
        contentType: false,
        processData:false,
        url:admin_url+'Manage_faq/update_action',
        data:form_data,
        success:function(returndata) {
            if(returndata == 1 ) {
                location.reload();
            } else {
                $("#edit_question_err").fadeIn().html("This FAQ already exits").css('color','red');
                setTimeout(function(){$("#edit_question_err").html("&nbsp;");},3000);
                $("#edit_question").focus();
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
        url:admin_url+'Manage_faq/view',
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
                    url:admin_url+'Manage_faq/delete',
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