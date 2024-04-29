<?php
defined('BASEPATH')  OR exit('No direct script are allowed');
class Manage_donation extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Donationmodel');
    }
    public function index() {
        $header = array('title' => 'Donation Management');
        $data = array('heading' => 'Donation Management');
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/donation/list',$data);
        $this->load->view('admin/footer');
    }
    public function ajax_manage_page() {
        $get_donation = $this->Donationmodel->get_datatables();
        if(empty($_POST['start'])) {
            $no=0;
        } else {
            $no =$_POST['start'];
        }
        $data = array();
        foreach ($get_donation as $row) {
            $btn = ''.'<span class="btn btn-sm bg-success-light" data-toggle="modal" data-target="#editModal" onclick="getValue('.$row->id.')" data-placement="right"><i class="far fa-edit"></i></span>';
            $btn .= ' | '.'<span data-placement="right" class="btn btn-sm btn-danger" onclick="donationDelete(this,'.$row->id.')"><i class="fa fa-trash"></i></span>';

            if(!empty($row->d_image)) {
                if(!file_exists("uploads/donation/".$row->d_image)) {
                    $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
                } else {
                    $img ='<a href="'.base_url('uploads/donation/'.$row->d_image).'" data-lightbox="roadtrip"><img class="rounded service-img mr-1"src="'.base_url('uploads/donation/'.$row->d_image).'"><a>';
                }
            } else {
                $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
            }

            if(strlen($row->d_description)>100) {
                $desc = substr($row->d_description,0,60).'...';
            } else {
                $desc = $row->d_description;
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $img;
            $nestedData[] = ucwords($row->d_title);
            $nestedData[] = $desc;
            $nestedData[] = "$".$row->d_amount;
            $nestedData[] = $row->created_date;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Donationmodel->count_all(),
            "recordsFiltered" => $this->Donationmodel->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function create_action() {
        $get_data=$this->Crud_model->get_single('donation',"d_title = '".$_POST['d_title']."'");
        if(isset($_FILES['d_image']['name'])!='' ) {
            $_POST['d_image']= rand(0000,9999)."_".$_FILES['d_image']['name'];
            $config2['image_library'] = 'gd2';
            $config2['source_image'] =  $_FILES['d_image']['tmp_name'];
            $config2['new_image'] =   getcwd().'/uploads/donation/'.$_POST['d_image'];
            $config2['upload_path'] =  getcwd().'/uploads/donation/';
            $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
            $config2['maintain_ratio'] = FALSE;
            $this->image_lib->initialize($config2);
            if(!$this->image_lib->resize()) {
                echo('<pre>');
                echo ($this->image_lib->display_errors());
                exit;
            } else {
                $image = $_POST['d_image'];
            }
        } else {
            $image  = "";
        }

        if(empty($get_data)) {
            $data = array(
                'user_id'=>$_POST['user_id'],
                'd_title'=> $_POST['d_title'],
                'd_description'=>$_POST['d_description'],
                'd_amount'=>$_POST['d_amount'],
                'created_date'=> date('Y-m-d H:i:s'),
                'd_image'=>$image,
            );
            $this->Crud_model->SaveData('donation',$data);
            $this->session->set_flashdata('message', 'Donation created successfully');
            echo "1"; exit;
        } else {
            $this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
            echo "0"; exit;
        }
    }

    public function get_value() {
        $get_data=$this->Crud_model->get_single('donation',"id = '".$_POST['id']."'");
        if(!empty($get_data->d_image)) {
            if(!file_exists("uploads/donation/".$get_data->d_image)) {
                $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
            } else {
                $img ='<img  class="rounded service-img mr-1" src="'.base_url('uploads/donation/'.$get_data->d_image).'" >';
            }
        } else {
            $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
        }

        $data=array(
            'id' => $get_data->id,
            'd_title' => $get_data->d_title,
            'd_description' => $get_data->d_description,
            'd_amount' => $get_data->d_amount,
            'd_image'=>$img,
            'old_image'=>$get_data->d_image,
        );
        echo json_encode($data);exit;
    }

    public function update_action() {
        $update_data=$this->Crud_model->get_single('donation',"d_title ='".$_POST['d_title']."' and id!='".$_POST['id']."'");
        if(!empty($_FILES['d_image']['name'])) {
            $_POST['d_image']= rand(0000,9999)."_".$_FILES['d_image']['name'];
            $config2['image_library'] = 'gd2';
            $config2['source_image'] =  $_FILES['d_image']['tmp_name'];
            $config2['new_image'] =   getcwd().'/uploads/donation/'.$_POST['d_image'];
            $config2['upload_path'] =  getcwd().'/uploads/donation/';
            $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
            $config2['maintain_ratio'] = FALSE;
            $this->image_lib->initialize($config2);
            if(!$this->image_lib->resize()) {
                echo('<pre>');
                echo ($this->image_lib->display_errors());
                exit;
            } else {
                $image  = $_POST['d_image'];
                @unlink('uploads/donation/'.$_POST['old_image']);
            }
        } else {
            $image  = $_POST['old_image'];
        }

        if(empty($update_data)) {
            $data=array(
                'd_image'=>$image,
                'd_title'=>$_POST['d_title'],
                'd_description'=>$_POST['d_description'],
                'd_amount'=>$_POST['d_amount'],
            );
            $this->Crud_model->SaveData('donation',$data,"id='".$_POST['id']."'");
            $this->session->set_flashdata('message', 'Donation updated successfully');
            echo "1";exit;
        } else {
            $this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
            echo "0";exit;
        }
    }

    public function delete() {
        if(isset($_POST['cid'])) {
            $this->Crud_model->DeleteData('donation',"id='".$_POST['cid']."'");
            $this->session->set_flashdata('message', 'Donation deleted successfully');
            echo 0; exit;
        }
    }
}