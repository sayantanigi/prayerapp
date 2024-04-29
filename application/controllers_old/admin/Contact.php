<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Contact_model');
    }

    function index() {
        $header = array('title' => 'contact');
        $data = array(
            'heading' => 'Contact',
        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/contact/list',$data);
        $this->load->view('admin/footer');
    }

    function ajax_manage_page() {
        $GetData = $this->Contact_model->get_datatables();
        if(empty($_POST['start'])) {
            $no=0;
        } else {
            $no =$_POST['start'];
        }
        $data = array();
        foreach ($GetData as $row) {
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $row->name;
            $nestedData[] = $row->email;
            $nestedData[] = $row->phone;
            $nestedData[] = $row->subject;
            $nestedData[] = $row->subject;
            $nestedData[] = $row->message;
            $nestedData[] = date('d-m-Y',strtotime($row->update_date));
            $data[] = $nestedData;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Contact_model->count_all(),
            "recordsFiltered" => $this->Contact_model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function view($id)
    {
        $con="userId ='".base64_decode($id)."'";
        $get_userdata=$this->Crud_model->get_single('users',$con);

        $header = array('title' => 'user view');
        $data = array(
            'heading' => 'User',
            'get_userdata' => $get_userdata,
        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/users/view',$data);
        $this->load->view('admin/footer');
    }

    public function change_status()
    {
        if($_POST['status']=='1')
        {
            $statuss='0';

        }
        else if($_POST['status']=='0'){
            $statuss='1';

        }
        $data=array(
            'status'=>$statuss,
        );
        $this->Crud_model->SaveData("users",$data,"userId='".$_POST['id']."'");

    }

    public function email_verification() {
        if($_POST['email_verified']=='1') {
            $email_verified='0';
        } else if($_POST['email_verified']=='0'){
            $email_verified='1';

        }
        $data=array(
            'email_verified'=>$email_verified,
            'status'=> '1',
        );
        $this->Crud_model->SaveData("users",$data,"userId='".$_POST['id']."'");

    }

    public function delete() {
        if(isset($_POST['cid'])) {
            $this->Crud_model->DeleteData('users',"userId='".$_POST['cid']."'");
        }
    }

    public function viewPass() {
        $uID = $_POST['id'];
        $get_password = $this->db->query("SELECT password FROM users WHERE userId = '".$uID."'")->result_array();
        echo $upass = base64_decode($get_password[0]['password']);
    }

    public function changePass() {
        $uID = $_POST['uIDforpass'];
        $newpass = base64_encode($_POST['changepass']);
        $data = array(
            "password" => $newpass
        );
        $this->Crud_model->SaveData("users",$data,"userId='".$uID."'");
        echo "Reset password Succeesful";
    }

}//end controller

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */
