<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . '/libraries/REST_Controller.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User_dashboard extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Mymodel');
		$this->load->model('Users_model');
    }

    public function profile_settings() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$userid = $formdata['user_id'];
			//$user_info = $this->Crud_model->get_single('users', "userId='".$userid."'");
			$user_info = $this->db->query("SELECT `userId`, `organizername`, `firstname`, `lastname`, `short_bio`, `mobile`, `gender`, `email`, `address`, `userType`, `latitude`, `longitude`, `profilePic` FROM users WHERE `userId` = '".$userid."'")->result_array();
			if(!empty($user_info[0]['profilePic'])){
				$user_info[0]['profilePic'] = base_url().'uploads/users/'.$user_info[0]['profilePic'];
			} else {
				$user_info[0]['profilePic'] = base_url().'uploads/no_image.png';
			}
			$data['userinfo'] = $user_info;
			$response = array('status'=> 'success', 'result'=> $data);
		} catch(\Exception $e) {
			$response = array('status'=> 'error','result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function update_profile() {
		try {
			/*if ($_FILES['profilePic']['name'] != '') {
				$_POST['profilePic'] = rand(0000, 9999) . "_" . $_FILES['profilePic']['name'];
				$config2['image_library'] = 'gd2';
				$config2['source_image'] =  $_FILES['profilePic']['tmp_name'];
				$config2['new_image'] =   getcwd() . '/uploads/users/' . $_POST['profilePic'];
				$config2['upload_path'] =  getcwd() . '/uploads/users/';
				$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
				$config2['maintain_ratio'] = FALSE;
				$this->image_lib->initialize($config2);
				if (!$this->image_lib->resize()) {
					echo ('<pre>');
					echo ($this->image_lib->display_errors());
					exit;
				} else {
					$image  = $_POST['profilePic'];
					@unlink('uploads/users/' . $_POST['old_image']);
				}
			} else {
				$image  = $_POST['old_image'];
			}*/
			$formdata = json_decode(file_get_contents('php://input'), true);
			$updateProfile = $this->db->query("UPDATE users SET organizername = '".$formdata['organizername']."', firstname = '".$formdata['firstname']."', lastname = '".$formdata['lastname']."', mobile = '".$formdata['mobile']."', gender = '".$formdata['gender']."', address = '".$formdata['address']."', latitude = '".$formdata['latitude']."', longitude = '".$formdata['longitude']."', short_bio = '".$formdata['short_bio']."' WHERE userId = '".$formdata['user_id']."'");
			if($updateProfile > 0){
				$response = array('status'=> 'success','result'=> 'Profile updated successfully');
			} else {
				$response = array('status'=> 'error','result'=> 'Oops, Something went wrong please try again later');
			}
		} catch(\Exception $e) {
			$response = array('status'=> 'error','result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function updateProfilePics() {
		try {
			if ($_FILES['profilePic']['name'] != '') {
				$_POST['profilePic'] = rand(0000, 9999) . "_" . $_FILES['profilePic']['name'];
				$config2['image_library'] = 'gd2';
				$config2['source_image'] =  $_FILES['profilePic']['tmp_name'];
				$config2['new_image'] =   getcwd() . '/uploads/users/' . $_POST['profilePic'];
				$config2['upload_path'] =  getcwd() . '/uploads/users/';
				$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
				$config2['maintain_ratio'] = FALSE;
				$this->image_lib->initialize($config2);
				if (!$this->image_lib->resize()) {
					echo ('<pre>');
					echo ($this->image_lib->display_errors());
					exit;
				} else {
					$image = $_POST['profilePic'];
					@unlink('uploads/users/' . $_POST['old_image']);
				}
			} else {
				$image = $_POST['old_image'];
			}
			$updateProfilePic = $this->db->query("UPDATE users SET profilePic = '".$image."' WHERE userId = '".$_POST['userId']."'");
			if($updateProfilePic > 0){
				$response = array('status'=> 'success','result'=> 'Profile Picture updated successfully');
			} else {
				$response = array('status'=> 'error','result'=> 'Oops, Something went wrong please try again later');
			}
		} catch(\Exception $e) {
			$response = array('status'=> 'error','result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	//prayer API Start
    public function add_prayer() {
		try{
			if(!empty($this->input->post())) {
				$get_data=$this->Crud_model->get_single('all_prayers',"prayer_name = '".$_POST['prayer_name']."'");
				if(isset($_FILES['prayer_image']['name']) !='') {
		            $_POST['prayer_image']= rand(0000,9999)."_".$_FILES['prayer_image']['name'];
		            $config2['image_library'] = 'gd2';
		            $config2['source_image'] =  $_FILES['prayer_image']['tmp_name'];
		            $config2['new_image'] =   getcwd().'/uploads/prayer/'.$_POST['prayer_image'];
		            $config2['upload_path'] =  getcwd().'/uploads/prayer/';
		            $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
		            $config2['maintain_ratio'] = FALSE;
		            $this->image_lib->initialize($config2);
		            if(!$this->image_lib->resize()) {
		                $response = array('status'=> 'error', 'result'=> "Something went wrong while uploding image. Please try again later!");
		            } else {
		                $image  = $_POST['prayer_image'];
		            }
		        } else {
		            $image  = "";
		        }
		        if(empty($get_data)) {
					$data = array(
						'user_id' => $this->input->post('user_id'),
						'prayer_image'=>$image,
						'prayer_name' => $this->input->post('prayer_name'),
						'prayer_subheading' => $this->input->post('prayer_subheading'),
						'prayer_description' => $this->input->post('prayer_description'),
						'prayer_datetime' => $this->input->post('prayer_datetime'),
						'prayer_location' => $this->input->post('prayer_location'),
						'created_date' => date("Y-m-d H:i:s"),
					);
					$this->Crud_model->SaveData('all_prayers', $data);
					$response = array('status'=> 'success', 'result'=> "Prayer created successfully");
				} else {
					$response = array('status'=> 'error', 'result'=> "Prayer Title Already Exists.");
		        }
		    }
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function edit_prayer() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$prayer_id = $formdata['prayer_id'];
			$prayer_list = $this->db->query("SELECT * FROM all_prayers WHERE id = '".$prayer_id."'")->result_array();
			if(!empty($prayer_list)) {
				$prayerList = array();
				foreach ($prayer_list as $key => $value) {
					$prayer_datetime = date('Y-m-d h:i A', strtotime($value['prayer_datetime']));
					$prayer_datetime = date_create($prayer_datetime);
					$prayerList[$key]['id'] = $value['id'];
					$prayerList[$key]['prayer_image'] = base_url().'uploads/prayer/'.$value['prayer_image'];
					$prayerList[$key]['prayer_name'] = $value['prayer_name'];
					$prayerList[$key]['prayer_subheading'] = $value['prayer_subheading'];
					$prayerList[$key]['prayer_description'] = $value['prayer_description'];
					$prayerList[$key]['prayer_location'] = $value['prayer_location'];
					$prayerList[$key]['prayer_datetime'] = date_format($prayer_datetime,"l dS F Y, h:i A");
				}
				$response = array('status'=> 'success', 'result'=> $prayerList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

    public function update_prayer() {
    	try {
    		if(isset($_FILES['prayer_image']['name']) !='') {
	            $_POST['prayer_image']= rand(0000,9999)."_".$_FILES['prayer_image']['name'];
	            $config2['image_library'] = 'gd2';
	            $config2['source_image'] =  $_FILES['prayer_image']['tmp_name'];
	            $config2['new_image'] =   getcwd().'/uploads/prayer/'.$_POST['prayer_image'];
	            $config2['upload_path'] =  getcwd().'/uploads/prayer/';
	            $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
	            $config2['maintain_ratio'] = FALSE;
				$this->image_lib->initialize($config2);
	            if(!$this->image_lib->resize()) {
	                $response = array('status'=> 'error', 'result'=> "Something went wrong while uploding image. Please try again later!");
	            } else {
	                $image  = $_POST['prayer_image'];
	                @unlink('uploads/prayer/'.$_POST['old_image']);
	            }
	        } else {
	            $image  = @$_POST['old_image'];
	        }
	        $get_data=$this->Crud_model->get_single_record('all_prayers',"prayer_name = '".$_POST['prayer_name']."' and id != '".$this->input->post('prayer_id')."'");
	        if(empty($get_data)) {
	            $data = array(
	            	'prayer_image'=>$image,
	                'prayer_name' => $this->input->post('prayer_name'),
	                'prayer_subheading' => $this->input->post('prayer_subheading'),
					'prayer_description' => $this->input->post('prayer_description'),
					'prayer_location' => $this->input->post('prayer_location'),
					'prayer_datetime' => $this->input->post('prayer_datetime'),
	                'updated_date'=> date('Y-m-d H:i:s'),

	            );
	            $this->Crud_model->SaveData('all_prayers',$data,"id = '".$this->input->post('prayer_id')."'");
	            $response = array('status'=> 'success', 'result'=> "Prayer updated successfully.");
	        } else {
	        	$response = array('status'=> 'error', 'result'=> "Something went wrong while uploding image. Please try again later!");
	        }
    	} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
    }

    public function prayerListByEachOrganizer() {
    	try {
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$user_id = $formdata['user_id'];
			$prayer_list = $this->Crud_model->GetData('all_prayers', '', "user_id = '".$user_id."' AND status = 1 and is_delete = 1");
			if(!empty($prayer_list)) {
				$prayerList = array();
				foreach ($prayer_list as $key => $value) {
					$prayer_datetime = date('Y-m-d h:i A', strtotime($value->prayer_datetime));
					$prayer_datetime = date_create($prayer_datetime);
					$prayerList[$key]['id'] = $value->id;
					$prayerList[$key]['prayer_name'] = $value->prayer_name;
					$prayerList[$key]['prayer_location'] = $value->prayer_location;
					//$prayerList[$key]['prayer_subheading'] = $value->prayer_subheading;
					//$prayerList[$key]['prayer_description'] = $value->prayer_description;
					$prayerList[$key]['prayer_image'] = base_url().'uploads/prayer/'.$value->prayer_image;
					$prayerList[$key]['prayer_datetime'] = date_format($prayer_datetime,"l dS F Y, h:i A");
					$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
				}
				$response = array('status'=> 'success', 'result'=> $prayerList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
    	} catch(\Exception $e) {
    		$response = array('status'=> 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

    public function prayer_details() {
    	try {
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$prayer_id = $formdata['prayer_id'];
			$prayer_details = $this->Crud_model->GetData('all_prayers', '', "id = '".$prayer_id."'");
			//print_r($prayer_details); die();
			if(!empty($prayer_details)) {
				$prayerDetails = array();
				foreach ($prayer_details as $key => $value) {
					$prayer_datetime = date('Y-m-d h:i A', strtotime($value->prayer_datetime));
					$prayer_datetime = date_create($prayer_datetime);
					$prayerDetails[$key]['id'] = $value->id;
					$prayerDetails[$key]['prayer_name'] = $value->prayer_name;
					$prayerDetails[$key]['prayer_subheading'] = $value->prayer_subheading;
					$prayerDetails[$key]['prayer_description'] = $value->prayer_description;
					$prayerDetails[$key]['prayer_location'] = $value->prayer_location;
					$prayerDetails[$key]['prayer_image'] = base_url().'uploads/prayer/'.$value->prayer_image;
					$prayerDetails[$key]['prayer_datetime'] = date_format($prayer_datetime,"l dS F Y, h:i A");
					$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerDetails[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
					$likedUser = $this->db->query("SELECT count(id) as total FROM user_liked_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerDetails[$key]['likedUser'] = $likedUser[0]['total'];
					$prayerDetails[$key]['jointheprayer'] = $joinedUser[0]['total']." Join ".$likedUser[0]['total']." Interest ";
				}
				$response = array('status'=> 'success', 'result'=> $prayerDetails);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
    	} catch(\Exception $e) {
    		$response = array('status'=> 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

    public function userJoinedEvent() {
    	try{
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$user_id = $formdata['user_id'];
    		$event_id = $formdata['event_id'];
    		$data = array(
    			'user_id' => $formdata['user_id'],
    			'event_id' => $formdata['event_id']
    		);
    		$this->db->insert('user_joined_event',$data);
    		$response = array('status'=> 'success', 'result'=> "Joined this event");
    	} catch(\Exception $e) {
    		$response = array('status' => 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

    public function userlikedEvent() {
    	try{
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$user_id = $formdata['user_id'];
    		$event_id = $formdata['event_id'];
    		$data = array(
    			'user_id' => $formdata['user_id'],
    			'event_id' => $formdata['event_id']
    		);
    		$this->db->insert('user_liked_event',$data);
    		$response = array('status'=> 'success', 'result'=> "Liked this event");
    	} catch(\Exception $e) {
    		$response = array('status' => 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

	public function ListofupcomingPrayers() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$selectedDate = $formdata['selected_date'];
			$datetime1 = new DateTime();
			if(!empty($selectedDate)) {
				$upcoming_events = $this->db->query("SELECT all_prayers.id, users.organizername, all_prayers.prayer_name, all_prayers.prayer_description, all_prayers.prayer_image, all_prayers.prayer_subheading, all_prayers.prayer_datetime, all_prayers.prayer_location FROM all_prayers JOIN users ON all_prayers.user_id = users.userId WHERE all_prayers.prayer_datetime LIKE '%".$selectedDate."%' AND all_prayers.status = '1' AND all_prayers.is_delete = '1'")->result_array();
			} else {
				$todaysDate = date('Y-m-d');
				$upcoming_events = $this->db->query("SELECT all_prayers.id, users.organizername, all_prayers.prayer_name, all_prayers.prayer_description, all_prayers.prayer_image, all_prayers.prayer_subheading, all_prayers.prayer_datetime, all_prayers.prayer_location FROM all_prayers JOIN users ON all_prayers.user_id = users.userId WHERE all_prayers.prayer_datetime > '".$todaysDate."' AND all_prayers.status = '1' AND all_prayers.is_delete = '1'")->result_array();
			}
			if(!empty($upcoming_events)) {
				foreach ($upcoming_events as $keyue => $uevalue) {
					$uevalue['prayer_image'] = base_url().'uploads/prayer/'.$uevalue['prayer_image'];
					$uevalue['prayer_datetime'] = date('d F Y H:i', strtotime($uevalue['prayer_datetime']));
					$uevalue['countdown'] = $datetime1->diff(new DateTime(date('Y-m-d h:i a', strtotime($uevalue['prayer_datetime']))))->format('%a days, %h:%i Hour');
					$returnue[$keyue] = $uevalue;
				}
			} else {
				$returnue = "";
			}
			$data['upcoming_events'] = $returnue;
			$response = array('status'=> 'success','result'=> $data);
		} catch(\Exception $e) {
			$response = array('status' => 'error', 'result' => $e->getMessage());
		}
		echo json_encode($response);
	}

	public function ListofPrayers() {
		try {
			$prayer_list = $this->Crud_model->GetData('all_prayers', '', 'status = 1 and is_delete = 1');
			if(!empty($prayer_list)) {
				$prayerList = array();
				foreach ($prayer_list as $key => $value) {
					$prayer_datetime = date('Y-m-d h:i A', strtotime($value->prayer_datetime));
					$prayer_datetime = date_create($prayer_datetime);
					$prayerList[$key]['id'] = $value->id;
					$prayerList[$key]['prayer_name'] = $value->prayer_name;
					$prayerList[$key]['prayer_location'] = $value->prayer_location;
					//$prayerList[$key]['prayer_subheading'] = $value->prayer_subheading;
					$prayerList[$key]['prayer_description'] = $value->prayer_description;
					$prayerList[$key]['prayer_image'] = base_url().'uploads/prayer/'.$value->prayer_image;
					$prayerList[$key]['prayer_datetime'] = date_format($prayer_datetime,"l dS F Y, h:i A");
					$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
					$likedUser = $this->db->query("SELECT count(id) as total FROM user_liked_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['likedUser'] = $likedUser[0]['total'];
					$joineduserId = $this->db->query("SELECT user_id FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					if(!empty($joineduserId)) {
						foreach ($joineduserId as $key1 => $val) {
							$getuserimage = $this->db->query("SELECT profilePic FROM users WHERE userId = '".$val['user_id']."'")->result_array();
							if(!empty($getuserimage)) {
								$val['joinedUserImage'] = base_url().'uploads/users/'.$getuserimage[0]['profilePic'];
							} else {
								$val['joinedUserImage'] = base_url().'uploads/nouser.jpg';
							}
							$return[$key1] = $val;
							$joineduser = $return;
							$prayerList[$key]['joinedUserImage'] = $joineduser;
						}
					} else {
						$prayerList[$key]['joinedUserImage'] = [];
					}
				}
				$response = array('status'=> 'success', 'result'=> $prayerList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result' => $e->getMessage());
		}
		echo json_encode($response);
	}

	public function ListofnewPrayers() {
		try {
			$prayer_list = $this->Crud_model->GetData('all_prayers', '', 'status = "1" and is_delete = "1" order by `all_prayers`.`id` DESC');
			if(!empty($prayer_list)) {
				$prayerList = array();
				foreach ($prayer_list as $key => $value) {
					$prayer_datetime = date('Y-m-d h:i A', strtotime($value->prayer_datetime));
					$prayer_datetime = date_create($prayer_datetime);
					$prayerList[$key]['id'] = $value->id;
					$prayerList[$key]['prayer_name'] = $value->prayer_name;
					$prayerList[$key]['prayer_location'] = $value->prayer_location;
					//$prayerList[$key]['prayer_subheading'] = $value->prayer_subheading;
					//$prayerList[$key]['prayer_description'] = $value->prayer_description;
					$prayerList[$key]['prayer_image'] = base_url().'uploads/prayer/'.$value->prayer_image;
					$prayerList[$key]['prayer_datetime'] = date_format($prayer_datetime,"l dS F Y, h:i A");
					$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
					$likedUser = $this->db->query("SELECT count(id) as total FROM user_liked_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['likedUser'] = $likedUser[0]['total'];
					$joineduserId = $this->db->query("SELECT user_id FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					if(!empty($joineduserId)) {
						foreach ($joineduserId as $key1 => $val) {
							$getuserimage = $this->db->query("SELECT profilePic FROM users WHERE userId = '".$val['user_id']."'")->result_array();
							$val['joinedUserImage'] = @$getuserimage[0]['profilePic'];
							$return[$key1] = $val;
							$joineduser = $return;
							$prayerList[$key]['joinedUserImage'] = $joineduser;
						}
					} else {
						$prayerList[$key]['joinedUserImage'] = [];
					}
				}
				$response = array('status'=> 'success', 'result'=> $prayerList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result' => $e->getMessage());
		}
		echo json_encode($response);
	}

	public function ListofupcomingPrayer() {
		try {
			$todaysDate = date('Y-m-d');
			$prayer_list = $this->Crud_model->GetData('all_prayers', '', 'all_prayers.prayer_datetime > "'.$todaysDate.'" AND status = "1" and is_delete = "1"');
			if(!empty($prayer_list)) {
				$prayerList = array();
				foreach ($prayer_list as $key => $value) {
					$prayer_datetime = date('Y-m-d h:i A', strtotime($value->prayer_datetime));
					$prayer_datetime = date_create($prayer_datetime);
					$prayerList[$key]['id'] = $value->id;
					$prayerList[$key]['prayer_name'] = $value->prayer_name;
					$prayerList[$key]['prayer_location'] = $value->prayer_location;
					//$prayerList[$key]['prayer_subheading'] = $value->prayer_subheading;
					//$prayerList[$key]['prayer_description'] = $value->prayer_description;
					$prayerList[$key]['prayer_image'] = base_url().'uploads/prayer/'.$value->prayer_image;
					$prayerList[$key]['prayer_datetime'] = date_format($prayer_datetime,"l dS F Y, h:i A");
					$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
					$likedUser = $this->db->query("SELECT count(id) as total FROM user_liked_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['likedUser'] = $likedUser[0]['total'];
					$joineduserId = $this->db->query("SELECT user_id FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					if(!empty($joineduserId)) {
						foreach ($joineduserId as $key1 => $val) {
							$getuserimage = $this->db->query("SELECT profilePic FROM users WHERE userId = '".$val['user_id']."'")->result_array();
							$val['joinedUserImage'] = $getuserimage[0]['profilePic'];
							$return[$key1] = $val;
							$joineduser = $return;
							$prayerList[$key]['joinedUserImage'] = $joineduser;
						}
					} else {
						$prayerList[$key]['joinedUserImage'] = [];
					}
				}
				$response = array('status'=> 'success', 'result'=> $prayerList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result' => $e->getMessage());
		}
		echo json_encode($response);
	}
    //Prayer API End

    //Podcast API Start
    public function add_podcast() {
		try{
			if(!empty($this->input->post())) {
				$get_data=$this->Crud_model->get_single('all_podcasts',"podcast_name = '".$_POST['podcast_name']."'");
				if(empty($get_data)) {
					if ($_FILES['cover_image']['name'] != '') {
	                    $_POST['cover_image']= rand(0000,9999)."_".$_FILES['cover_image']['name'];
	                    $config2['image_library'] = 'gd2';
	                    $config2['source_image'] =  $_FILES['cover_image']['tmp_name'];
	                    $config2['new_image'] =   getcwd().'/uploads/podcast/cover_image/'.$_POST['cover_image'];
	                    $config2['upload_path'] =  getcwd().'/uploads/podcast/cover_image/';
	                    $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
	                    $config2['maintain_ratio'] = FALSE;
	                    $this->image_lib->initialize($config2);
	                    if(!$this->image_lib->resize()) {
	                        echo('<pre>');
	                        echo ($this->image_lib->display_errors());
	                        exit;
	                    } else {
	                        $file = $_POST['cover_image'];
	                    }
	                } else {
	                    $file = $_POST['old_image'];
	                }

	                if ($_FILES['podcast_file']['name'] != '') {
	                    $src = $_FILES['podcast_file']['tmp_name'];
	                    $filEnc = time();
	                    $avatar = rand(0000, 9999) . "_" . $_FILES['podcast_file']['name'];
	                    $avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
	                    $dest = getcwd() . '/uploads/podcast/podcast_file/' . $avatar1;
	                    if (move_uploaded_file($src, $dest)) {
	                        $podcast_file  = $avatar1;
	                        @unlink('uploads/podcast/podcast_file/' . $_POST['old_podcast_file']);
	                    }
	                } else {
	                    $podcast_file  = $_POST['old_file'];
	                }

	                $data = array(
	                    'user_id' => $this->input->post('user_id'),
	                    //'podcast_cat_id' =>$_POST['podcast_cat_id'],
	                    'podcast_name'=> $_POST['podcast_name'],
	                    'podcast_description'=> $_POST['podcast_description'],
	                    'podcast_singer_name'=> $_POST['podcast_singer_name'],
	                    'podcast_cover_image'=> $file,
	                    'podcast_file'=> $podcast_file,
	                    'created_date'=> date('Y-m-d H:i:s')
	                );
	                $this->Crud_model->SaveData('all_podcasts', $data);
					$response = array('status'=> 'success', 'result'=> "Podcast created successfully");
		        } else {
					$response = array('status'=> 'error', 'result'=> "Podcast Already Exists.");
		        }
		    }
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function edit_podcast() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$podcast_id = $formdata['podcast_id'];
			$podcast_list = $this->db->query("SELECT * FROM all_podcasts WHERE id = '".$podcast_id."' AND status = '1' AND is_delete = '1'")->result_array();
			if(!empty($podcast_list)) {
				$podcastList = array();
				foreach ($podcast_list as $key => $value) {
					$podcastList[$key]['id'] = $value['id'];
					$podcastList[$key]['podcast_cover_image'] = base_url().'uploads/podcast/cover_image/'.$value['podcast_cover_image'];
					$podcastList[$key]['podcast_file'] = base_url().'uploads/podcast/podcast_file/'.$value['podcast_file'];
					$podcastList[$key]['podcast_name'] = $value['podcast_name'];
					$podcastList[$key]['podcast_singer_name'] = $value['podcast_singer_name'];
					$podcastList[$key]['podcast_description'] = $value['podcast_description'];
				}
				$response = array('status'=> 'success', 'result'=> $podcastList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

    public function update_podcast() {
    	try {
    		if ($_FILES['cover_image']['name'] != '') {
                $_POST['cover_image']= rand(0000,9999)."_".$_FILES['cover_image']['name'];
                $config2['image_library'] = 'gd2';
                $config2['source_image'] =  $_FILES['cover_image']['tmp_name'];
                $config2['new_image'] =   getcwd().'/uploads/podcast/cover_image/'.$_POST['cover_image'];
                $config2['upload_path'] =  getcwd().'/uploads/podcast/cover_image/';
                $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
                $config2['maintain_ratio'] = FALSE;
                $this->image_lib->initialize($config2);
                if(!$this->image_lib->resize()) {
                    echo('<pre>');
                    echo ($this->image_lib->display_errors());
                    exit;
                } else {
                    $file = $_POST['cover_image'];
                }
            } else {
                $file = $_POST['old_image'];
            }

            if ($_FILES['podcast_file']['name'] != '') {
                $src = $_FILES['podcast_file']['tmp_name'];
                $filEnc = time();
                $avatar = rand(0000, 9999) . "_" . $_FILES['podcast_file']['name'];
                $avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
                $dest = getcwd() . '/uploads/podcast/podcast_file/' . $avatar1;
                if (move_uploaded_file($src, $dest)) {
                    $podcast_file  = $avatar1;
                    @unlink('uploads/podcast/podcast_file/' . $_POST['old_podcast_file']);
                }
            } else {
                $podcast_file  = $_POST['old_file'];
            }

	        $get_data=$this->Crud_model->get_single_record('all_podcasts',"podcast_name = '".$_POST['podcast_name']."' and id != '".$_POST['podcast_id']."'");
	        if(empty($get_data)) {
	            $data = array(
	            	'podcast_cover_image'=> $file,
	                'podcast_file'=> $podcast_file,
	                'podcast_name'=> $_POST['podcast_name'],
					'podcast_description'=> $_POST['podcast_description'],
					'podcast_singer_name'=> $_POST['podcast_singer_name'],
	                'updated_date'=> date('Y-m-d H:i:s')
	            );
	            $this->Crud_model->SaveData('all_podcasts',$data,"id = '".$_POST['podcast_id']."'");
	            $response = array('status'=> 'success', 'result'=> "Podcast updated successfully.");
	        } else {
	        	//$response = array('status'=> 'error', 'result'=> "Something went wrong while uploding image. Please try again later!");
	        	$response = array('status'=> 'error', 'result'=> "Podcast Already Exists.");
	        }
    	} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
    }

    public function podcastListByEachOrganizer() {
    	try {
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$user_id = $formdata['user_id'];
			$podcast_list = $this->Crud_model->GetData('all_podcasts', '', "user_id = '".$user_id."' AND status = 1 and is_delete = 1");
			if(!empty($podcast_list)) {
				$podcastList = array();
				foreach ($podcast_list as $key => $value) {
					$podcastList[$key]['id'] = $value->id;
					$podcastList[$key]['podcast_name'] = $value->podcast_name;
					$podcastList[$key]['podcast_cover_image'] = base_url().'uploads/podcast/cover_image/'.$value->podcast_cover_image;
					$podcastList[$key]['podcast_file'] = base_url().'uploads/podcast/podcast_file/'.$value->podcast_file;
					$podcastList[$key]['podcast_singer_name'] = $value->podcast_singer_name;
					//$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					//$podcastList[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
				}
				$response = array('status'=> 'success', 'result'=> $podcastList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
    	} catch(\Exception $e) {
    		$response = array('status'=> 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

	public function ListofPodcast() {
		try {
			$podcast_list = $this->Crud_model->GetData('all_podcasts', '', 'status = 1 and is_delete = 1');
			if(!empty($podcast_list)) {
				$podcastList = array();
				foreach ($podcast_list as $key => $value) {
					$podcastList['list'][$key]['id'] = $value->id;
					$podcastList['list'][$key]['podcast_name'] = $value->podcast_name;
					$podcastList['list'][$key]['podcast_cover_image'] = base_url().'uploads/podcast/cover_image/'.$value->podcast_cover_image;
					$podcastList['list'][$key]['podcast_file'] = base_url().'uploads/podcast/podcast_file/'.$value->podcast_file;
					$podcastList['list'][$key]['podcast_singer_name'] = $value->podcast_singer_name;
					$podcastList['list'][$key]['podcast_singer_image'] = base_url().'uploads/podcast/singer_image/'.$value->podcast_singer_image;
					//$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					//$podcastList[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
					$likedPodcast = $this->db->query("SELECT all_podcasts.podcast_cover_image FROM all_podcasts JOIN user_liked_podcast ON all_podcasts.id = user_liked_podcast.podcast_id WHERE all_podcasts.status = 1 AND all_podcasts.is_delete = 1")->result_array();
					//$podcastList['listofliked'] = $likedPodcast;
					foreach ($likedPodcast as $key1 => $value1) {
						$podcastList['listofliked'][$key1]['podcast_cover_image'] = base_url().'uploads/podcast/cover_image/'.$value1['podcast_cover_image'];
					}
				}
				$response = array('status'=> 'success', 'result'=> $podcastList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status'=> 'error', 'result' => $th->getMessage());
		}
		echo json_encode($response);
	}

    public function podcast_details() {
    	try {
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$podcast_id = $formdata['podcast_id'];
    		$user_id = $formdata['user_id'];
			$podcast_details = $this->Crud_model->GetData('all_podcasts', '', "id = '".$podcast_id."'");
			if(!empty($podcast_details)) {
				$podcastDetails = array();
				foreach ($podcast_details as $key => $value) {
					$podcastDetails[$key]['id'] = $value->id;
					$podcastDetails[$key]['podcast_cover_image'] = base_url().'uploads/podcast/cover_image/'.$value->podcast_cover_image;
					$podcastDetails[$key]['podcast_file'] = base_url().'uploads/podcast/podcast_file/'.$value->podcast_file;
					$podcastDetails[$key]['podcast_name'] = $value->podcast_name;
					$podcastDetails[$key]['podcast_description'] = $value->podcast_description;
					$podcastDetails[$key]['podcast_singer_name'] = $value->podcast_singer_name;
					$isLiked = $this->db->query("SELECT * FROM user_liked_podcast WHERE podcast_id = '".$value->id."' AND '".$user_id."'")->row();
					if(!empty($isLiked)) {
						$podcastDetails[$key]['isliked'] = '1';
					} else {
						$podcastDetails[$key]['isliked'] = '0';
					}
				}
				$response = array('status'=> 'success', 'result'=> $podcastDetails);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
    	} catch(\Exception $e) {
    		$response = array('status'=> 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }
    //Podcast API End

    //Video API Start
    public function add_video() {
		try{
			if(!empty($this->input->post())) {
				$get_data=$this->Crud_model->get_single('all_videos',"videos_name = '".$_POST['video_name']."' AND status = '1' AND is_delete = '1'");
				if(empty($get_data)) {
					if ($_FILES['cover_image']['name'] != '') {
	                    $_POST['cover_image']= rand(0000,9999)."_".$_FILES['cover_image']['name'];
	                    $config2['image_library'] = 'gd2';
	                    $config2['source_image'] =  $_FILES['cover_image']['tmp_name'];
	                    $config2['new_image'] =   getcwd().'/uploads/videos/cover_image/'.$_POST['cover_image'];
	                    $config2['upload_path'] =  getcwd().'/uploads/videos/cover_image/';
	                    $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
	                    $config2['maintain_ratio'] = FALSE;
	                    $this->image_lib->initialize($config2);
	                    if(!$this->image_lib->resize()) {
	                        echo('<pre>');
	                        echo ($this->image_lib->display_errors());
	                        exit;
	                    } else {
	                        $file = $_POST['cover_image'];
	                    }
	                } else {
	                    $file = $_POST['old_image'];
	                }

	                if ($_FILES['video_file']['name'] != '') {
	                    $src = $_FILES['video_file']['tmp_name'];
	                    $filEnc = time();
	                    $avatar = rand(0000, 9999) . "_" . $_FILES['video_file']['name'];
	                    $avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
	                    $dest = getcwd() . '/uploads/videos/videos_file/' . $avatar1;
	                    if (move_uploaded_file($src, $dest)) {
	                        $video_file  = $avatar1;
	                        @unlink('uploads/videos/videos_file/' . $_POST['old_video_file']);
	                    }
	                } else {
	                    $video_file = $_POST['old_file'];
	                }

	                $data = array(
	                    'user_id' => $this->input->post('user_id'),
	                    'video_cover_image'=> $file,
	                    'videos_file'=> $video_file,
	                    'videos_name'=> $_POST['video_name'],
	                    'videos_description'=> $_POST['video_description'],
	                    'created_date'=> date('Y-m-d H:i:s')
	                );
	                $this->Crud_model->SaveData('all_videos', $data);
					$response = array('status'=> 'success', 'result'=> "Video created successfully");
		        } else {
					$response = array('status'=> 'error', 'result'=> "Video Already Exists.");
		        }
		    }
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function edit_video() {
		try{
			$formdata = json_decode(file_get_contents('php://input'), true);
			$video_id = $formdata['video_id'];
			$video_list = $this->db->query("SELECT * FROM all_videos WHERE id = '".$video_id."' AND status = '1' AND is_delete = '1'")->result_array();
			if(!empty($video_list)) {
				$videoList = array();
				foreach ($video_list as $key => $value) {
					$videoList[$key]['id'] = $value['id'];
					$videoList[$key]['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$value['video_cover_image'];
					$videoList[$key]['videos_file'] = base_url().'uploads/videos/videos_file/'.$value['videos_file'];
					$videoList[$key]['videos_name'] = $value['videos_name'];
					$videoList[$key]['videos_description'] = $value['videos_description'];
				}
				$response = array('status'=> 'success', 'result'=> $videoList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

    public function update_video() {
    	try {
    		if ($_FILES['cover_image']['name'] != '') {
                $_POST['cover_image']= rand(0000,9999)."_".$_FILES['cover_image']['name'];
                $config2['image_library'] = 'gd2';
                $config2['source_image'] =  $_FILES['cover_image']['tmp_name'];
                $config2['new_image'] =   getcwd().'/uploads/videos/cover_image/'.$_POST['cover_image'];
                $config2['upload_path'] =  getcwd().'/uploads/videos/cover_image/';
                $config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
                $config2['maintain_ratio'] = FALSE;
                $this->image_lib->initialize($config2);
                if(!$this->image_lib->resize()) {
                    echo('<pre>');
                    echo ($this->image_lib->display_errors());
                    exit;
                } else {
                    $file = $_POST['cover_image'];
                }
            } else {
                $file = $_POST['old_image'];
            }

            if ($_FILES['video_file']['name'] != '') {
                $src = $_FILES['video_file']['tmp_name'];
                $filEnc = time();
                $avatar = rand(0000, 9999) . "_" . $_FILES['video_file']['name'];
                $avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
                $dest = getcwd() . '/uploads/videos/videos_file/' . $avatar1;
                if (move_uploaded_file($src, $dest)) {
                    $video_file  = $avatar1;
                    @unlink('uploads/videos/videos_file/' . $_POST['old_video_file']);
                }
            } else {
                $video_file  = $_POST['old_file'];
            }

	        $get_data=$this->Crud_model->get_single_record('all_videos',"videos_name = '".$_POST['video_name']."' and id != '".$_POST['video_id']."'");
	        if(empty($get_data)) {
	            $data = array(
	            	'video_cover_image'=> $file,
	                'videos_file'=> $video_file,
	                'videos_name'=> $_POST['video_name'],
					'videos_description'=> $_POST['video_description'],
	                'updated_date'=> date('Y-m-d H:i:s')
	            );
	            $this->Crud_model->SaveData('all_videos',$data,"id = '".$_POST['video_id']."'");
	            $response = array('status'=> 'success', 'result'=> "Video updated successfully.");
	        } else {
	        	//$response = array('status'=> 'error', 'result'=> "Something went wrong while uploding image. Please try again later!");
	        	$response = array('status'=> 'error', 'result'=> "Video Name Already Exists.");
	        }
    	} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
    }

    public function videoListByEachOrganizer() {
    	try {
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$user_id = $formdata['user_id'];
			$video_list = $this->Crud_model->GetData('all_videos', '', "user_id = '".$user_id."' AND status = 1 and is_delete = 1");
			if(!empty($video_list)) {
				$videoList = array();
				foreach ($video_list as $key => $value) {
					$videoList[$key]['id'] = $value->id;
					$videoList[$key]['videos_name'] = $value->videos_name;
					$videoList[$key]['videos_description'] = $value->videos_description;
					$videoList[$key]['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$value->video_cover_image;
					$videoList[$key]['videos_file'] = base_url().'uploads/videos/videos_file/'.$value->videos_file;
					$videoList[$key]['view_count'] = $value->view_count;
				}
				$response = array('status'=> 'success', 'result'=> $videoList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
    	} catch(\Exception $e) {
    		$response = array('status'=> 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

    public function video_details() {
    	try {
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$video_id = $formdata['video_id'];
			$video_details = $this->Crud_model->GetData('all_videos', '', "id = '".$video_id."'");
			$viewcount = @$video_details[0]->view_count+1;
			$insert_data=array('view_count'=>$viewcount);
			$this->Crud_model->SaveData('all_videos',$insert_data,"id='".$video_id."'");
			$video_details = $this->Crud_model->GetData('all_videos', '', "id = '".$video_id."'");
			if(!empty($video_details)) {
				$videoDetails = array();
				foreach ($video_details as $key => $value) {
					$videoDetails[$key]['id'] = $value->id;
					$videoDetails[$key]['user_id'] = $value->user_id;
					if(!empty($value->video_cover_image)){
						$videoDetails[$key]['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$value->video_cover_image;
					} else {
						$videoDetails[$key]['video_cover_image'] = base_url().'uploads/no_image.png';
					}

					if(!empty($value->videos_file)){
						$videoDetails[$key]['videos_file'] = base_url().'uploads/videos/videos_file/'.$value->videos_file;
					} else {
						$videoDetails[$key]['videos_file'] = base_url().'uploads/no_image.png';
					}
					$videoDetails[$key]['videos_name'] = $value->videos_name;
					$videoDetails[$key]['videos_description'] = $value->videos_description;
					$videoDetails[$key]['view_count'] = $value->view_count;
				}
				$return[$key] = $videoDetails;
			} else {
				$return = 'No data found';
			}
			$data['video_details'] = $return;

			$videoscollection = $this->db->query("SELECT all_videos.id, users.organizername, users.profilePic, all_videos.video_cover_image, all_videos.videos_name, all_videos.videos_file, all_videos.view_count FROM all_videos JOIN users ON all_videos.user_id = users.userId WHERE all_videos.status = '1' AND all_videos.is_delete = '1'")->result_array();
			if(!empty($videoscollection)) {
				foreach ($videoscollection as $keyvn => $vnvalue) {
					if(!empty($vnvalue['profilePic'])){
						$vnvalue['profilePic'] = base_url().'uploads/users/'.$vnvalue['profilePic'];
					} else {
						$vnvalue['profilePic'] = base_url().'uploads/no_image.png';
					}

					if(!empty($vnvalue['video_cover_image'])){
						$vnvalue['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$vnvalue['video_cover_image'];
					} else {
						$vnvalue['video_cover_image'] = base_url().'uploads/no_image.png';
					}

					if(!empty($vnvalue['video_cover_image'])){
						$vnvalue['videos_file'] = base_url().'uploads/videos/videos_file/'.$vnvalue['videos_file'];
					} else {
						$vnvalue['videos_file'] = base_url().'uploads/no_image.png';
					}
					
					$returnvn[$keyvn] = $vnvalue;
				}
			} else {
				$returnvn = "";
			}
			$data['video_collection'] = $returnvn;
			$response = array('status'=> 'success', 'result'=> $data);
    	} catch(\Exception $e) {
    		$response = array('status'=> 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

    public function users_video_details() {
    	try {
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$user_id = $formdata['user_id'];
    		$userDetails = $this->db->query("SELECT organizername, profilePic, short_bio FROM users WHERE userId = '".$user_id."'")->row();
    		if(!empty($userDetails->profilePic)) {
    			$userDetails->profilePic = base_url().'uploads/videos/cover_image/'.$userDetails->profilePic;
    		} else {
    			$userDetails->profilePic = base_url().'uploads/users/user.png';
    		}
    		$data['user_details'] = $userDetails;

			$video_details = $this->Crud_model->GetData('all_videos', '', "user_id = '".$user_id."' order by id DESC");
			if(!empty($video_details)) {
				$videoDetails = array();
				foreach ($video_details as $key => $value) {
					$videoDetails[$key]['id'] = $value->id;
					if(!empty($value->video_cover_image)){
						$videoDetails[$key]['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$value->video_cover_image;
					} else {
						$videoDetails[$key]['video_cover_image'] = base_url().'uploads/no_image.png';
					}

					if(!empty($value->videos_file)){
						$videoDetails[$key]['videos_file'] = base_url().'uploads/videos/videos_file/'.$value->videos_file;
					} else {
						$videoDetails[$key]['videos_file'] = base_url().'uploads/no_image.png';
					}
					$videoDetails[$key]['videos_name'] = $value->videos_name;
					$videoDetails[$key]['videos_description'] = $value->videos_description;
					$videoDetails[$key]['view_count'] = $value->view_count;
				}
				$return[$key] = $videoDetails;
			} else {
				$return = 'No data found';
			}
			$data['recent_upload'] = $return;

			$videoscollection = $this->db->query("SELECT all_videos.id, users.organizername, users.profilePic, all_videos.video_cover_image, all_videos.videos_name, all_videos.videos_file, all_videos.view_count FROM all_videos JOIN users ON all_videos.user_id = users.userId WHERE all_videos.status = '1' AND all_videos.is_delete = '1'")->result_array();
			if(!empty($videoscollection)) {
				foreach ($videoscollection as $keyvn => $vnvalue) {
					if(!empty($vnvalue['profilePic'])){
						$vnvalue['profilePic'] = base_url().'uploads/users/'.$vnvalue['profilePic'];
					} else {
						$vnvalue['profilePic'] = base_url().'uploads/no_image.png';
					}

					if(!empty($vnvalue['video_cover_image'])){
						$vnvalue['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$vnvalue['video_cover_image'];
					} else {
						$vnvalue['video_cover_image'] = base_url().'uploads/no_image.png';
					}

					if(!empty($vnvalue['video_cover_image'])){
						$vnvalue['videos_file'] = base_url().'uploads/videos/videos_file/'.$vnvalue['videos_file'];
					} else {
						$vnvalue['videos_file'] = base_url().'uploads/no_image.png';
					}
					
					$returnvn[$keyvn] = $vnvalue;
				}
			} else {
				$returnvn = "";
			}
			$data['users_video_collection'] = $returnvn;

			$response = array('status'=> 'success', 'result'=> $data);
    	} catch(\Exception $e) {
    		$response = array('status'=> 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

	public function allVideoList() {
		try {
			//$formdata = json_decode(file_get_contents('php://input'), true);
			$bannersectionVideos = $this->db->query("SELECT id, created_date, video_cover_image, videos_file, videos_name, view_count FROM all_videos order by id desc limit 1")->result_array();
			if(!empty($bannersectionVideos[0]['video_cover_image'])) {
				$bannersectionVideos[0]['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$bannersectionVideos[0]['video_cover_image'];
			} else {
				$bannersectionVideos[0]['video_cover_image'] = base_url().'uploads/no_image.png';
			}
			$bannersectionVideos[0]['videos_file'] = base_url().'uploads/videos/videos_file/'.$bannersectionVideos[0]['videos_file'];
			$bannersectionVideos[0]['created_date'] = date('Y', strtotime($bannersectionVideos[0]['created_date']));
			$data['bannerSection'] = $bannersectionVideos;
			
			$gettopweekVideos = $this->db->query("SELECT id, video_cover_image, videos_file, videos_name FROM all_videos")->result_array();
			if(!empty($gettopweekVideos)) {
				foreach ($gettopweekVideos as $keyvi => $vivalue) {
					if(!empty($vivalue['video_cover_image'])) {
						$vivalue['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$vivalue['video_cover_image'];
					} else {
						$vivalue['video_cover_image'] = base_url().'uploads/no_image.png';
					}
					$vivalue['videos_file'] = base_url().'uploads/videos/videos_file/'.$vivalue['videos_file'];
					$returnvi[$keyvi] = $vivalue;
				}
			} else {
				$returnvi = "";
			}
			$data['get_top_week_videos'] = $returnvi;

			$favVideosChnnl = $this->db->query("SELECT id, video_cover_image, videos_file, videos_name FROM all_videos")->result_array();
			if(!empty($favVideosChnnl)) {
				foreach ($gettopweekVideos as $keyvc => $vcvalue) {
					if(!empty($vcvalue['video_cover_image'])) {
						$vcvalue['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$vcvalue['video_cover_image'];
					} else {
						$vcvalue['video_cover_image'] = base_url().'uploads/no_image.png';
					}
					$vcvalue['videos_file'] = base_url().'uploads/videos/videos_file/'.$vcvalue['videos_file'];
					$returnvc[$keyvc] = $vcvalue;
				}
			} else {
				$returnvc = "";
			}
			$data['favorite_video_channel'] = $returnvc;

			$videoscollection = $this->db->query("SELECT all_videos.id, users.organizername, users.profilePic, all_videos.video_cover_image, all_videos.videos_name, all_videos.videos_file, all_videos.view_count FROM all_videos JOIN users ON all_videos.user_id = users.userId WHERE all_videos.status = '1' AND all_videos.is_delete = '1'")->result_array();
			if(!empty($videoscollection)) {
				foreach ($videoscollection as $keyvn => $vnvalue) {
					if(!empty($vnvalue['video_cover_image'])) {
						$vnvalue['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$vnvalue['video_cover_image'];
					} else {
						$vnvalue['video_cover_image'] = base_url().'uploads/no_image.png';
					}

					if(!empty($vnvalue['profilePic'])) {
						$vnvalue['profilePic'] = base_url().'uploads/users/'.$vnvalue['profilePic'];
					} else {
						$vnvalue['profilePic'] = base_url().'uploads/no_image.png';
					}
					//$vnvalue['profilePic'] = base_url().'uploads/users/'.$vnvalue['profilePic'];
					$vnvalue['videos_file'] = base_url().'uploads/videos/videos_file/'.$vnvalue['videos_file'];
					$returnvn[$keyvn] = $vnvalue;
				}
			} else {
				$returnvn = "";
			}
			$data['video_collection'] = $returnvn;
			$response = array('status'=> 'success', 'result'=> $data);
		} catch(\Exception $e) {
			$response = array('status' => 'error', 'result' =>$e->getMessage());
		}
		echo json_encode($response);
	}
    //Video API End

	public function search_video() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$keyword = $formdata['keyword'];
			//print_r($formdata); die();
			//echo "SELECT id, video_cover_image, videos_file, videos_name, view_count FROM all_videos WHERE videos_name LIKE '%".$keyword."%'";
			$searchResult = $this->db->query("SELECT all_videos.id, users.organizername, users.profilePic, all_videos.video_cover_image, all_videos.videos_name, all_videos.videos_file, all_videos.view_count FROM all_videos JOIN users ON all_videos.user_id = users.userId WHERE all_videos.videos_name LIKE '%".$keyword."%' AND all_videos.status = '1' AND all_videos.is_delete = '1'")->result_array();
			//print_r($searchResult);
			if(!empty($searchResult)) {
				foreach ($searchResult as $keysv => $value) {
					$value['videos_file'] = base_url().'uploads/videos/videos_file/'.$value['videos_file'];
					$returnsv[$keysv] = $value;
				}
				$data['search_results'] = $returnsv;
				$response = array('status'=> 'success', 'result'=> $data);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No Data Found');
			}
		} catch (\Exception $th) {
			$response = array('status' => 'error', 'result' => $th->getMessage());
		}
		echo json_encode($response);
	}

	public function search_prayer() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$keyword = $formdata['keyword'];
			$prayer_list = $this->Crud_model->GetData('all_prayers', '', 'prayer_name LIKE "%'.$keyword.'%" AND status = 1 and is_delete = 1');
			if(!empty($prayer_list)) {
				$prayerList = array();
				foreach ($prayer_list as $key => $value) {
					$prayer_datetime = date('Y-m-d h:i A', strtotime($value->prayer_datetime));
					$prayer_datetime = date_create($prayer_datetime);
					$prayerList[$key]['id'] = $value->id;
					$prayerList[$key]['prayer_name'] = $value->prayer_name;
					$prayerList[$key]['prayer_location'] = $value->prayer_location;
					//$prayerList[$key]['prayer_subheading'] = $value->prayer_subheading;
					//$prayerList[$key]['prayer_description'] = $value->prayer_description;
					$prayerList[$key]['prayer_image'] = base_url().'uploads/prayer/'.$value->prayer_image;
					$prayerList[$key]['prayer_datetime'] = date_format($prayer_datetime,"l dS F Y, h:i A");
					$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
					$likedUser = $this->db->query("SELECT count(id) as total FROM user_liked_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['likedUser'] = $likedUser[0]['total'];
					$joineduserId = $this->db->query("SELECT user_id FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					foreach ($joineduserId as $key1 => $val) {
						$getuserimage = $this->db->query("SELECT profilePic FROM users WHERE userId = '".$val['user_id']."'")->result_array();
						$prayerList[$key]['joinedUserImage'][$key1] = $getuserimage[0]['profilePic'];
					}
				}
				$response = array('status'=> 'success', 'result'=> $prayerList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch(\Exception $e) {
			$response = array('status'=> 'error', 'result' => $e->getMessage());
		}
		echo json_encode($response);
	}

	public function joinedPrayerDetails() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$prayer_id = $formdata['prayer_id'];
			$prayer_details = $this->Crud_model->GetData('all_prayers', '', "id = '".$prayer_id."' AND status = 1 and is_delete = 1");
			if(!empty($prayer_details)) {
				$prayerDetails = array();
				foreach ($prayer_details as $key => $value) {
					$prayerDetails[$key]['id'] = $value->id;
					$prayerDetails[$key]['prayer_name'] = $value->prayer_name;
					$prayerDetails[$key]['prayer_location'] = $value->prayer_location;
					$prayerDetails[$key]['prayer_image'] = base_url().'uploads/prayer/'.$value->prayer_image;
				}
				$response = array('status'=> 'success', 'result'=> $prayerDetails);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Exception $th) {
			$response = array('status'=> 'error', 'result' => $th->getMessage());
		}
		echo json_encode($response);
	}

	public function userJoinedPrayer() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$event_id = $formdata['event_id'];
			$fullname = $formdata['fullname'];
			$phno = $formdata['phno'];
			$gender = $formdata['gender'];
			$nationality = $formdata['nationality'];
			$data = array(
				"user_id"=>$user_id,
				"event_id"=>$event_id,
				"fullname"=>$fullname,
				"phno"=>$phno,
				"gender"=>$gender,
				"nationality"=>$nationality
			);
			$this->Crud_model->SaveData('user_joined_event', $data);
			$response = array('status'=> 'success', 'result'=> "You joined the prayer successfully");
		} catch (\Exception $th) {
			$response = array('status'=> 'error', 'result' => $th->getMessage());
		}
		echo json_encode($response);
	}

	public function product_category() {
		try {
			$productCategory = $this->db->query("SELECT * FROM product_category WHERE status = 'Active' ORDER BY category_name ASC")->result_array();
			if(!empty($productCategory)) {
				$procatList = array();
				foreach ($productCategory as $key => $value) {
					$procatList[$key]['id'] = $value['id'];
					$procatList[$key]['category_name'] = $value['category_name'];
					$procatList[$key]['category_image'] =  base_url().'uploads/product_category/'.$value['category_image'];
					$procatList[$key]['status'] = $value['status'];
				}
				$response = array('status'=> 'success', 'result'=> $procatList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status' => 'error', 'result'=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function featured_product_list() {
		try {
			$productList = $this->db->query("SELECT * FROM product_list WHERE status = 'Active' ORDER BY id DESC LIMIT 3")->result_array();
			if(!empty($productList)) {
				$proList = array();
				foreach ($productList as $key => $value) {
					$proList[$key]['id'] = $value['id'];
					$proList[$key]['pro_name'] = $value['pro_name'];
					$proList[$key]['pro_desc'] = strip_tags($value['pro_desc']);
					//$proList[$key]['pro_image'] =  base_url().'uploads/product/'.$value['pro_image'];
					//$proList[$key]['mrp'] = $value['mrp'];
					//$proList[$key]['discount'] = $value['discount']."% off";
					//$proList[$key]['final_price'] = $value['final_price'];
					//$proList[$key]['status'] = $value['status'];
					$pro_Img = $this->db->query("SELECT id, pro_image FROM product_image where prod_id = '".$value['id']."'")->result_array();
					if(!empty($pro_Img)) {
						foreach ($pro_Img as $key1 => $val) {
							$val['pro_image'] = base_url().'uploads/product/'.$val['pro_image'];
							$return[$key1] = $val;
							$proimg = $return;
							$proList[$key]['imageList'] = $proimg;
						}
					} else {
						$proList[$key]['imageList'] = [];
					}
				}
				$response = array('status'=> 'success', 'result'=> $proList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status' => 'error', 'result'=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function product_list() {
		try {
			$productList = $this->db->query("SELECT * FROM product_list WHERE status = 'Active' ORDER BY id DESC")->result_array();
			if(!empty($productList)) {
				$proList = array();
				foreach ($productList as $key => $value) {
					$proList[$key]['id'] = $value['id'];
					$proList[$key]['pro_name'] = $value['pro_name'];
					//$proList[$key]['pro_image'] =  base_url().'uploads/product/'.$value['pro_image'];
					$proList[$key]['mrp'] = $value['mrp'];
					$proList[$key]['discount'] = $value['discount']."% off";
					$proList[$key]['final_price'] = $value['final_price'];
					$proList[$key]['status'] = $value['status'];
					$pro_Img = $this->db->query("SELECT id, pro_image FROM product_image where prod_id = '".$value['id']."'")->result_array();
					if(!empty($pro_Img)) {
						foreach ($pro_Img as $key1 => $val) {
							$val['pro_image'] = base_url().'uploads/product/'.$val['pro_image'];
							$return[$key1] = $val;
							$proimg = $return;
							$proList[$key]['imageList'] = $proimg;
						}
					} else {
						$proList[$key]['imageList'] = [];
					}
				}
				$response = array('status'=> 'success', 'result'=> $proList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status' => 'error', 'result'=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function productDetails() {
		try {
			$formdata = json_decode(file_get_contents('php://input'),true);
			$pro_id = $formdata['prod_id'];
			$productdata = $this->db->query("SELECT * FROM product_list WHERE id = '".$pro_id."' AND status = 'Active' ORDER BY id DESC")->result_array();
			//print_r($productdata); die;
			if(!empty($productdata)) {
				$proList = array();
				foreach ($productdata as $key => $value) {
					$proList[$key]['id'] = $value['id'];
					$proList[$key]['pro_name'] = $value['pro_name'];
					$get_cat = $this->db->query("SELECT * FROM product_category WHERE id = '".$value['pro_cat_id']."' AND status = 'Active' ORDER BY id DESC")->result_array();
					$proList[$key]['pro_cat'] = $get_cat[0]['category_name'];
					$proList[$key]['pro_desc'] = strip_tags($value['pro_desc']);
					//$proList[$key]['pro_image'] =  base_url().'uploads/product/'.$value['pro_image'];
					$pro_Img = $this->db->query("SELECT id, pro_image FROM product_image where prod_id = '".$value['id']."'")->result_array();
					if(!empty($pro_Img)) {
						foreach ($pro_Img as $key1 => $val) {
							$val['pro_image'] = base_url().'uploads/product/'.$val['pro_image'];
							$return[$key1] = $val;
							$proimg = $return;
							$proList[$key]['imageList'] = $proimg;
						}
					} else {
						$proList[$key]['imageList'] = [];
					}
					$proList[$key]['status'] = $value['status'];
				}
				$response = array('status'=> 'success', 'result'=> $proList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status' => 'error', 'result'=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function productByCategory() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$catid = $formdata['cat_id'];
			if($catid > 0){
				$productList = $this->db->query("SELECT * FROM product_list WHERE pro_cat_id = '".$catid."' AND status = 'Active' ORDER BY id DESC")->result_array();
			} else {
				$productList = $this->db->query("SELECT * FROM product_list WHERE status = 'Active' ORDER BY id DESC")->result_array();
			}
			
			if(!empty($productList)) {
				$proList = array();
				foreach ($productList as $key => $value) {
					$proList[$key]['id'] = $value['id'];
					$proList[$key]['pro_name'] = $value['pro_name'];
					//$proList[$key]['pro_image'] =  base_url().'uploads/product/'.$value['pro_image'];
					$proList[$key]['mrp'] = $value['mrp'];
					$proList[$key]['discount'] = $value['discount']."% off";
					$proList[$key]['final_price'] = $value['final_price'];
					$proList[$key]['status'] = $value['status'];
					$pro_Img = $this->db->query("SELECT id, pro_image FROM product_image where prod_id = '".$value['id']."'")->result_array();
					if(!empty($pro_Img)) {
						foreach ($pro_Img as $key1 => $val) {
							$val['pro_image'] = base_url().'uploads/product/'.$val['pro_image'];
							$return[$key1] = $val;
							$proimg = $return;
							$proList[$key]['imageList'] = $proimg;
						}
					} else {
						$proList[$key]['imageList'] = [];
					}
				}
				$response = array('status'=> 'success', 'result'=> $proList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status' => 'error', 'result'=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function search_product() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$price_range = $formdata['price_range'];
			$discount = $formdata['discount'];
			if(!empty($price_range)) {
				if($price_range == '1') {
					$cond = "final_price <= 50";
				} else if($price_range == '2') {
					$cond = "final_price between 50 AND 100";
				} else if($price_range == '3') {
					$cond = "final_price between 100 AND 150";
				} else if($price_range == '4') {
					$cond = "final_price between 150 AND 200";
				} else if($price_range == '5') {
					$cond = "final_price between 200 AND 250";
				} else {
					$cond = "final_price < 250";
				}
			} else {
				$cond = "final_price < 0";
			}
			if (!empty($discount)) {
				if($discount == '1') {
					$cond1 = "AND discount between 10 AND 20";
				} else if($discount == '2') {
					$cond1 = "AND discount between 20 AND 30";
				} else if($discount == '3') {
					$cond1 = "AND discount between 30 AND 40";
				} else if($discount == '4') {
					$cond1 = "AND discount between 40 AND 50";
				} else {
					$cond1 = "AND discount < 50";
				}
			} else {
				$cond1 = "";
			}
			$searchproductList = $this->db->query("SELECT * FROM product_list WHERE $cond $cond1")->result_array();
			if(!empty($searchproductList)) {
				$proList = array();
				foreach ($searchproductList as $key => $value) {
					$proList[$key]['id'] = $value['id'];
					$proList[$key]['pro_name'] = $value['pro_name'];
					//$proList[$key]['pro_image'] =  base_url().'uploads/product/'.$value['pro_image'];
					$proList[$key]['mrp'] = $value['mrp'];
					$proList[$key]['discount'] = $value['discount']."% off";
					$proList[$key]['final_price'] = $value['final_price'];
					$proList[$key]['status'] = $value['status'];
					$pro_Img = $this->db->query("SELECT id, pro_image FROM product_image where prod_id = '".$value['id']."'")->result_array();
					if(!empty($pro_Img)) {
						foreach ($pro_Img as $key1 => $val) {
							$val['pro_image'] = base_url().'uploads/product/'.$val['pro_image'];
							$return[$key1] = $val;
							$proimg = $return;
							$proList[$key]['imageList'] = $proimg;
						}
					} else {
						$proList[$key]['imageList'] = [];
					}
				}
				$response = array('status'=> 'success', 'result'=> $proList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status' => 'error', 'result'=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function filter_search() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$filterid = $formdata['short_by'];
			if(!empty($filterid)) {
				if($filterid == '1') {
					$cond = 'ORDER BY id ASC';
				} else if ($filterid == '2') {
					$cond = 'ORDER BY id DESC';
				} else if ($filterid == '3') {
					$cond = 'ORDER BY CAST(final_price AS DECIMAL(10,2)) ASC';
				} else if ($filterid == '4') {
					$cond = 'ORDER BY CAST(final_price AS DECIMAL(10,2)) DESC';
				} else if ($filterid == '5') {
					$cond = 'ORDER BY id DESC';
				} else {
					$cond = '';
				}
			} else {
				$cond = '';
			}
			$filtered_data = $this->db->query("SELECT * FROM product_list WHERE status='Active' $cond")->result_array();
			if(!empty($filtered_data)) {
				$proList = array();
				foreach ($filtered_data as $key => $value) {
					$proList[$key]['id'] = $value['id'];
					$proList[$key]['pro_name'] = $value['pro_name'];
					//$proList[$key]['pro_image'] =  base_url().'uploads/product/'.$value['pro_image'];
					$proList[$key]['mrp'] = $value['mrp'];
					$proList[$key]['discount'] = $value['discount']."% off";
					$proList[$key]['final_price'] = $value['final_price'];
					$proList[$key]['status'] = $value['status'];
					$pro_Img = $this->db->query("SELECT id, pro_image FROM product_image where prod_id = '".$value['id']."'")->result_array();
					if(!empty($pro_Img)) {
						foreach ($pro_Img as $key1 => $val) {
							$val['pro_image'] = base_url().'uploads/product/'.$val['pro_image'];
							$return[$key1] = $val;
							$proimg = $return;
							$proList[$key]['imageList'] = $proimg;
						}
					} else {
						$proList[$key]['imageList'] = [];
					}
				}
				$response = array('status'=> 'success', 'result'=> $proList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status'=> 'error', 'result'=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function userAddress_list() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata["user_id"];
			$getuseraddress = $this->db->query("SELECT * FROM user_address WHERE user_id = '".$user_id."'")->result_array();
			if(!empty($getuseraddress)) {
				$addressList = array();
				foreach ($getuseraddress as $key => $value) {
					$addressList[$key]['id'] = $value['id'];
					//$addressList[$key]['user_id'] = $value['user_id'];
					$addressList[$key]['fullname'] = $value['fullname'];
					$addressList[$key]['phno'] = $value['phno'];
					$addressList[$key]['houseno'] = $value['houseno'];
					$addressList[$key]['landmark'] = $value['landmark'];
					$addressList[$key]['pincode'] = $value['pincode'];
					$addressList[$key]['address_type'] = $value['address_type'];
				}
				$response = array('status'=> 'success', 'result'=> $addressList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function add_address() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$data = array(
				'user_id' => $formdata['user_id'],
				'fullname' => $formdata['fullname'],
				'phno' => $formdata['phno'],
				'houseno' => $formdata['houseno'],
				'landmark' => $formdata['landmark'],
				'pincode' => $formdata['pincode'],
				'address_type' => $formdata['address_type'],
			);
			$this->Crud_model->SaveData('user_address', $data);
			$response = array('status'=>'success', 'result'=>'Address Added Successfuly');
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function edit_address() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$id = $formdata["id"];
			$editaddress = $this->db->query("SELECT * FROM user_address WHERE id = '".$id."'")->result_array();
			$response = array('status'=>'error', 'result'=>$editaddress);
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function update_address() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$data = array(
				'fullname' => $formdata['fullname'],
				'phno' => $formdata['phno'],
				'houseno' => $formdata['houseno'],
				'landmark' => $formdata['landmark'],
				'pincode' => $formdata['pincode'],
				'address_type' => $formdata['address_type'],
			);
			$this->Crud_model->SaveData('user_address', $data, 'id = "'.$formdata['id'].'"');
			$response = array('status'=>'success', 'result'=>'Address Updated Successfuly');
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function add_to_cart() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$checkCartData = $this->db->query("SELECT * FROM add_to_cart WHERE product_id = '".$formdata['product_id']."' AND user_id = '".$formdata['user_id']."'")->result_array();
			if(!empty($checkCartData)) {
				$data = array(
					'quantity' => $checkCartData[0]['quantity']+1
				);
				$this->Crud_model->SaveData('add_to_cart', $data, "product_id = '".$formdata['product_id']."' AND user_id = '".$formdata['user_id']."'");
				$checkuCartData = $this->db->query("SELECT * FROM add_to_cart WHERE product_id = '".$formdata['product_id']."' AND user_id = '".$formdata['user_id']."'")->result_array();
				$checkpData = $this->db->query("SELECT * FROM product_list WHERE id = '".$formdata['product_id']."' AND status = 'Active'")->result_array();
				$data1 = array(
					'mrp' => $checkuCartData[0]['quantity']*$checkpData[0]['mrp'],
					'discount' => $checkuCartData[0]['quantity']*($checkpData[0]['mrp'] - $checkpData[0]['final_price']),
					'final_price' => $checkuCartData[0]['quantity']*$checkpData[0]['final_price'],
				);
				$this->Crud_model->SaveData('add_to_cart', $data1, "product_id = '".$formdata['product_id']."' AND user_id = '".$formdata['user_id']."'");
				$response = array('status'=>'success', 'result'=>'Cart updated');
			} else {
				$productDetails = $this->db->query("SELECT * FROM product_list WHERE id = '".$formdata['product_id']."' AND status = 'Active'")->result_array();
				$data = array(
					'user_id' => @$formdata['user_id'],
					'product_id' => @$formdata['product_id'],
					'quantity' => @$formdata['quantity'],
					'mrp' => @$productDetails[0]['mrp'],
					'discount' => @$productDetails[0]['mrp']-$productDetails[0]['final_price'],
					'final_price' => @$productDetails[0]['final_price'],
					'created_date' => date("Y-m-d H:i:s")
				);
				$this->Crud_model->SaveData('add_to_cart', $data);
				$response = array('status'=>'success', 'result'=>'Added to cart');
			}
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function total_cart() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$totalCart = $this->db->query("SELECT COUNT(id) AS count FROM add_to_cart WHERE user_id = '".$user_id."'")->result_array();
			$response = array('status'=>'success', 'result'=>$totalCart);
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function cart_list() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$getProductDetails = $this->db->query("SELECT product_list.id, product_image.pro_image, product_list.pro_name, product_category.category_name, add_to_cart.mrp, add_to_cart.quantity, add_to_cart.final_price, add_to_cart.discount FROM product_list JOIN product_category ON product_list.pro_cat_id = product_category.id LEFT JOIN product_image ON product_image.prod_id = product_list.id JOIN add_to_cart ON add_to_cart.product_id = product_list.id WHERE add_to_cart.user_id = '".$user_id."' GROUP BY product_list.id")->result_array();
			if(!empty($getProductDetails)) {
				$getList['cartList'] = array();
				$saved['total_saved'] = array();
				$saved['total_amount'] = array();
				foreach ($getProductDetails as $key => $value) {
					$getList['cartList'][$key]['id'] = $value['id'];
					$getList['cartList'][$key]['pro_image'] = base_url().'uploads/product/'.$value['pro_image'];
					$getList['cartList'][$key]['pro_name'] = $value['pro_name'];
					$getList['cartList'][$key]['category_name'] = $value['category_name'];
					$getList['cartList'][$key]['quantity'] = $value['quantity'];
					$getList['cartList'][$key]['final_price'] = sprintf("%0.2f",$value['final_price']);
					$saved['total_saved'][$key] = sprintf("%0.2f",($value['mrp']-$value['final_price']));
					$saved['total_amount'][$key] = sprintf("%0.2f",$value['final_price']);
				}
				$ts = sizeof($saved['total_saved']);
				$ta = sizeof($saved['total_amount']);
				$total_saved = $this->sum($saved['total_saved'], $ts);
				$total_amount = $this->sum($saved['total_amount'], $ta);
				$total_saved = array('total_saved'=> sprintf("%0.2f",$total_saved));
				$total_amount = array('total_amount'=> sprintf("%0.2f",$total_amount));
				$res = array_merge($getList ,$total_saved, $total_amount);
				$response = array('status'=> 'success', 'result'=> $res);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	function sum($arr, $n) {
    	$sum = 0;
		for ($i = 0; $i < $n; $i++) {
			$sum += $arr[$i];
		}
		return $sum;
	}

	public function update_cart_list() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$checkCartData = $this->db->query("SELECT * FROM add_to_cart WHERE product_id = '".$formdata['product_id']."' AND user_id = '".$formdata['user_id']."'")->result_array();
			$data = array(
				'quantity' => $checkCartData[0]['quantity']+$formdata['quantity']
			);
			$this->Crud_model->SaveData('add_to_cart', $data, "product_id = '".$formdata['product_id']."' AND user_id = '".$formdata['user_id']."'");
			$checkuCartData = $this->db->query("SELECT * FROM add_to_cart WHERE product_id = '".$formdata['product_id']."' AND user_id = '".$formdata['user_id']."'")->result_array();
			$checkpData = $this->db->query("SELECT * FROM product_list WHERE id = '".$formdata['product_id']."' AND status = 'Active'")->result_array();
			$data1 = array(
				'mrp' => $checkuCartData[0]['quantity']*$checkpData[0]['mrp'],
				'discount' => $checkuCartData[0]['quantity']*($checkpData[0]['mrp'] - $checkpData[0]['final_price']),
				'final_price' => $checkuCartData[0]['quantity']*$checkpData[0]['final_price'],
			);
			$this->Crud_model->SaveData('add_to_cart', $data1, "product_id = '".$formdata['product_id']."' AND user_id = '".$formdata['user_id']."'");
			$response = array('status'=>'success', 'result'=>'Cart updated');
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function remove_cart_list() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$product_id = $formdata['product_id'];
			$checkCartDate = $this->db->query("SELECT * FROM add_to_cart WHERE product_id = '".$product_id."' AND user_id = '".$user_id."'")->result_array();
			//print_r($checkCartDate); die;
			if(!empty($checkCartDate)) {
				$this->db->query("DELETE FROM add_to_cart WHERE product_id = '".$product_id."' AND user_id = '".$user_id."'");
				$response = array('status'=>'success', 'result'=>'Removed');
			} else {
				$response = array('status'=>'error', 'result'=>'No Data Found');
			}
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function add_card() {
		try {
			$formdata = json_decode(file_get_contents("php://input"), true);
			$user_id = $formdata['user_id'];
			$card_number = $formdata['card_number'];
			$date = $formdata['date'];
			$cvv = $formdata['cvv'];
			$data = array(
				"user_id" => $user_id,
				"card_no" => base64_encode($card_number),
				"expiry_date" => base64_encode($date),
				"cvv" => base64_encode($cvv),
				'created_date' => date("Y-m-d H:i:s")
			);
			//print_r($data); die;
			$this->Crud_model->SaveData('user_add_card', $data);
			$response = array('status'=>'success', 'result'=>'Card Added');
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function get_card() {
		try {
			$formdata = json_decode(file_get_contents("php://input"), true);
			$user_id = $formdata['user_id'];
			$getCardList = $this->db->query("SELECT * FROM user_add_card WHERE user_id = '".$user_id."'")->result_array();
			if(!empty($getCardList)) {
				$getcardList = array();
				foreach ($getCardList as $key => $value) {
					$getcardList[$key]['id'] = $value['id'];
					$getcardList[$key]['user_id'] = $value['user_id'];
					$getcardList[$key]['card_no'] = base64_decode($value['card_no']);
					$getcardList[$key]['expiry_date'] = base64_decode($value['expiry_date']);
					$getcardList[$key]['cvv'] = base64_decode($value['cvv']);
					$getcardList[$key]['created_date'] = $value['created_date'];
				}
			} else {
				$getcardList = false;
			}
			$response = array('status'=>'success', 'result'=> $getcardList);
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function proceed_to_pay() {
		try {
			$formdata = json_decode(file_get_contents("php://input"), true);
			$user_id = $formdata['user_id'];
			$delivery_add = $formdata['delivery_add'];
			$getProductList = $this->db->query("SELECT * FROM add_to_cart WHERE user_id = '".$user_id."'")->result_array();
			if(!empty($getProductList)) {
				$getList['cartList'] = array();
				$saved['total_amount'] = array();
				foreach ($getProductList as $key => $value) {
					$getList['cartList'][$key]['product_id'] = $value['product_id'];
					$getList['cartList'][$key]['quantity'] = $value['quantity'];
					$getList['cartList'][$key]['final_price'] = sprintf("%0.2f",$value['final_price']);
					$saved['total_saved'][$key] = sprintf("%0.2f",($value['mrp']-$value['final_price']));
					$saved['total_amount'][$key] = sprintf("%0.2f",$value['final_price']);
				}
				$ts = sizeof($saved['total_saved']);
				$ta = sizeof($saved['total_amount']);
				$total_amount = $this->sum($saved['total_amount'], $ta);
				$total_amount = array('total_amount'=> sprintf("%0.2f",$total_amount));
				$res = array_merge($getList , $total_amount);
				$data = array(
					"user_id" => $user_id,
					"order_details" => json_encode($res),
					"delivery_add" => $delivery_add,
					"transaction_id" => "txn_".time(),
					"order_type" => "online",
					"payment_method" => "card",
					"is_paid" => 1,
					"order_status" => "payment success",
					'created_date' => date("Y-m-d H:i:s")
				);
				$this->Crud_model->SaveData('proceed_to_pay', $data);
				$this->db->query("DELETE FROM add_to_cart WHERE user_id = '".$user_id."'");
				$response = array('status'=>'success', 'result'=>'Payment Successful');
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function add_social_post() {
		try {
			if(isset($_FILES['social_img']['name']) !='') {
				$_POST['social_img']= rand(0000,9999)."_".$_FILES['social_img']['name'];
				$config2['image_library'] = 'gd2';
				$config2['source_image'] =  $_FILES['social_img']['tmp_name'];
				$config2['new_image'] =   getcwd().'/uploads/social_img/'.$_POST['social_img'];
				$config2['upload_path'] =  getcwd().'/uploads/social_img/';
				$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
				$config2['maintain_ratio'] = FALSE;
				$this->image_lib->initialize($config2);
				if(!$this->image_lib->resize()) {
					$response = array('status'=> 'error', 'result'=> "Something went wrong while uploding image. Please try again later!");
				} else {
					$image  = $_POST['social_img'];
				}
			} else {
				$image  = "";
			}
			$data = array(
				'user_id' => $this->input->post('user_id'),
				'social_img'=>$image,
				'created_date' => date("Y-m-d H:i:s"),
			);
			$this->Crud_model->SaveData('users_post', $data);
			$response = array('status'=> 'success', 'result'=> "Post created successfully");
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function social_user_list() {
		try {
			$getSocialPostUsers = $this->db->query("SELECT users.userId, users.organizername, users.firstname, users.lastname, users.userType, users.profilePic FROM users JOIN users_post ON users.userId = users_post.user_id GROUP BY users.userId")->result_array();
			if(!empty($getSocialPostUsers)) {
				$getUserDetails = array();
				foreach ($getSocialPostUsers as $key => $value) {
					$getUserDetails[$key]['userId'] = $value['userId'];
					if($value['userType'] == 1) {
						$getUserDetails[$key]['fullname'] = $value['firstname']." ".$value['lastname'];
					} else {
						$getUserDetails[$key]['fullname'] = $value['organizername'];
					}
					if(!empty($value['profilePic'])) {
						$getUserDetails[$key]['profilePic'] = base_url().'uploads/users/'.$value['profilePic'];
					} else {
						$getUserDetails[$key]['profilePic'] = base_url().'uploads/no_image.png';
					}
					//$getUserDetails[$key]['profilePic'] = base_url().'uploads/users/'.$value['profilePic'];
				}
			} else {
				$getUserDetails = "No Data Found";
			}
			$response = array('status'=> 'success', 'result'=> $getUserDetails);
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function social_listByUser() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$getSocialPostList = $this->db->query("SELECT * FROM users_post WHERE user_id = '".$user_id."'")->result_array();
			//print_r($getSocialPostList); die();
			if(!empty($getSocialPostList)) {
				$getPostDetails = array();
				foreach ($getSocialPostList as $key => $value) {
					$getPostDetails[$key]['id'] = $value['id'];
					$userDetails = $this->db->query("SELECT organizername, firstname, lastname, userType, profilePic FROM users WHERE userId = '".$user_id."'")->row();
					$getPostDetails[$key]['organizername'] = $userDetails->organizername;
					$getPostDetails[$key]['firstname'] = $userDetails->firstname;
					$getPostDetails[$key]['lastname'] = $userDetails->lastname;
					if(!empty($userDetails->profilePic)) {
						$getPostDetails[$key]['profilePic'] = base_url().'uploads/users_post/'.$userDetails->profilePic;
					} else {
						$getPostDetails[$key]['profilePic'] = base_url().'uploads/no_image.png';
					}
					if(!empty($value['social_img'])) {
						$getPostDetails[$key]['social_img'] = base_url().'uploads/social_img/'.$value['social_img'];
					} else {
						$getPostDetails[$key]['social_img'] = base_url().'uploads/no_image.png';
					}
					$getPostDetails[$key]['created_date'] = date("jS M Y", strtotime($value['created_date']));
					$likedPost = $this->db->query("SELECT count(*) AS liked FROM user_post_like WHERE post_id = '".$value['id']."'")->row();
					$getPostDetails[$key]['liked'] = $likedPost->liked;
					$commentPost = $this->db->query("SELECT count(*) AS comment FROM user_post_comment WHERE post_id = '".$value['id']."'")->row();
					$getPostDetails[$key]['comment'] = $commentPost->comment;
					$isliked = $this->db->query("SELECT COUNT(*) AS liked FROM user_post_like WHERE user_id = '".$user_id."' AND post_id = '".$value['id']."'")->row();
					if(!empty($isliked->liked)) {
						$getPostDetails[$key]['isliked'] = "1";
					} else {
						$getPostDetails[$key]['isliked'] = "0";
					}
				}
			} else {
				$getPostDetails = "No Data Found";
			}
			$response = array('status'=> 'success', 'result'=> $getPostDetails);
		} catch (\Throwable $th) {
			$response = array('status'=>'error', 'result'=>$th->getMessage());
		}
		echo json_encode($response);
	}

	public function user_post_like() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$post_id = $formdata["post_id"];
			$isLiked = $formdata["isLiked"];
			$data = array(
				"user_id"=>$user_id,
				"post_id"=>$post_id,
				"created_date"=>date("Y-m-d h:i:sa")
			);
			if($formdata['isLiked'] == '1') {
    			$this->Crud_model->SaveData('user_post_like', $data);
				$response = array("status"=> "success", "result"=> "Liked");
    		} else {
    			$this->db->query("DELETE FROM user_post_like WHERE user_id = '".$user_id."' AND post_id = '".$post_id."'");
				$response = array("status"=> "success", "result"=> "Disliked");
    		}
			//$this->Crud_model->SaveData('user_post_like', $data);
			//$response = array("status"=> "success", "result"=> "Liked");
		} catch (\Throwable $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function user_post_dislike() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$post_id = $formdata["post_id"];
			$this->db->query("DELETE FROM user_post_like WHERE user_id = '".$user_id."' AND post_id = '".$post_id."'");
			$response = array("status"=> "success", "result"=> "Disliked");
		} catch (\Throwable $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function add_post_comment() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata["user_id"];
			$post_id = $formdata["post_id"];
			$comment = $formdata["comment"];
			$data = array(
				"user_id"=>$user_id,
				"post_id"=>$post_id,
				"comment"=>$comment,
				"created_date"=> date("Y-m-d H:i:s")
			);
			$this->Crud_model->SaveData('user_post_comment', $data);
			$response = array("status"=> "success", "result"=> "Comment Added");
		} catch (\Throwable $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function user_post_details() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$getPostDetails = $this->db->query("SELECT users.userId AS user_id, users.organizername, users.firstname, users.lastname, users.userType, users.profilePic, users_post.id AS post_id, users_post.social_img, users_post.created_date FROM users JOIN users_post ON users.userId = users_post.user_id WHERE users.userId = '".$user_id."'")->result_array();
			if(!empty($getPostDetails)) {
				$postDetails = array();
				foreach ($getPostDetails as $key => $value) {
					$postDetails[$key]["user_id"] = $value["user_id"];
					if($value["userType"] == 1) {
						$postDetails[$key]["fullname"] = $value["firstname"]." ".$value["lastname"];
					} else {
						$postDetails[$key]["fullname"] = $value["organizername"];
					}
					$postDetails[$key]["profilePic"] = base_url().'uploads/users/'.$value["profilePic"];
					$postDetails[$key]["post_id"] = $value["post_id"];
					$postDetails[$key]["social_img"] = base_url().'uploads/social_img/'.$value["social_img"];
					$countLike = $this->db->query("SELECT COUNT(id) AS total_like FROM user_post_like WHERE post_id = '".$value["post_id"]."'")->result_array();
					$postDetails[$key]["count_like"] = $countLike[0]['total_like'];
					$countComment = $this->db->query("SELECT COUNT(id) AS total_comment FROM user_post_comment WHERE post_id = '".$value["post_id"]."'")->result_array();
					$postDetails[$key]["count_comment"] = $countComment[0]['total_comment'];
					$postDetails[$key]["created_date"] = $value["created_date"];
				}
			} else {
				$postDetails = "No data found";
			}
			$response = array("status"=> "success", "result"=> $postDetails);
		} catch (\Throwable $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function get_post_comment() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$post_id = $formdata['post_id'];
			$getComment = $this->db->query("SELECT * FROM user_post_comment WHERE post_id = '".$post_id."'")->result_array();
			//print_r($getComment); die;
			if(!empty($getComment)) {
				$getcomment = array();
				foreach ($getComment as $key => $value) {
					$getcomment[$key]['id'] = $value['id'];
					$getUser = $this->db->query("SELECT * FROM users WHERE userId = '".$value['user_id']."'")->result_array();
					if($getUser[0]['userType'] == 1){
						$getcomment[$key]['fullname'] = $getUser[0]['firstname']." ".$getUser[0]['lastname'];
					} else {
						$getcomment[$key]['fullname'] = $getUser[0]['organizername'];
					} 
					$getcomment[$key]["profilePic"] = base_url().'uploads/users/'.$getUser[0]['profilePic'];
					$getcomment[$key]['post_id'] = $value['post_id'];
					$getcomment[$key]['comment'] = $value['comment'];
					$getcomment[$key]['commented_on'] = date ('D, jS M Y h:i a', strtotime($value['created_date']));
					$getCommentLike = $this->db->query("SELECT COUNT(id) AS comment_like FROM user_comment_like WHERE comment_id = '".$value['id']."'")->result_array();
					$getcomment[$key]['comment_like'] = $getCommentLike[0]['comment_like'];
					$getCommentDislike = $this->db->query("SELECT COUNT(id) AS comment_dislike FROM user_comment_dislike WHERE comment_id = '".$value['id']."'")->result_array();
					$getcomment[$key]['comment_dislike'] = $getCommentDislike[0]['comment_dislike'];
					$getCommentreply = $this->db->query("SELECT COUNT(id) AS comment_reply FROM user_post_comment_reply WHERE comment_id = '".$value['id']."'")->result_array();
					$getcomment[$key]['comment_reply'] = $getCommentreply[0]['comment_reply'];
				}
			} else {
				$getcomment = "No comment posted yet";
			}
			$response = array("status"=> "success", "result"=> $getcomment);
		} catch (\Throwable $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function addLikeForEachComment() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$comment_id = $formdata['comment_id'];
			$isliked = $formdata['isliked'];
			$data = array(
				'user_id'=> $user_id,
				'comment_id'=> $comment_id,
				'created_date'=> date("Y-m-d h:i:sa")
			);
			if($formdata['isliked'] == '1') {
    			$this->Crud_model->SaveData('user_comment_dislike', $data);
				$response = array("status"=> "success", "result"=> "Liked");
    		} else {
    			$this->db->query("DELETE FROM user_comment_like WHERE user_id = '".$user_id."' AND comment_id = '".$comment_id."'");
			$response = array("status"=> "success", "result"=> "Disliked");
    		}
			//$this->Crud_model->SaveData('user_comment_like', $data);
			//$this->db->query("DELETE FROM user_comment_dislike WHERE user_id = '".$user_id."' AND comment_id = '".$comment_id."'");
			//$response = array("status"=> "success", "result"=> "Liked");
		} catch (\Throwable $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}

	/*public function addDislikeForEachComment() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata['user_id'];
			$comment_id = $formdata['comment_id'];
			$data = array(
				'user_id'=> $user_id,
				'comment_id'=> $comment_id,
				'created_date'=> date("Y-m-d h:i:sa")
			);
			$this->Crud_model->SaveData('user_comment_dislike', $data);
			$this->db->query("DELETE FROM user_comment_like WHERE user_id = '".$user_id."' AND comment_id = '".$comment_id."'");
			$response = array("status"=> "success", "result"=> "Disliked");
		} catch (\Throwable $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}*/

	public function add_post_comment_rply() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$user_id = $formdata["user_id"];
			$post_id = $formdata["post_id"];
			$comment_id = $formdata["comment_id"];
			$comment_reply = $formdata["comment_reply"];
			$data = array(
				"user_id"=> $user_id,
				"post_id"=> $post_id,
				"comment_id"=> $comment_id,
				"comment_reply"=> $comment_reply,
				"created_date"=> date("Y-m-d H:i:s")
			);
			$this->Crud_model->SaveData('user_post_comment_reply', $data);
			$response = array("status"=> "success", "result"=> "Comment Added");
		} catch (\Throwable $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function get_comment_reply() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$comment_id = $formdata['comment_id'];
			$getCommentRply = $this->db->query("SELECT * FROM user_post_comment_reply WHERE comment_id = '".$comment_id."'")->result_array();
			if(!empty($getCommentRply)) {
				$getcommentrply = array();
				foreach ($getCommentRply as $key => $value) {
					$getcommentrply[$key]['id'] = $value['id'];
					$getUser = $this->db->query("SELECT * FROM users WHERE userId = '".$value['user_id']."'")->result_array();
					if($getUser[0]['userType'] == 1){
						$getcommentrply[$key]['fullname'] = $getUser[0]['firstname']." ".$getUser[0]['lastname'];
					} else {
						$getcommentrply[$key]['fullname'] = $getUser[0]['organizername'];
					} 
					$getcommentrply[$key]["profilePic"] = base_url().'uploads/users/'.$getUser[0]['profilePic'];
					$getcommentrply[$key]['post_id'] = $value['post_id'];
					$getcommentrply[$key]['comment'] = $value['comment_reply'];
					$getcommentrply[$key]['commented_on'] = date ('D, jS M Y h:i a', strtotime($value['created_date']));
				}
			} else {
				$getcommentrply = "No comment posted yet";
			}
			$response = array("status"=> "success", "result"=> $getcommentrply);
		} catch (\Throwable $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}
	
	public function deleteAccount() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$getuserDetails = $this->db->query("SELECT * FROM users WHERE userId = '".$formdata['user_id']."'")->result_array();
			if(!empty($getuserDetails)) {
				$this->db->query("DELETE FROM add_to_cart WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM proceed_to_pay WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM user_add_card WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM user_address WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM user_comment_dislike WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM user_comment_like WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM user_joined_event WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM user_liked_event WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM user_post_comment WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM user_post_comment_reply WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM user_post_like WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM users_post WHERE user_id = '".$formdata['user_id']."'");
				$this->db->query("DELETE FROM users WHERE userId = '".$formdata['user_id']."'");
				$response = array("status"=> "success", "result"=> "You have successfully deleted your profile");
			} else {
				$response = array("status"=> "error", "result"=> "Profile not found.");
			}
		} catch (Exception $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}
	
	public function delete_account() {
		try {
			$userId = $this->input->get('userId');
			$getuserDetails = $this->db->query("SELECT * FROM users WHERE userId = '".$userId."'")->result_array();
			if(!empty($getuserDetails)) {
				$this->db->query("DELETE FROM add_to_cart WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM proceed_to_pay WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM user_add_card WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM user_address WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM user_comment_dislike WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM user_comment_like WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM user_joined_event WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM user_liked_event WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM user_post_comment WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM user_post_comment_reply WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM user_post_like WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM users_post WHERE user_id = '".$userId."'");
				$this->db->query("DELETE FROM users WHERE userId = '".$userId."'");
				$response = array("status"=> "success", "result"=> "You have successfully deleted your profile");
			} else {
				$response = array("status"=> "error", "result"=> "Profile not found.");
			}
		} catch (Exception $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}

	public function userlikedPodcast() {
    	try{
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$user_id = $formdata['user_id'];
    		$podcast_id = $formdata['podcast_id'];
    		$data = array(
    			'user_id' => $formdata['user_id'],
    			'podcast_id' => $formdata['podcast_id']
    		);
    		if($formdata['islike'] == '1') {
    			$this->db->insert('user_liked_podcast',$data);
    			$response = array('status'=> 'success', 'result'=> "Liked this podcast");
    		} else {
    			$this->db->query("DELETE FROM user_liked_podcast WHERE podcast_id = '".$formdata['podcast_id']."' AND user_id = '".$formdata['podcast_id']."'");
    			$response = array('status'=> 'success', 'result'=> "Disliked this podcast");
    		}
    	} catch(\Exception $e) {
    		$response = array('status' => 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

	public function LikedPodcast() {
		try{
			$likedPodcast = $this->db->query("SELECT all_podcasts.podcast_cover_image, all_podcasts.podcast_file, all_podcasts.podcast_name, all_podcasts.podcast_singer_name, all_podcasts.podcast_description FROM all_podcasts JOIN user_liked_podcast ON all_podcasts.id = user_liked_podcast.podcast_id WHERE all_podcasts.status = 1 AND all_podcasts.is_delete = 1")->result_array();
			if(!empty($likedPodcast)) {
				foreach ($likedPodcast as $keyue => $uevalue) {
					$uevalue['podcast_cover_image'] = base_url().'uploads/podcast/cover_image/'.$uevalue['podcast_cover_image'];
					$uevalue['podcast_file'] = base_url().'uploads/podcast/podcast_file/'.$uevalue['podcast_file'];
					$uevalue['is_liked'] = '1';
					$returnue[$keyue] = $uevalue;
				}
			} else {
				$returnue = "";
			}
			$response = array('status'=> 'success', 'result'=> $returnue);
		} catch (Exception $th) {
			$response = array("status"=> "error", "result"=> $th->getMessage());
		}
		echo json_encode($response);
	}
}
