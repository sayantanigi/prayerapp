<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_category extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Product_categorymodel');
	}

	function index() {
		$get_category=$this->Crud_model->GetData('product_category');
		$header = array('title' => 'Product Category');
		$data = array(
			'heading' => 'Product Category',
			'get_category' => $get_category
		);
		$this->load->view('admin/header', $header);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/product_category/list',$data);
		$this->load->view('admin/footer');
	}

	function ajax_manage_page() {
		$cond = "1=1";
		$product_category = $_POST['SearchData6'];
		$from_date = $_POST['SearchData5'];

		if($product_category!='') {
			$cond .=" and product_category.id  = '".$product_category."' ";
		}

		if($from_date!='') {
			$cond .=" and product_category.created_date  >= '".date('Y-m-d',strtotime($from_date))."' ";
		}

		$GetData = $this->Product_categorymodel->get_datatables($cond);
		if(empty($_POST['start'])) {
			$no=0;
		} else {
			$no =$_POST['start'];
		}

		$data = array();
		foreach ($GetData as $row) {
			$btn = ''.'<span class="btn btn-sm bg-success-light mr-2" data-toggle="modal" data-target="#editModal" onclick="getValue('.$row->id.')" data-placement="right"><i class="far fa-edit mr-1"></i> Edit</span>';
			$btn .= ' | '.'<span data-placement="right" class="btn btn-sm btn-danger mr-2" onclick="prod_categoryDelete(this,'.$row->id.')" style="margin-left: 8px;">Delete</span>';
			if(!empty($row->category_image)) {
				if(!file_exists("uploads/product_category/".$row->category_image)) {
					$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
				} else {
					$img ='<a href="'.base_url('uploads/product_category/'.$row->category_image).'" data-lightbox="roadtrip"><img class="rounded service-img mr-1"src="'.base_url('uploads/product_category/'.$row->category_image).'"><a>';
				}
			} else {
				$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
			}
			$no++;
			$nestedData = array();
			$nestedData[] = $no;
			$nestedData[] = $img.' '.ucwords($row->category_name);
			$nestedData[] = date('d-m-Y',strtotime($row->created_date));
			$nestedData[] = $btn;
			$data[] = $nestedData;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Product_categorymodel->count_all($cond),
			"recordsFiltered" => $this->Product_categorymodel->count_filtered($cond),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function create_action() {
		$get_data=$this->Crud_model->get_single('product_category',"category_name='".$_POST['category_name']."'");
		if(isset($_FILES['category_image']['name'])!='' ) {
			$_POST['category_image']= rand(0000,9999)."_".$_FILES['category_image']['name'];
			$config2['image_library'] = 'gd2';
			$config2['source_image'] =  $_FILES['category_image']['tmp_name'];
			$config2['new_image'] =   getcwd().'/uploads/product_category/'.$_POST['category_image'];
			$config2['upload_path'] =  getcwd().'/uploads/product_category/';
			$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
			$config2['maintain_ratio'] = FALSE;
			$this->image_lib->initialize($config2);
			if(!$this->image_lib->resize()) {
				echo('<pre>');
				echo ($this->image_lib->display_errors());
				exit;
			} else {
				$image  = $_POST['category_image'];
			}
		} else {
			$image  = "";
		}

		if(empty($get_data)) {
			$data=array(
				'category_name'=>$_POST['category_name'],
				'category_image'=>$image,
				'created_date'=>date('Y-m-d H:i:s'),
			);
			$this->db->insert('product_category',$data);
			$this->session->set_flashdata('message', 'Product Category created successfully');
			echo "1"; exit;
		} else {
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
			echo "0"; exit;
		}
	}

	public function get_value() {
		$category_data=$this->Crud_model->get_single('product_category',"id='".$_POST['id']."'");
		if(!empty($category_data->category_image)) {
			if(!file_exists("uploads/product_category/".$category_data->category_image)) {
				$img ='<img class="rounded service-img mr-1" src="'.base_url('product_category/no_image.png').'">';
			} else {
				$img ='<img  class="rounded service-img mr-1" src="'.base_url('uploads/product_category/'.$category_data->category_image).'" >';
			}
		} else {
			$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
		}
		$data=array(
			'id'=>$category_data->id,
			'category_name'=>$category_data->category_name,
			'image'=>$img,
			'old_image'=>$category_data->category_image,
		);
		echo json_encode($data);exit;
	}

	function update_action() {
		if(isset($_FILES['category_image']['name'])!='' ) {
			$_POST['category_image']= rand(0000,9999)."_".$_FILES['category_image']['name'];
			$config2['image_library'] = 'gd2';
			$config2['source_image'] =  $_FILES['category_image']['tmp_name'];
			$config2['new_image'] =   getcwd().'/uploads/product_category/'.$_POST['category_image'];
			$config2['upload_path'] =  getcwd().'/uploads/product_category/';
			$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
			$config2['maintain_ratio'] = FALSE;
			$this->image_lib->initialize($config2);
			if(!$this->image_lib->resize()) {
				echo('<pre>');
				echo ($this->image_lib->display_errors());
				exit;
			} else {
				$image  = $_POST['category_image'];
				@unlink('uploads/product_category/'.$_POST['old_image']);
			}
		} else {
			$image  = $_POST['old_image'];
		}
		$get_data=$this->Crud_model->get_single_record('product_category',"category_name='".$_POST['category_name']."' and id!='".$_POST['id']."'");
		if(empty($get_data)) {
			$data = array(
				'category_name'=> $_POST['category_name'],
				'category_image'=>$image,
				'update_date'=>date('Y-m-d H:i:s'),

			);
			$this->Crud_model->SaveData('product_category',$data,"id='".$_POST['id']."'");
			$this->session->set_flashdata('message', 'Product Category updated successfully');
			echo 1; exit;
		} else{
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
			echo 0; exit;
		}
	}

	public function delete() {
        if(isset($_POST['cid'])) {
			$check_catData = $this->db->query("SELECT * FROM product_list where pro_cat_id = '".$_POST['cid']."'")->num_rows();
			if($check_catData > 0) {
				$this->session->set_flashdata('message', 'Product is there related to this Product Category. Please delete the job first to delete this Product Category');
				echo 1; exit;
			} else {
				$this->Crud_model->DeleteData('product_category',"id='".$_POST['cid']."'");
				$this->session->set_flashdata('message', 'Product Category deleted successfully');
				echo 0; exit;
			}
        }
    }
}
