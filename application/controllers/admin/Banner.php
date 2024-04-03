<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Banner_model');
	}

	function index() {
		$header = array('title' => 'Banners');
		$data = array(
			'heading' => 'Banners',
		);
		$this->load->view('admin/header', $header);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/managehome/banner_list',$data);
		$this->load->view('admin/footer');
	}

	public function ajax_manage_page() {
		$get_data = $this->Banner_model->get_datatables();
		if(empty($_POST['start'])) {
			$no=0;
		} else {
			$no =$_POST['start'];
		}
		$data = array();
		foreach ($get_data as $row) {
			$btn = '<span class="btn btn-sm bg-success-light mr-2" data-toggle="modal" data-target="#editModal" onclick="getValue('.$row->id.')" data-placement="right"><i class="far fa-edit mr-1"></i> Edit</span>';
			$btn .= ' |  '.'<span data-placement="right" class="btn btn-sm btn-danger mr-2" onclick="sliderDelete(this,'.$row->id.')" style="margin-left: 8px;">Delete</span>';
			$allowed = array('JPEG', 'PNG', 'JPG', 'GIF', 'jpeg', 'jpg', 'png', 'gif');
			//$allowed1 = array('MP4', 'MOV', 'WMV','AVI', 'MKV', 'WEBM','mp4', 'mov', 'wmv','avi', 'mkv', 'webm');
			$filename = $row->image;
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			if(!empty($row->image) && file_exists("uploads/banner/".$row->image)) {
				if (in_array($ext, $allowed)) {
					$img ='<a href="'.base_url('uploads/banner/'.$row->image).'" data-lightbox="roadtrip"><img class="rounded service-img mr-1"src="'.base_url('uploads/banner/'.$row->image).'" ><a>';
				} else {
					//$img ='<a href="'.base_url('uploads/banner/'.$row->image).'" data-lightbox="roadtrip"><img class="rounded service-img mr-1"src="'.base_url('uploads/banner/'.$row->image).'" ><a>';
					$img ='<video width="100" height="60" controls><source src="'.base_url('uploads/banner/'.$row->image).'"></video>';
				}
			} else {
				$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'" >';
			}
			$no++;
			$nestedData = array();
			$nestedData[] = $no;
			$nestedData[] = ucwords($row->page_name);
			$nestedData[] = $img;
			$nestedData[] = $btn;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Banner_model->count_all(),
			"recordsFiltered" => $this->Banner_model->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function create_action() {
		// if(isset($_FILES['image']['name'])!='' ) {
		// 	$_POST['image']= rand(0000,9999)."_".$_FILES['image']['name'];
		// 	$config2['image_library'] = 'gd2';
		// 	$config2['source_image'] =  $_FILES['image']['tmp_name'];
		// 	$config2['new_image'] =   getcwd().'/uploads/banner/'.$_POST['image'];
		// 	$config2['upload_path'] =  getcwd().'/uploads/banner/';
		// 	$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
		// 	$config2['maintain_ratio'] = FALSE;
		// 	$this->image_lib->initialize($config2);
		// 	if(!$this->image_lib->resize()) {
		// 		echo('<pre>');
		// 		echo ($this->image_lib->display_errors());
		// 		exit;
		// 	} else {
		// 		$image  = $_POST['image'];
		// 	}
		// } else {
		// 	$image  = "";
		// }
		if ($_FILES['image']['name'] != '') {
			$src_file = $_FILES['image']['tmp_name'];
			$filEncFile = time();
			$avatar_file = rand(0000, 9999) . "_" . $_FILES['image']['name'];
			$avatarFile = str_replace(array('(', ')', ' '), '', $avatar_file);
			$dest_file = getcwd() . '/uploads/banner/' . $avatarFile;
			if (move_uploaded_file($src_file, $dest_file)) {
				$image  = $avatarFile;
				@unlink('uploads/banner/' . $_POST['old_podcast_file']);
			}
		} else {
			$image  = $_POST['old_image'];
		}
		$data=array(
			//'heading'=>$this->input->post('name'),
			'page_name'=>$_POST['page_name'],
			'image'=>$image,
			'created_date'=>date('Y-m-d H:i:s'),
		);
		$this->db->insert('banner',$data);
		$this->session->set_flashdata('message', 'Banner created successfully');
		echo "1"; exit;
	}

	public function get_value() {
		$banner_data=$this->Crud_model->get_single('banner',"id='".$_POST['id']."'");
		if(!empty($banner_data->image)) {
			if(!file_exists("uploads/banner/".$banner_data->image)) {
				$img ='<iframe class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
			} else {
				$img ='<iframe class="rounded service-img mr-1" src="'.base_url('uploads/banner/'.$banner_data->image).'" >';
			}
		} else {
			$img ='<iframe class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
		}
		$data=array(
			'id'=>$banner_data->id,
			//'heading'=>$banner_data->heading,
			'page_name'=>$banner_data->page_name,
			'image'=>$img,
			'old_image'=>$banner_data->image,
		);
		echo json_encode($data);exit;
	}

	function update_action() {
		/*if(isset($_FILES['image']['name'])!='' ) {
			$_POST['image']= rand(0000,9999)."_".$_FILES['image']['name'];
			$config2['image_library'] = 'gd2';
			$config2['source_image'] =  $_FILES['image']['tmp_name'];
			$config2['new_image'] =   getcwd().'/uploads/banner/'.$_POST['image'];
			$config2['upload_path'] =  getcwd().'/uploads/banner/';
			$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
			$config2['maintain_ratio'] = FALSE;
			$this->image_lib->initialize($config2);
			if(!$this->image_lib->resize()) {
				echo('<pre>');
				echo ($this->image_lib->display_errors());
				exit;
			} else {
				$image  = $_POST['image'];
				@unlink('uploads/banner/'.$_POST['old_image']);
			}
		} else {
			$image  = $_POST['old_image'];;
		}*/
		if (@$_FILES['image']['name'] != '') {
			$src_file = $_FILES['image']['tmp_name'];
			$filEncFile = time();
			$avatar_file = rand(0000, 9999) . "_" . $_FILES['image']['name'];
			$avatarFile = str_replace(array('(', ')', ' '), '', $avatar_file);
			$dest_file = getcwd() . '/uploads/banner/' . $avatarFile;
			if (move_uploaded_file($src_file, $dest_file)) {
				$image  = $avatarFile;
				@unlink('uploads/banner/' . $_POST['old_podcast_file']);
			}
		} else {
			$image  = $_POST['old_image'];
		}
		$data = array(
			//'heading'=>$this->input->post('name'),
			'page_name'=>$_POST['page_name'],
			'image'=>$image,

		);
		$this->Crud_model->SaveData('banner',$data,"id='".$_POST['id']."'");
		$this->session->set_flashdata('message', 'Banner updated successfully');
		echo 1; exit;
	}

	public function delete() {
        if(isset($_POST['cid'])) {
            $this->Crud_model->DeleteData('banner',"id='".$_POST['cid']."'");
        }
    }

}
