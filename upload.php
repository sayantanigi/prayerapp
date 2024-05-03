<?php
if(isset($_FILES['upload']['name'])) {
	$file = $_FILES['upload']['name'];
	$filetmp = $_FILES['upload']['tmp_name'];
	//echo 'sayantan'.$file; die;
    //echo dirname(__FILE__); die;
	move_uploaded_file($filetmp,'uploads/ckeditor/'.$file);
    $function_number=$_GET['CKEditorFuncNum'];
	$url=base_url().'uploads/ckeditor/'.$file;
	$message='';
	echo "<script>window.parent.CKEDITOR.tools.callFunction('".$function_number."','".$url."','".$message."');</script>";     
}
?>