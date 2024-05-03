<?php
	$get_setting=$this->Crud_model->get_single('setting');
	$seg2 =$this->uri->segment(2);
?>
<div class="sidebar" id="sidebar">
	<div class="sidebar-logo">
		<a href="<?php echo admin_url();?>dashboard">
			<img src="<?=base_url(); ?>uploads/logo/<?= $get_setting->logo?>" class="img-fluid" alt="">
		</a>
	</div>
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li <?php if ($seg2 =='dashboard') {?>class="active"<?php }?>>
					<a href="<?= admin_url('dashboard')?>"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
				</li>
				<li <?php if ($seg2 =='banner') {?>class="active"<?php }?>>
					<a href="<?= admin_url('banner')?>"><i class="fas fa-image"></i> <span>Banners Management</span></a>
				</li>
				<li <?php if ($seg2 =='manage_events') {?>class="active"<?php }?>>
					<a href="<?= admin_url('manage_prayers')?>"><i class="fa fa-calendar"></i> <span>All Prayers Management</span></a>
				</li>
				<li <?php if ($seg2 =='our_prayers') {?>class="active"<?php }?>>
					<a href="<?= admin_url('our_prayers')?>"><i class="fa fa-calendar"></i> <span>Our Prayers</span></a>
				</li>
				<li <?php if ($seg2 =='manage_podcast') {?>class="active"<?php }?>>
					<a href="<?= admin_url('manage_podcast')?>"><i class="fa fa-podcast"></i> <span>All Podcasts Management</span></a>
				</li>
				<li <?php if ($seg2 =='manage_videos') {?>class="active"<?php }?>>
					<a href="<?= admin_url('manage_videos')?>"><i class="fa fa-video"></i> <span>All Videos Management</span></a>
				</li>
				<li <?php if ($seg2 =='manage_portfolio') {?>class="active"<?php }?>>
					<a href="<?= admin_url('manage_portfolio')?>"><i class="fa fa-video"></i> <span>Portfolio Management</span></a>
				</li>
				<li <?php if ($seg2 =='manage_cms') {?>class="active"<?php }?>>
					<a href="<?= admin_url('manage_cms')?>"><i class="fas fa-circle"></i> <span>Content Management</span></a>
				</li>
				<li <?php if ($seg2 =='manage_donation') {?>class="active"<?php }?>>
					<a href="<?= admin_url('manage_donation')?>"><i class="fa fa-calendar"></i> <span>Donation Management</span></a>
				</li>
				<li <?php if ($seg2 =='manage_faq') {?>class="active"<?php }?>>
					<a href="<?= admin_url('manage_faq')?>"><i class="fa fa-calendar"></i> <span>FAQ Management</span></a>
				</li>
				<li <?php if ($seg2 =='product-category') {?>class="active"<?php }?>>
					<a href="<?= admin_url('product-category')?>"><i class="fa fa-list"></i> <span>Product Category</span></a>
				</li>
				<li <?php if ($seg2 =='all-product') {?>class="active"<?php }?>>
					<a href="<?= admin_url('all-product')?>"><i class="fas fa-circle"></i><span>All Product</span></a>
				</li>
				<li <?php if ($seg2 =='users') {?>class="active"<?php }?>>
					<a href="<?=admin_url(); ?>users"><i class="fas fa-user"></i> <span>Users Management</span></a>
				</li>
				<li <?php if ($seg2 =='contact') {?>class="active"<?php }?>>
					<a href="<?=admin_url(); ?>contact"><i class="fas fa-user"></i> <span>Contact Management</span></a>
				</li>
				<li <?php if ($seg2 =='setting') {?>class="active"<?php }?>>
					<a href="<?= admin_url('setting')?>"><i class="fas fa-cog"></i> <span>Site Settings</span></a>
				</li>
			</ul>
		</div>
	</div>
</div>
