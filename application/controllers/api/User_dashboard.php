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
			$user_info = $this->Crud_model->get_single('users', "userId='".$userid."'");
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
    		$responce = array('status'=> 'error', 'result' => $e->getMessage());
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
    		$responce = array('status'=> 'error', 'result' => $e->getMessage());
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
				$upcoming_events = $this->db->query("SELECT all_prayers.id, users.organizername, all_prayers.prayer_name, all_prayers.prayer_description, all_prayers.prayer_image, all_prayers.prayer_subheading, all_prayers.prayer_datetime, all_prayers.prayer_location FROM all_prayers JOIN users ON all_prayers.user_id = users.userId WHERE all_prayers.prayer_datetime LIKE '%".$todaysDate."%' AND all_prayers.status = '1' AND all_prayers.is_delete = '1'")->result_array();
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
					//$prayerList[$key]['prayer_description'] = $value->prayer_description;
					$prayerList[$key]['prayer_image'] = base_url().'uploads/prayer/'.$value->prayer_image;
					$prayerList[$key]['prayer_datetime'] = date_format($prayer_datetime,"l dS F Y, h:i A");
					$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
					$likedUser = $this->db->query("SELECT count(id) as total FROM user_liked_event WHERE event_id = '".$value->id."'")->result_array();
					$prayerList[$key]['likedUser'] = $likedUser[0]['total'];
				}
				$response = array('status'=> 'success', 'result'=> $prayerList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch(\Exception $e) {
			$responce = array('status'=> 'error', 'result' => $e->getMessage());
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
				}
				$response = array('status'=> 'success', 'result'=> $prayerList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch(\Exception $e) {
			$responce = array('status'=> 'error', 'result' => $e->getMessage());
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
					$podcastList[$key]['podcast_cover_image'] = base_url().'uploads/podcast/cover_image'.$value->podcast_cover_image;
					$podcastList[$key]['podcast_file'] = base_url().'uploads/podcast/podcast_file'.$value->podcast_file;
					$podcastList[$key]['podcast_singer_name'] = $value->podcast_singer_name;
					//$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					//$podcastList[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
				}
				$response = array('status'=> 'success', 'result'=> $podcastList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
    	} catch(\Exception $e) {
    		$responce = array('status'=> 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

	public function ListofPodcast() {
		try {
			$podcast_list = $this->Crud_model->GetData('all_podcasts', '', 'status = 1 and is_delete = 1');
			if(!empty($podcast_list)) {
				$podcastList = array();
				foreach ($podcast_list as $key => $value) {
					$podcastList[$key]['id'] = $value->id;
					$podcastList[$key]['podcast_name'] = $value->podcast_name;
					$podcastList[$key]['podcast_cover_image'] = base_url().'uploads/podcast/cover_image'.$value->podcast_cover_image;
					$podcastList[$key]['podcast_file'] = base_url().'uploads/podcast/podcast_file'.$value->podcast_file;
					$podcastList[$key]['podcast_singer_name'] = $value->podcast_singer_name;
					//$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					//$podcastList[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
				}
				$response = array('status'=> 'success', 'result'=> $podcastList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
		} catch (\Throwable $th) {
			$responce = array('status'=> 'error', 'result' => $th->getMessage());
		}
		echo json_encode($response);
	}

    public function podcast_details() {
    	try {
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$podcast_id = $formdata['podcast_id'];
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
					//$joinedUser = $this->db->query("SELECT count(id) as total FROM user_joined_event WHERE event_id = '".$value->id."'")->result_array();
					//$podcastDetails[$key]['userjoined'] = $joinedUser[0]['total']." have joined already";
				}
				$response = array('status'=> 'success', 'result'=> $podcastDetails);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
    	} catch(\Exception $e) {
    		$responce = array('status'=> 'error', 'result' => $e->getMessage());
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
					$videoList[$key]['video_cover_image'] = base_url().'uploads/videos/cover_image'.$value->video_cover_image;
					$videoList[$key]['videos_file'] = base_url().'uploads/videos/videos_file'.$value->videos_file;
					$videoList[$key]['view_count'] = $value->view_count;
				}
				$response = array('status'=> 'success', 'result'=> $videoList);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
    	} catch(\Exception $e) {
    		$responce = array('status'=> 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }

    public function video_details() {
    	try {
    		$formdata = json_decode(file_get_contents('php://input'), true);
    		$video_id = $formdata['video_id'];
			$video_details = $this->Crud_model->GetData('all_videos', '', "id = '".$video_id."'");
			$viewcount = $video_details[0]->view_count+1;
			$insert_data=array('view_count'=>$viewcount);
			$this->Crud_model->SaveData('all_videos',$insert_data,"id='".$video_id."'");
			$video_details = $this->Crud_model->GetData('all_videos', '', "id = '".$video_id."'");
			if(!empty($video_details)) {
				$videoDetails = array();
				foreach ($video_details as $key => $value) {
					$videoDetails[$key]['id'] = $value->id;
					$videoDetails[$key]['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$value->video_cover_image;
					$videoDetails[$key]['videos_file'] = base_url().'uploads/videos/videos_file/'.$value->videos_file;
					$videoDetails[$key]['videos_name'] = $value->videos_name;
					$videoDetails[$key]['videos_description'] = $value->videos_description;
					$videoDetails[$key]['view_count'] = $value->view_count;
				}
				$response = array('status'=> 'success', 'result'=> $videoDetails);
			} else {
				$response = array('status'=> 'error', 'result'=> 'No data found');
			}
    	} catch(\Exception $e) {
    		$responce = array('status'=> 'error', 'result' => $e->getMessage());
    	}
    	echo json_encode($response);
    }
    //Video API End
}
