<?php
$get_setting=$this->Crud_model->get_single('setting');
if(empty($_SESSION['afrebay_admin']['id'])) {
    redirect(admin_url());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>120Army | <?php if(!empty($title)){ echo ucfirst($title);} else{ echo "Dashboard";}?></title>
    <link rel="shortcut icon" href="<?=base_url(); ?>uploads/logo/<?= $get_setting->favicon?>">
    <link rel="stylesheet" href="<?=base_url(); ?>dist/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>dist/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>dist/assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>dist/assets/plugins/datatables/datatables.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>dist/assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>dist/assets/css/animate.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>dist/assets/css/admin.css">
    <link rel="stylesheet" href="<?= base_url();?>dist/admin_assets/select2/select2.css">
</head>
<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="##" class="logo logo-small">
                    <img src="<?=base_url(); ?>uploads/logo/<?= $get_setting->logo?>" alt="Logo" width="30" height="30">
                </a>
            </div>
            <a href="javascript:void(0);" id="toggle_btn">
                <i class="fas fa-align-left"></i>
            </a>
            <a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
                <i class="fas fa-align-left"></i>
            </a>
            <ul class="nav user-menu">
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="<?=base_url(); ?>uploads/logo/<?= $get_setting->logo?>" width="40" alt="Admin">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?= admin_url('profile'); ?>">Change Password</a>
                        <a class="dropdown-item" href="<?= admin_url(); ?>login/logout" >Logout</a>
                    </div>
                </li>
            </ul>
        </div>
