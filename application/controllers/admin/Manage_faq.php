<?php
defined('BASEPATH')  OR exit('No direct script are allowed');
class Manage_faq extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('faqmodel');
    }
    public function index() {
        $header = array('title' => 'FAQ Management');
        $data = array('heading' => 'FAQ Management');
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/faq/list',$data);
        $this->load->view('admin/footer');
    }
    public function ajax_manage_page() {
        $get_faq = $this->faqmodel->get_datatables();
        if(empty($_POST['start'])) {
            $no=0;
        } else {
            $no =$_POST['start'];
        }
        $data = array();
        foreach ($get_faq as $row) {
            $btn = ''.'<span class="btn btn-sm bg-success-light" data-toggle="modal" data-target="#editModal" onclick="getValue('.$row->id.')" data-placement="right"><i class="far fa-edit"></i></span>';
            $btn .= ' | '.'<span data-placement="right" class="btn btn-sm btn-danger" onclick="faqDelete(this,'.$row->id.')"><i class="fa fa-trash"></i></span>';

            if(strlen($row->answer)>100) {
                $desc = substr($row->answer,0,60).'...';
            } else {
                $desc = $row->answer;
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = ucwords($row->question);
            $nestedData[] = $desc;
            $nestedData[] = $row->created;
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->faqmodel->count_all(),
            "recordsFiltered" => $this->faqmodel->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function create_action() {
        $get_data=$this->Crud_model->get_single('faq',"question = '".$_POST['question']."'");
        
        if(empty($get_data)) {
            $data = array(
                'question'=> $_POST['question'],
                'answer'=>$_POST['answer'],
                'created'=> date('Y-m-d H:i:s'),
            );
            $this->Crud_model->SaveData('faq',$data);
            $this->session->set_flashdata('message', 'FAQ created successfully');
            echo "1"; exit;
        } else {
            $this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
            echo "0"; exit;
        }
    }

    public function get_value() {
        $get_data=$this->Crud_model->get_single('faq',"id = '".$_POST['id']."'");
        
        $data=array(
            'id' => $get_data->id,
            'question' => $get_data->question,
            'answer' => $get_data->answer
        );
        echo json_encode($data);exit;
    }

    public function update_action() {
        $update_data=$this->Crud_model->get_single('faq',"question ='".$_POST['question']."' and id!='".$_POST['id']."'");
        
        if(empty($update_data)) {
            $data=array(
                'question'=>$_POST['question'],
                'answer'=>$_POST['answer']
            );
            $this->Crud_model->SaveData('faq',$data,"id='".$_POST['id']."'");
            $this->session->set_flashdata('message', 'FAQ updated successfully');
            echo "1";exit;
        } else {
            $this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
            echo "0";exit;
        }
    }

    public function delete() {
        if(isset($_POST['cid'])) {
            $this->Crud_model->DeleteData('faq',"id='".$_POST['cid']."'");
            $this->session->set_flashdata('message', 'FAQ deleted successfully');
            echo 0; exit;
        }
    }
}