<?php
defined('BASEPATH') OR exit('No direct script are allowed');
class Manage_portfolio extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Portfoliomodel');
    }
    public function index() {
        $get_portfolio = $this->db->query("SELECT * FROM portfolio WHERE status = '1'");
        //$get_category=$this->Crud_model->GetData('category');
        $header = array('title' => 'Portfolio');
        $data = array(
            'heading' => 'Portfolio',
            'get_portfolio' => $get_portfolio,
        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/portfolio/list',$data);
        $this->load->view('admin/footer');
    }
    public function ajax_manage_page() {
        $cond = "1=1";
        $GetData = $this->Portfoliomodel->get_datatables($cond);
        if(empty($_POST['start'])) {
            $no=0;
        } else {
            $no =$_POST['start'];
        }
        $data = array();
        foreach ($GetData as $row) {
            $btn = ''.'<a href=manage_portfolio/update/'.base64_encode($row->id).' class="btn btn-sm bg-success-light"><i class="far fa-edit"></i></a>';
            $btn .= ' | '.'<a href=manage_portfolio/view/'.base64_encode($row->id).' class="btn btn-sm bg-success-light"><i class="far fa-eye"></i></a>';
            $btn .= ' | '.'<span data-placement="right" class="btn btn-sm btn-danger" onclick="portfolioDelete(this,'.$row->id.')"><i class="fa fa-trash"></i></span>';
            if(!empty($row->file_link)) {
                if(!file_exists("uploads/portfolio/image/".$row->file_link)) {
                    $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
                } else {
                    $img ='<a href="'.base_url('uploads/portfolio/image/'.$row->file_link).'" data-lightbox="roadtrip"><img class="rounded service-img mr-1"src="'.base_url('uploads/portfolio/image/'.$row->file_link).'"><a>';
                }
            } else {
                $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
            }
            if(strlen($row->description)>100) {
                $desc = substr($row->description,0,70).'...';
            } else {
                $desc = $row->description;
            }
            if($row->file_type == '1') {
                $type = 'Video';
            } else {
                $type = 'Image';
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $img;
            $nestedData[] = $row->title;
            $nestedData[] = ucwords($desc);
            $nestedData[] = $type;
            $nestedData[] = date('d-m-Y h:i:s A',strtotime($row->created_date));
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Portfoliomodel->count_all($cond),
            "recordsFiltered" => $this->Portfoliomodel->count_filtered($cond),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function create() {
        $header = array('title'=> 'Add');
        $data = array(
            'heading'=>'Add New Portfolio',
            'button'=>'Create',
            'title' =>set_value('title'),
            'description' =>set_value('description'),
            'id' =>set_value('id')
        );
        //print_r($data); die;
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/portfolio/form',$data);
        $this->load->view('admin/footer');
    }
    public function create_action() {
        //print_r($this->input->post()); die();
        if(!empty($this->input->post())) {
            $get_data = $this->db->query("SELECT * FROM portfolio WHERE title LIKE '%".$_POST['title']."%' AND status = '1'")->result_array();
            //print_r($get_data); die();
            if(empty($get_data)) {
                if (!empty($_FILES['file_image']['name'])) {
                    $uploadDir = getcwd() . '/uploads/portfolio/image/';
                    $src_simage = $_FILES['file_image']['tmp_name'];
                    $avatar_simage = rand(0000, 9999) . "_" . $_FILES['file_image']['name'];
                    $avatarsImage = str_replace(array('(', ')', ' '), '', $avatar_simage);
                    $dest_simage = getcwd() . '/uploads/portfolio/image/' . $avatarsImage;
                    if (move_uploaded_file($src_simage, $dest_simage)) {
                        $simgfile  = $avatarsImage;
                        if (!empty($_POST['old_image'])) {
                            @unlink($uploadDir . $_POST['old_image']);
                        }
                    }
                } else {
                    $simgfile  = $_POST['old_image'];
                }
                if(!empty($simgfile)) {
                    $file_link = $simgfile;
                } else {
                    $file_link = $_POST['file_link'];
                }
                $data = array(
                    'title'=> $_POST['title'],
                    'description'=> $_POST['description'],
                    'file_type'=> $_POST['file_type'],
                    'file_link'=> $file_link,
                    'status'=> '1',
                    'is_delete'=> '1',
                    'created_date'=> date('Y-m-d H:i:s')
                );
                //print_r($data); die();
                $this->Crud_model->SaveData('portfolio',$data);
                $this->session->set_flashdata('message', 'Portfolio created successfully');
            }
        }
        redirect(base_url('admin/manage_portfolio'));
    }
   public function update($id) {
        $portfolio_id=base64_decode($id);
        $update_portfolio = $this->db->query("SELECT * FROM portfolio WHERE id = '".$portfolio_id."' AND status = '1'")->row();
        //print_r($update_portfolio); die();
        $header=array('title'=>'update');
        $data=array(
            'heading'=>'Edit Portfolio',
            'button'=>'Update',
            'title'=>set_value('title',$update_portfolio->title),
            'description'=>set_value('description',$update_portfolio->description),
            'file_type'=>set_value('file_type',$update_portfolio->file_type),
            'file_link'=>set_value('file_link',$update_portfolio->file_link),
            'id'=>$portfolio_id
        );
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/portfolio/form',$data);
        $this->load->view('admin/footer');
    }
    public function update_action() {
        if ($_FILES['file_image']['name'] != '') {
            $src_image = $_FILES['file_image']['tmp_name'];
            $filEncImg = time();
            $avatar_image = rand(0000, 9999) . "_" . $_FILES['file_image']['name'];
            $avatarImage = str_replace(array('(', ')', ' '), '', $avatar_image);
            $dest_image = getcwd() . '/uploads/portfolio/image/' . $avatarImage;
            if (move_uploaded_file($src_image, $dest_image)) {
                $_imgfile  = $avatarImage;
                @unlink('uploads/portfolio/image/' . $_POST['old_image']);
            }
        } else {
            $_imgfile  = $_POST['old_image'];
        }
        if($_POST['file_type'] == '2') {
            $file_link = $_imgfile;
        } else {
            $file_link = $_POST['file_link'];
            @unlink('uploads/portfolio/image/' . $_POST['old_image']);
        }
        $data = array(
            'title'=> $_POST['title'],
            'description'=> $_POST['description'],
            'file_type'=> $_POST['file_type'],
            'file_link'=> $file_link,
            'created_date'=> date('Y-m-d H:i:s')
        );
        $this->Crud_model->SaveData('portfolio',$data,"id='".$_POST['id']."'");
        $this->session->set_flashdata('message', 'Portfolio updated successfully');
        redirect(base_url('admin/manage_portfolio'));
    }
    public function view($id) {
        $portfolio_id = base64_decode($id);
        $update_portfolio = $this->Crud_model->get_single('portfolio',"id = '".$portfolio_id."'");
        $header=array('title'=>'View');
        $data=array(
            'heading'=>'Portfolio View',
            'portfolio_main'=>$update_portfolio,
        );
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/portfolio/details',$data);
        $this->load->view('admin/footer');
    }
    public function delete() {
        if(isset($_POST['cid'])) {
            $get_data = $this->Crud_model->get_single('portfolio',"id = '".$_POST['cid']."'");
            $this->Crud_model->DeleteData('portfolio',"id='".$_POST['cid']."'");
            @unlink('uploads/portfolio/image/' . @$get_data->file_link);
            $this->session->set_flashdata('message', 'Portfolio deleted successfully');
            echo 0; exit;
        }
    }
}
