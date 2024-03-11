<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('mymodel');
		$this->load->library('form_validation');
	}

	public function index() {
		$data = array(
			'email_id' =>"email_id",
			'password'=>"password",
		);
		$this->load->view('admin/login',$data);
	}

	public function actionLogin() {
		$this->rules_login();
		if ($this->form_validation->run() == FALSE) {
			redirect();
		} else {
			$cond = "email='".$_POST['email_id']."' and password='".md5($_POST['password'])."'";
			$checkLoginUser = $this->Crud_model->get_single("admin",$cond);
			if(!empty($checkLoginUser)) {
				$sess['afrebay_admin'] =array(
					"id"=>$checkLoginUser->userId,
					"name"=>$checkLoginUser->name,
					"email_id"=>$checkLoginUser->email,
					"status"=>$checkLoginUser->status,
				);
				$this->session->set_userdata($sess);
				$this->session->set_flashdata('message', 'Successfully logged in.');
				redirect(admin_url('dashboard'));
			} else {
				$this->session->set_flashdata('message', 'Incorrect email address and password.');
				redirect(admin_url());
			}
		}
	}

	public function rules_login() {
		$this->form_validation->set_rules('email_id', 'Email id', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
	}

	public function dashboard() {
		$total_event=$this->Crud_model->GetData('all_prayers');
		$total_user=$this->Crud_model->GetData('users');
		$total_podcast=$this->Crud_model->GetData('all_podcasts');
		$total_videos=$this->Crud_model->GetData('all_videos');
		$header = array('title' => 'Dashboard');
		$data = array(
            'heading' => 'Dashboard',
            'total_event' => $total_event,
            'total_user' => $total_user,
            'total_podcast' => $total_podcast,
            'total_videos' => $total_videos,
        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/dashboard',$data);
        $this->load->view('admin/footer');
	}

	public function logOut() {
		unset($_SESSION['afrebay_admin']);
		redirect(admin_url());
	}

	function profile() {
		$get_admin=$this->Crud_model->get_single('admin',"userId ='".$_SESSION['afrebay_admin']['id']."'");
		$header = array('title' => 'profile');
		$data = array(
			'heading' => 'Profile',
            'get_admin' =>$get_admin,

        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/profile',$data);
        $this->load->view('admin/footer');
	}

	function update_profile() {
		if($_FILES['profile']['name']!='' ) {
			$_POST['profile']= rand(0000,9999)."_".$_FILES['profile']['name'];
			$config2['image_library'] = 'gd2';
			$config2['source_image'] =  $_FILES['profile']['tmp_name'];
			$config2['new_image'] =   getcwd().'/uploads/profile/'.$_POST['profile'];
			$config2['upload_path'] =  getcwd().'/uploads/profile/';
			$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
			$config2['maintain_ratio'] = FALSE;
			$this->image_lib->initialize($config2);
			if(!$this->image_lib->resize()) {
			  echo('<pre>');
			  echo ($this->image_lib->display_errors());
			  exit;
			} else {
			$image  = $_POST['profile'];
				@unlink('uploads/profile/'.$_POST['old_image']);
			}
        } else {
            $image  = $_POST['old_image'];
        }

        $data = array(
			'profile'=> $image
		);
       	$this->Crud_model->SaveData('admin',$data,"userId='".$_POST['id']."'");
        $this->session->set_flashdata('message', 'Profile updated successfully.');
        redirect(admin_url('profile'));
	}

	function change_password() {
		$get_user=$this->Crud_model->get_single('admin',"userId='".$_SESSION['afrebay_admin']['id']."'");
	    if($get_user->password==md5($_POST['cur_password'])) {
			$data=array(
				'password'=>md5($_POST['new_password'])
			);
			$this->Crud_model->SaveData('admin',$data,"userId='".$_SESSION['afrebay_admin']['id']."'");
			$this->session->set_flashdata('message', 'Password reset successfully.');
			echo "1";
	    } else {
	    	echo "0";
	    }
	}
}
