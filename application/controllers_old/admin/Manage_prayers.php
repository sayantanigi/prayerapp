<?php
defined('BASEPATH') OR exit('No direct script are allowed');
class Manage_prayers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Prayersmodel');
    }

    function index() {
        $get_prayer=$this->Crud_model->GetData('all_prayers');
        $header = array('title' => 'Prayer');
        $data = array(
            'heading' => 'Prayer',
            'get_prayer' => $get_prayer
        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/prayers/list',$data);
        $this->load->view('admin/footer');
    }

    function ajax_manage_page() {
        $cond = "1=1";
        $prayer_dt = $_POST['SearchData5'];
        $create_date = $_POST['SearchData7'];
        if($prayer_dt!='') {
            $cond .=" and all_prayers.prayer_datetime LIKE '%".date('Y-m-d',strtotime($prayer_dt))."%'";
        }

        if($create_date!='') {
            $cond .=" and all_prayers.created_date LIKE '%".date('Y-m-d',strtotime($create_date))."%'";
        }

        $GetData = $this->Prayersmodel->get_datatables($cond);
        //print_r($GetData);
        if(empty($_POST['start'])) {
            $no=0;
        } else {
            $no =$_POST['start'];
        }

        $data = array();
        foreach ($GetData as $row) {
            $btn = ''.'<span class="btn btn-sm bg-success-light" data-toggle="modal" data-target="#editModal" onclick="getValue('.$row->id.')" data-placement="right"><i class="far fa-edit"></i></span>';
            $btn .= ' | '.'<span data-placement="right" class="btn btn-sm btn-danger" onclick="eventDelete(this,'.$row->id.')"><i class="fa fa-trash"></i></span>';
            if(!empty($row->prayer_image)) {
                if(!file_exists("uploads/prayer/".$row->prayer_image)) {
                    $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
                } else {
                    $img ='<a href="'.base_url('uploads/prayer/'.$row->prayer_image).'" data-lightbox="roadtrip"><img class="rounded service-img mr-1"src="'.base_url('uploads/prayer/'.$row->prayer_image).'"><a>';
                }
            } else {
                $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
            }

            if(strlen($row->prayer_subheading)>100) {
                $subhead = substr($row->prayer_subheading,0,70).'...';
            } else {
                $subhead = $row->prayer_subheading;
            }

            if(strlen($row->prayer_description)>100) {
                $desc = substr($row->prayer_description,0,70).'...';
            } else {
                $desc = $row->prayer_description;
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $img;
            $nestedData[] = $row->prayer_name;
            $nestedData[] = ucwords($subhead);
            $nestedData[] = ucwords($desc);
            $nestedData[] = date('d-m-Y h:i A', strtotime($row->prayer_datetime));
            $nestedData[] = date('d-m-Y h:i A',strtotime($row->created_date));
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Prayersmodel->count_all($cond),
            "recordsFiltered" => $this->Prayersmodel->count_filtered($cond),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function create_action() {
        //print_r($_POST); die();
        $get_data=$this->Crud_model->get_single('all_prayers',"prayer_name='".$_POST['prayer_name']."'");
        if(isset($_FILES['prayer_image']['name'])!='' ) {
            $_POST['prayer_image']= rand(0000,9999)."_".$_FILES['prayer_image']['name'];
            $config2['image_library'] = 'gd2';
            $config2['source_image'] =  $_FILES['prayer_image']['tmp_name'];
            $config2['new_image'] =   getcwd().'/uploads/prayer/'.$_POST['prayer_image'];
            $config2['upload_path'] =  getcwd().'/uploads/prayer/';
            $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
            $config2['maintain_ratio'] = FALSE;
            $this->image_lib->initialize($config2);
            if(!$this->image_lib->resize()) {
                echo('<pre>');
                echo ($this->image_lib->display_errors());
                exit;
            } else {
                $image  = $_POST['prayer_image'];
            }
        } else {
            $image  = "";
        }

        if(empty($get_data)) {
            $data=array(
                'user_id'=>$_POST['user_id'],
                'prayer_image'=>$image,
                'prayer_name'=>$_POST['prayer_name'],
                'prayer_subheading'=>$_POST['prayer_subheading'],
                'prayer_description'=>$_POST['prayer_description'],
                'prayer_location'=>$_POST['prayer_location'],
                'prayer_datetime'=>$_POST['prayer_datetime'],
                'created_date'=>date('Y-m-d H:i:s'),
            );
            $this->db->insert('all_prayers',$data);
            $this->session->set_flashdata('message', 'Prayer created successfully');
            echo "1"; exit;
        } else {
            $this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
            echo "0"; exit;
        }
    }

    public function get_value() {
        $prayer_data=$this->Crud_model->get_single('all_prayers',"id='".$_POST['id']."'");
        if(!empty($prayer_data->prayer_image)) {
            if(!file_exists("uploads/prayer/".$prayer_data->prayer_image)) {
                $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
            } else {
                $img ='<img  class="rounded service-img mr-1" src="'.base_url('uploads/prayer/'.$prayer_data->prayer_image).'" >';
            }
        } else {
            $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
        }
        //$eduration = explode(" ", $prayer_data->prayer_duration);
        $data=array(
            'id'=>$prayer_data->id,
            'prayer_name'=>$prayer_data->prayer_name,
            'prayer_subheading'=> $prayer_data->prayer_subheading,
            'prayer_description'=> $prayer_data->prayer_description,
            'prayer_location'=> $prayer_data->prayer_location,
            'prayer_datetime'=> $prayer_data->prayer_datetime,
            'image'=>$img,
            'old_image'=>$prayer_data->prayer_image,
        );
        echo json_encode($data);exit;
    }

    function update_action() {
        if(!empty($_FILES['prayer_image']['name'])) {
            $_POST['prayer_image']= rand(0000,9999)."_".$_FILES['prayer_image']['name'];
            $config2['image_library'] = 'gd2';
            $config2['source_image'] =  $_FILES['prayer_image']['tmp_name'];
            $config2['new_image'] =   getcwd().'/uploads/prayer/'.$_POST['prayer_image'];
            $config2['upload_path'] =  getcwd().'/uploads/prayer/';
            $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
            $config2['maintain_ratio'] = FALSE;
            $this->image_lib->initialize($config2);
            if(!$this->image_lib->resize()) {
                echo('<pre>');
                echo ($this->image_lib->display_errors());
                exit;
            } else {
                $image  = $_POST['prayer_image'];
                @unlink('uploads/prayer/'.$_POST['old_image']);
            }
        } else {
            $image  = $_POST['old_image'];
        }
        //$get_data=$this->Crud_model->get_single_record('all_prayers',"prayer_name = '".$_POST['prayer_name']."' and id != '".$_POST['id']."'");
        //if(empty($get_data)) {
            $data = array(
                'prayer_image'=>$image,
                'prayer_name'=>$_POST['prayer_name'],
                'prayer_subheading'=>$_POST['prayer_subheading'],
                'prayer_description'=>$_POST['prayer_description'],
                'prayer_location'=>$_POST['prayer_location'],
                'prayer_datetime'=>$_POST['prayer_datetime'],
                'created_date'=>date('Y-m-d H:i:s'),
            );
            $this->Crud_model->SaveData('all_prayers',$data,"id='".$_POST['id']."'");
            $this->session->set_flashdata('message', 'Prayer updated successfully');
            echo 1; exit;
        //} else {
            //$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
            //echo 0; exit;
        //}
    }

    public function delete() {
        if(isset($_POST['cid'])) {
            $this->Crud_model->DeleteData('all_prayers',"id='".$_POST['cid']."'");
            $this->session->set_flashdata('message', 'Prayer deleted successfully');
            echo 0; exit;
        }
    }
}
