<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(0);
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
			// $btn = ''.'<span class="btn btn-sm bg-success-light mr-2" data-toggle="modal" data-target="#editModal" onclick="getValue('.$row->id.')" data-placement="right"><i class="far fa-edit mr-1"></i> Edit</span>';
			// $btn .= ' | '.'<span data-placement="right" class="btn btn-sm btn-danger mr-2" onclick="product_Delete(this,'.$row->id.')" style="margin-left: 8px;">Delete</span>';
			$btn = ''.'<a href=product/update/'.base64_encode($row->id).' class="btn btn-sm bg-success-light"><i class="far fa-edit"></i></a>';
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
			$get_cat = $this->db->query("SELECT * FROM product_category WHERE id = '".$row->pro_cat_id."'")->result_array();
			$no++;
			$nestedData = array();
			$nestedData[] = $no;
			$nestedData[] = ucwords($row->pro_name);
            $nestedData[] = ucwords($desc);
            $nestedData[] = ucwords($get_cat[0]['category_name']);
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
	public function create() {
        $category = $this->Crud_model->GetData('product_category');
        $header = array('title'=> 'Add');
        $data = array(
            'heading'=>'Add New Product',
            'button'=>'Create',
			'category' => $category,
        );
        //print_r($data); die;
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/product/form',$data);
        $this->load->view('admin/footer');
    }
	public function create_action() {
		$get_data=$this->Crud_model->get_single('product_list',"pro_name='".$_POST['pro_name']."'");
		//print_r($get_data); die();
		if(empty($get_data)) {
			$data=array(
                'pro_cat_id'=>$_POST['pro_cat_id'],
				'pro_name'=>$_POST['pro_name'],
                'pro_desc'=>$_POST['pro_desc'],
                'mrp'=>$_POST['pro_mrp'],
                'discount'=>$_POST['pro_discount'],
                'final_price'=>$_POST['final_price'],
				'created_date'=>date('Y-m-d H:i:s'),
			);
			$this->db->insert('product_list',$data);
			$insert_id = $this->db->insert_id();
			//echo $insert_id;
			if(!empty($insert_id)) {
				if (!empty($_FILES['pro_image']['name'][0])) {
					$cpt = count($_FILES['pro_image']['name']);
					for($i=0; $i<$cpt; $i++) {
						$src = $_FILES['pro_image']['tmp_name'][$i];
						$avatar = rand(0000, 9999) . "_" . $_FILES['pro_image']['name'][$i];
						$avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
						$dest = getcwd() . '/uploads/product/' . $avatar1;
						if (move_uploaded_file($src, $dest)) {
							$image  = $avatar1;
							@unlink('uploads/product/' . $_POST['old_image']);
						}
						$data_image = array(
							'prod_id' => $insert_id,
							'pro_image' => $image,
							'created_date' => date("Y-m-d H:i:s"),
						);
						$this->Crud_model->SaveData('product_image', $data_image);
						$this->session->set_flashdata('message', 'Product Created Successfully !');
					}
				}
			}
			$this->session->set_flashdata('message', 'Product created successfully');
			redirect(base_url('admin/product'));
		} else {
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
			redirect(base_url('admin/product'));
		}
	}

	/*public function get_value() {
		$pro_data = $this->db->query("SELECT * FROM product_list WHERE id= '".$_POST['id']."' AND status = 'Active'")->result_array();
		$prodataimg = $this->db->query("SELECT * FROM product_image WHERE prod_id = '".@$pro_data[0]['id']."'")->result_array();
		if(!empty($prodataimg)) {
			$img = '';
			$oldimage = '';
			foreach ($prodataimg as $value) {
				$img .='<img  class="rounded service-img mr-1" src="'.base_url('uploads/product/'.$value['pro_image']).'" >';
				$oldimage .= $value['pro_image'].",";
			}
		} else {
			$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
			$oldimage = '';
		}
		// if(!empty($pro_data->pro_image)) {
		// 	if(!file_exists("uploads/product/".$pro_data->pro_image)) {
		// 		$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
		// 	} else {
		// 		$img ='<img  class="rounded service-img mr-1" src="'.base_url('uploads/product/'.$pro_data->pro_image).'" >';
		// 	}
		// } else {
		// 	$img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
		// }
		$data=array(
			'id'=>$pro_data[0]['id'],
            'pro_cat_id'=>$pro_data[0]['pro_cat_id'],
            'image'=>$img,
            'pro_name'=>$pro_data[0]['pro_name'],
            'pro_desc'=>$pro_data[0]['pro_desc'],
            'mrp'=>$pro_data[0]['mrp'],
            'discount'=>$pro_data[0]['discount'],
            'final_price'=>$pro_data[0]['final_price'],
			'old_image'=>rtrim($oldimage, ",")
		);
		echo json_encode($data);exit;
	}*/
	public function update($id) {
        $get_category=$this->Crud_model->GetData('product_category');
        $prod_id=base64_decode($id);
        $update_prod=$this->Crud_model->get_single('product_list',"id = '".$prod_id."'");
        //print_r($update_prod); die();
        $header=array('title'=>'update');
        $data=array(
            'heading'=>'Edit Product',
            'button'=>'Update',
			'pro_cat_id'=>set_value('pro_cat_id',$update_prod->pro_cat_id),
            'pro_name'=>set_value('pro_name',$update_prod->pro_name),
            'pro_desc'=>set_value('pro_desc',$update_prod->pro_desc),
            'mrp'=>set_value('mrp',$update_prod->mrp),
            'discount'=>set_value('discount',$update_prod->discount),
            'final_price'=>set_value('final_price',$update_prod->final_price),
            'id'=>$prod_id,
            'category' => $get_category
        );
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/product/form',$data);
        $this->load->view('admin/footer');
    }
	function update_action() {
		$get_data=$this->Crud_model->get_single_record('product_list',"pro_name='".$_POST['pro_name']."' and id!='".$_POST['id']."'");
		//echo $this->db->last_query();
		if(empty($get_data)) {
			$data=array(
                'pro_cat_id'=>$_POST['pro_cat_id'],
                //'pro_image'=>$image,
                'pro_name'=>$_POST['pro_name'],
                'pro_desc'=>$_POST['pro_desc'],
                'mrp'=>$_POST['pro_mrp'],
                'discount'=>$_POST['pro_discount'],
                'final_price'=>$_POST['final_price'],
                //'pro_image'=>$_POST['pro_image'],
                'update_date'=>date('Y-m-d H:i:s')
            );
			$this->Crud_model->SaveData('product_list',$data,"id='".$_POST['id']."'");
			if (!empty($_FILES['pro_image']['name'][0])) {
				$cpt = count($_FILES['pro_image']['name']);
				for($i=0; $i<$cpt; $i++) {
					$src = $_FILES['pro_image']['tmp_name'][$i];
					$avatar = rand(0000, 9999) . "_" . $_FILES['pro_image']['name'][$i];
					$avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
					$dest = getcwd() . '/uploads/product/' . $avatar1;
					if (move_uploaded_file($src, $dest)) {
						$image  = $avatar1;
						@unlink('uploads/product/' . $_POST['old_image']);
					}
					$data_image = array(
						'prod_id' => $_POST['id'],
						'pro_image' => $image,
						'created_date' => date("Y-m-d H:i:s"),
					);
					$this->Crud_model->SaveData('product_image', $data_image);
					$this->session->set_flashdata('message', 'Product Created Successfully !');
				}
			}
			$this->session->set_flashdata('message', 'Product updated successfully');
			redirect(base_url('admin/product'));
		} else{
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
			redirect(base_url('admin/product'));
		}
	}
	public function delete_product_image() {
		$p_id = $this->input->post('id');
		$delete_prod = $this->db->query("DELETE FROM product_image WHERE id = '$p_id'");
	}
	public function delete() {
        if(isset($_POST['cid'])) {
			$this->Crud_model->DeleteData('product_image',"prod_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('product_list',"id='".$_POST['cid']."'");
        }
    }
}
