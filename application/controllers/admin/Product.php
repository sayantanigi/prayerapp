<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Productmodel');
	}

	function index() {
		$get_product=$this->Crud_model->GetData('product_list');
        $get_category=$this->Crud_model->GetData('product_category');
		$header = array('title' => 'Product Lists');
		$data = array(
			'heading' => 'Product Lists',
			'get_product' => $get_product,
            'get_category' => $get_category
		);
		$this->load->view('admin/header', $header);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/product/list',$data);
		$this->load->view('admin/footer');
	}

	function ajax_manage_page() {
		$cond = "1=1";
		$product_list = $_POST['SearchData6'];
		$from_date = $_POST['SearchData5'];

		if($product_list!='') {
			$cond .=" and product_list.pro_cat_id  = '".$product_list."' ";
		}

		if($from_date!='') {
			$cond .=" and product_list.created_date  >= '".date('Y-m-d',strtotime($from_date))."' ";
		}

		$GetData = $this->Productmodel->get_datatables($cond);
		if(empty($_POST['start'])) {
			$no=0;
		} else {
			$no =$_POST['start'];
		}

		$data = array();
		foreach ($GetData as $row) {
			$btn = ''.'<span class="btn btn-sm bg-success-light mr-2" data-toggle="modal" data-target="#editModal" onclick="getValue('.$row->id.')" data-placement="right"><i class="far fa-edit mr-1"></i> Edit</span>';
			$btn .= ' | '.'<span data-placement="right" class="btn btn-sm btn-danger mr-2" onclick="product_Delete(this,'.$row->id.')" style="margin-left: 8px;">Delete</span>';
			if(!empty($row->pro_image)) {
				if(!file_exists("uploads/product/".$row->pro_image)) {
					$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
				} else {
					$img ='<a href="'.base_url('uploads/product/'.$row->pro_image).'" data-lightbox="roadtrip"><img class="rounded service-img mr-1"src="'.base_url('uploads/product/'.$row->pro_image).'"><a>';
				}
			} else {
				$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
			}
            if(strlen($row->pro_desc)>100) {
                $desc=substr($row->pro_desc,0,60).'...';
            } else {
                $desc=$row->pro_desc;
            }
			$no++;
			$nestedData = array();
			$nestedData[] = $no;
			$nestedData[] = $img;
            $nestedData[] = ucwords($row->pro_name);
            $nestedData[] = ucwords($desc);
            $nestedData[] = ucwords($row->pro_cat_id);
            $nestedData[] = $row->mrp;
            $nestedData[] = $row->discount."%";
            $nestedData[] = $row->final_price;
			$nestedData[] = date('d-m-Y',strtotime($row->created_date));
			$nestedData[] = $btn;
			$data[] = $nestedData;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Productmodel->count_all($cond),
			"recordsFiltered" => $this->Productmodel->count_filtered($cond),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function create_action() {
        //print_r($_POST); die();
		$get_data=$this->Crud_model->get_single('product_list',"pro_name='".$_POST['pro_name']."'");
		if(isset($_FILES['pro_image']['name'])!='' ) {
			$_POST['pro_image']= rand(0000,9999)."_".$_FILES['pro_image']['name'];
			$config2['image_library'] = 'gd2';
			$config2['source_image'] =  $_FILES['pro_image']['tmp_name'];
			$config2['new_image'] =   getcwd().'/uploads/product/'.$_POST['pro_image'];
			$config2['upload_path'] =  getcwd().'/uploads/product/';
			$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
			$config2['maintain_ratio'] = FALSE;
			$this->image_lib->initialize($config2);
			if(!$this->image_lib->resize()) {
				echo('<pre>');
				echo ($this->image_lib->display_errors());
				exit;
			} else {
				$image  = $_POST['pro_image'];
			}
		} else {
			$image  = "";
		}

		if(empty($get_data)) {
			$data=array(
                'pro_cat_id'=>$_POST['pro_cat_id'],
                'pro_image'=>$image,
				'pro_name'=>$_POST['pro_name'],
                'pro_desc'=>$_POST['pro_desc'],
                'mrp'=>$_POST['pro_mrp'],
                'discount'=>$_POST['pro_discount'],
                'final_price'=>$_POST['final_price'],
				'created_date'=>date('Y-m-d H:i:s'),
			);
			$this->db->insert('product_list',$data);
			$this->session->set_flashdata('message', 'Product created successfully');
			echo "1"; exit;
		} else {
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
			echo "0"; exit;
		}
	}

	public function get_value() {
		$pro_data=$this->Crud_model->get_single('product_list',"id='".$_POST['id']."'");
		if(!empty($pro_data->pro_image)) {
			if(!file_exists("uploads/product/".$pro_data->pro_image)) {
				$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
			} else {
				$img ='<img  class="rounded service-img mr-1" src="'.base_url('uploads/product/'.$pro_data->pro_image).'" >';
			}
		} else {
			$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
		}
		$data=array(
			'id'=>$pro_data->id,
            'pro_cat_id'=>$pro_data->pro_cat_id,
            'image'=>$img,
            'pro_name'=>$pro_data->pro_name,
            'pro_desc'=>$pro_data->pro_desc,
            'mrp'=>$pro_data->mrp,
            'discount'=>$pro_data->discount,
            'final_price'=>$pro_data->final_price,
            'old_image'=>$pro_data->pro_image
		);
		echo json_encode($data);exit;
	}

	function update_action() {
		if(isset($_FILES['pro_image']['name'])!='' ) {
			$_POST['pro_image']= rand(0000,9999)."_".$_FILES['pro_image']['name'];
			$config2['image_library'] = 'gd2';
			$config2['source_image'] =  $_FILES['pro_image']['tmp_name'];
			$config2['new_image'] =   getcwd().'/uploads/product/'.$_POST['pro_image'];
			$config2['upload_path'] =  getcwd().'/uploads/product/';
			$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
			$config2['maintain_ratio'] = FALSE;
			$this->image_lib->initialize($config2);
			if(!$this->image_lib->resize()) {
				echo('<pre>');
				echo ($this->image_lib->display_errors());
				exit;
			} else {
				$image  = $_POST['pro_image'];
				@unlink('uploads/product/'.$_POST['old_image']);
			}
		} else {
			$image  = $_POST['old_image'];
		}
		$get_data=$this->Crud_model->get_single_record('product_list',"pro_name='".$_POST['pro_name']."' and id!='".$_POST['id']."'");
		if(empty($get_data)) {
			$data=array(
                'pro_cat_id'=>$_POST['pro_cat_id'],
                'pro_image'=>$image,
                'pro_name'=>$_POST['pro_name'],
                'pro_desc'=>$_POST['pro_desc'],
                'mrp'=>$_POST['pro_mrp'],
                'discount'=>$_POST['pro_discount'],
                'final_price'=>$_POST['final_price'],
                'old_image'=>$_POST['pro_image'],
                'update_date'=>date('Y-m-d H:i:s')
            );
			$this->Crud_model->SaveData('product_list',$data,"id='".$_POST['id']."'");
			$this->session->set_flashdata('message', 'Product updated successfully');
			echo 1; exit;
		} else{
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
			echo 0; exit;
		}
	}

	public function delete() {
        if(isset($_POST['cid'])) {
            $this->Crud_model->DeleteData('product_list',"id='".$_POST['cid']."'");
        }
    }
}
