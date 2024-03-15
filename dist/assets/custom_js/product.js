function create_product() {
	var admin_url = $('#admin_url').val();
    var category_id = $('#category_id').val();
	var pro_name = $('#pro_name').val();
    var pro_desc = CKEDITOR.instances['pro_desc'].getData();
    var pro_mrp = $('#pro_mrp').val();
    var pro_discount = $('#pro_discount').val();
    var final_price = $('#final_price').val();

    if(category_id == "") {
		$("#category_id_err").fadeIn().html("Please Select Category").css("color","red");
		setTimeout(function(){$("#category_id_err").fadeOut("&nbsp;");},2000)
		$("#category_id").focus();
		return false;
	}

	if(pro_name=="") {
		$("#pro_name_err").fadeIn().html("Please Enter Product Name").css("color","red");
		setTimeout(function(){$("#pro_name_err").fadeOut("&nbsp;");},2000)
		$("#pro_name").focus();
		return false;
	}

    if(pro_desc=="") {
		$("#pro_desc_err").fadeIn().html("Please Enter Description").css("color","red");
		setTimeout(function(){$("#pro_desc_err").fadeOut("&nbsp;");},2000)
		$("#pro_desc").focus();
		return false;
	}

    if(pro_mrp=="") {
		$("#pro_mrp_err").fadeIn().html("Please Enter Product MRP").css("color","red");
		setTimeout(function(){$("#pro_mrp_err").fadeOut("&nbsp;");},2000)
		$("#pro_mrp").focus();
		return false;
	}

    if(pro_discount=="") {
		$("#pro_discount_err").fadeIn().html("Please Enter Product Discount").css("color","red");
		setTimeout(function(){$("#pro_discount_err").fadeOut("&nbsp;");},2000)
		$("#pro_discount").focus();
		return false;
	}

    var form_data= new FormData();
	var fileInput = $('#pro_image')[0];
	if(fileInput.files.length > 0 ) {
		$.each(fileInput.files, function(k,file){
			form_data.append('pro_image[]', file);
		});
	}
	//console.log(pro_image);
	//form_data.append('pro_image',pro_image);
    form_data.append('pro_cat_id',category_id);
	form_data.append('pro_name',pro_name);
    form_data.append('pro_desc',pro_desc);
    form_data.append('pro_mrp',pro_mrp);
    form_data.append('pro_discount',pro_discount);
    form_data.append('final_price',final_price);
	$.ajax({
		type:"post",
		url:admin_url+"Product/create_action",
		cache:false,
		contentType: false,
		processData:false,
		async:false,
		data:form_data,
		success:function(returndata) {
			if(returndata==1) {
				location.reload();
			} else{
				$("#pro_name_err").fadeIn().html("This pro already exits ").css("color","red");
				setTimeout(function(){$("#pro_name_err").fadeOut("&nbsp;");},2000)
				$("#pro_name").focus();
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
		url:admin_url+'Product/get_value',
		data:{
			id:id,
		},
		success:function(returndata) {
			var obj=$.parseJSON(returndata);
            console.log(obj);
			//$("#edit_category_name").val(obj.category_name);
			$("#id").val(obj.id);
            $("#edit_category_id").val(obj.pro_cat_id).attr("selected", "selected");;
            $("#edit_pro_name").val(obj.pro_name);
            //$("#edit_pro_desc").val(obj.pro_desc);
            CKEDITOR.instances.edit_pro_desc.setData(obj.pro_desc);
            $("#edit_pro_mrp").val(obj.mrp);
            $("#edit_pro_discount").val(obj.discount);
            $("#edit_final_price").val(obj.final_price);
			$("#show_img").html(obj.image);
			$("#old_image").val(obj.old_image);
        }
	});
}

function update_product() {
	var admin_url=$('#admin_url').val();
	var pro_cat_id=$('#edit_category_id').val();
    var pro_name = $('#edit_pro_name').val();
    var pro_desc = CKEDITOR.instances['edit_pro_desc'].getData();
    var pro_mrp = $('#edit_pro_mrp').val();
    var pro_discount = $('#edit_pro_discount').val();
    var final_price = $('#edit_final_price').val();
	var old_image=$("#old_image").val();
	var id=$("#id").val();

	if(pro_cat_id=="") {
		$("#edit_category_id_err").fadeIn().html("Please Select Category").css("color","red");
		setTimeout(function(){$("#edit_category_id_err").fadeOut("&nbsp;");},2000)
		$("#edit_category_id").focus();
		return false;
	}

    if(pro_name=="") {
		$("#edit_pro_name_err").fadeIn().html("Please Enter Product Name").css("color","red");
		setTimeout(function(){$("#edit_pro_name_err").fadeOut("&nbsp;");},2000)
		$("#edit_pro_name").focus();
		return false;
	}

    if(pro_desc=="") {
		$("#edit_pro_desc_err").fadeIn().html("Please Enter Product Description").css("color","red");
		setTimeout(function(){$("#edit_pro_desc_err").fadeOut("&nbsp;");},2000)
		$("#edit_pro_desc").focus();
		return false;
	}

    if(pro_mrp=="") {
		$("#edit_pro_mrp_err").fadeIn().html("Please Enter Product MRP").css("color","red");
		setTimeout(function(){$("#edit_pro_mrp_err").fadeOut("&nbsp;");},2000)
		$("#edit_pro_mrp").focus();
		return false;
	}

    if(pro_discount=="") {
		$("#edit_pro_discount_err").fadeIn().html("Please Enter Product Discount").css("color","red");
		setTimeout(function(){$("#edit_pro_discount_err").fadeOut("&nbsp;");},2000)
		$("#edit_pro_discount").focus();
		return false;
	}

    var form_data= new FormData();
	var fileInput = $('#edit_pro_image')[0];
	if(fileInput.files.length > 0 ) {
		$.each(fileInput.files, function(k,file){
			form_data.append('edit_pro_image[]', file);
		});
	}
	//var pro_image=$('#edit_pro_image')[0].files[0];
	//form_data.append('pro_image',pro_image);
	form_data.append('pro_cat_id',pro_cat_id);
    form_data.append('pro_name',pro_name);
    form_data.append('pro_desc',pro_desc);
    form_data.append('pro_mrp',pro_mrp);
    form_data.append('pro_discount',pro_discount);
    form_data.append('final_price',final_price);
	form_data.append('old_image',old_image);
	form_data.append('id',id);
	$.ajax({
		type:"post",
		url:admin_url+"Product/update_action",
		cache:false,
		contentType: false,
		processData:false,
		async:false,
		data:form_data,
		success:function(returndata) {
			if(returndata==1) {
				location.reload();
			} else {
				$("#edit_pro_name_err").fadeIn().html("This Product Name already exists ").css("color","red");
				setTimeout(function(){$("#edit_pro_name_err").fadeOut("&nbsp;");},2000)
				$("#edit_pro_name").focus();
				return false;
			}
		}
	});
}

function product_Delete(obj,cid) {
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
					url:admin_url+'Product/delete',
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
