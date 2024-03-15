<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
    }

    function index() {
        $header = array('title' => 'users');
        $data = array(
            'heading' => 'Users',
        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/users/list',$data);
        $this->load->view('admin/footer');
    }

    function ajax_manage_page() {
        $GetData = $this->Users_model->get_datatables();
        if(empty($_POST['start'])) {
            $no=0;
        } else {
            $no =$_POST['start'];
        }
        $data = array();
        foreach ($GetData as $row) {
            $btn = '<span data-placement="right" class="btn btn-sm btn-danger mr-2" onclick="Delete(this,'.$row->userId.')" style="margin-left: 8px;"><i class="fa fa-trash mr-1"></i></span>';
            $btn .= '|'.'<span data-placement="right" class="btn btn-sm bg-success-light mr-2" onclick="viewPass(this,'.$row->userId.')" style="margin-left: 8px;"><i class="fa fa-key mr-1"></i></span>';
            $btn .= '|'.'<span data-placement="right" class="btn btn-sm bg-success-light mr-2" onclick="resetPass(this,'.$row->userId.')" style="margin-left: 8px;">Reset</span>';

            if($row->userType==1) {
                $type='User';
            } elseif($row->userType==2) {
                $type='Organizer';
            }

            if($row->email_verified=="1"){
                $email_verified='<div class="status-toggle">
                <input id="rating1_\''.$row->userId.'\'" class="check" type="checkbox" checked onClick="email_verified('.$row->userId.');">
                <label for="rating1_\''.$row->userId.'\'" class="checktoggle">checkbox</label>
                </div>';
            } else {
                $email_verified='<div class="status-toggle">
                <input id="rating1_\''.$row->userId.'\'" class="check" type="checkbox" onClick="email_verified('.$row->userId.');">
                <label for="rating1_\''.$row->userId.'\'" class="checktoggle">checkbox</label>
                </div>';
            }

            if($row->status=="1"){
                $status='<div class="status-toggle">
                <input id="rating_\''.$row->userId.'\'" class="check" type="checkbox" checked onClick="status('.$row->userId.');">
                <label for="rating_\''.$row->userId.'\'" class="checktoggle">checkbox</label>
                </div>';
            } else {
                $status='<div class="status-toggle">
                <input id="rating_\''.$row->userId.'\'" class="check" type="checkbox" onClick="status('.$row->userId.');">
                <label for="rating_\''.$row->userId.'\'" class="checktoggle">checkbox</label>
                </div>';
            }

            if(!empty($row->firstname)){
                $name = $row->firstname.' '.$row->lastname;
            } else {
                $name = $row->organizername;
            }
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $type;
            $nestedData[] = $name;
            $nestedData[] = $row->email;
            $nestedData[] = date('d-m-Y',strtotime($row->created));
            $nestedData[] = $email_verified."<input type='hidden' id='email_verified".$row->userId."' value='".$row->email_verified."' />";
            $nestedData[] = $status."<input type='hidden' id='status".$row->userId."' value='".$row->status."' />";
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Users_model->count_all(),
            "recordsFiltered" => $this->Users_model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function view($id) {
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

    public function change_status() {
        if($_POST['status']=='1') {
            $statuss='0';
        } else if($_POST['status']=='0'){
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
            $this->Crud_model->DeleteData('all_podcasts',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('all_prayers',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('all_videos',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('proceed_to_pay',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('user_add_card',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('user_address',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('user_comment_dislike',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('user_comment_like',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('user_joined_event',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('user_liked_event',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('user_post_comment',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('user_post_comment_reply',"user_id='".$_POST['cid']."'");
            $this->Crud_model->DeleteData('user_post_like',"user_id='".$_POST['cid']."'");
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
