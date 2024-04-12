<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Home extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Mymodel');
		$this->load->model('post_job_model');
		$this->load->model('Users_model');
	}

	public function home_list() {
		try {
			$todaysDate = date('Y-m-d');
			$datetime1 = new DateTime();
			$upcoming_events = $this->db->query("SELECT all_prayers.id, users.organizername, all_prayers.prayer_name, all_prayers.prayer_description, all_prayers.prayer_image, all_prayers.prayer_subheading, all_prayers.prayer_datetime, all_prayers.prayer_location FROM all_prayers LEFT JOIN users ON all_prayers.user_id = users.userId WHERE all_prayers.status = '1' AND all_prayers.is_delete = '1' AND all_prayers.prayer_datetime > '".$todaysDate."'")->result_array();
			if(!empty($upcoming_events)) {
				foreach ($upcoming_events as $keyue => $uevalue) {
					if(!empty($uevalue['prayer_image'])) {
						$uevalue['prayer_image'] = base_url().'uploads/prayer/'.$uevalue['prayer_image'];
					} else {
						$uevalue['prayer_image'] = base_url().'uploads/no_image.png';
					}
					$uevalue['prayer_datetime'] = date('d F Y H:i', strtotime($uevalue['prayer_datetime']));
					$uevalue['countdown'] = $datetime1->diff(new DateTime(date('Y-m-d h:i a', strtotime($uevalue['prayer_datetime']))))->format('%a days, %h:%i Hour');
					$returnue[$keyue] = $uevalue;
				}
			} else {
				$returnue = "";
			}
			$data['upcoming_events'] = $returnue;

			//$prayer_wall = $this->db->query("SELECT id, user_id, prayer_name, prayer_description, prayer_location, prayer_image, prayer_subheading, prayer_datetime FROM all_prayers WHERE status = '1' AND is_delete = '1'")->result_array();
			$prayer_wall = $this->db->query("SELECT all_prayers.id, all_prayers.user_id, all_prayers.prayer_name, all_prayers.prayer_description, all_prayers.prayer_location, all_prayers.prayer_image, all_prayers.prayer_subheading, all_prayers.prayer_datetime, count(user_joined_event.id) as count FROM all_prayers LEFT JOIN user_joined_event ON all_prayers.id = user_joined_event.event_id WHERE all_prayers.status = '1' AND all_prayers.is_delete = '1' group by all_prayers.id")->result_array();
			if(!empty($prayer_wall)) {
				foreach ($prayer_wall as $keypw => $pwvalue) {
					if(!empty($pwvalue['prayer_image'])) {
						$pwvalue['prayer_image'] = base_url().'uploads/prayer/'.$pwvalue['prayer_image'];
					} else {
						$pwvalue['prayer_image'] = base_url().'uploads/no_image.png';
					}
					
					$pwvalue['prayer_datetime'] = date('d F Y H:i', strtotime($pwvalue['prayer_datetime']));
					$returnpw[$keypw] = $pwvalue;
				}
			} else {
				$returnpw = "";
			}
			$data['prayer_wall'] = $returnpw;

			$latest_podcast = $this->db->query("SELECT all_podcasts.id, all_podcasts.user_id, category.category_name, all_podcasts.podcast_name, all_podcasts.podcast_description, all_podcasts.podcast_cover_image FROM all_podcasts LEFT JOIN category ON all_podcasts.podcast_cat_id = category.id WHERE all_podcasts.status = '1' AND all_podcasts.is_delete = '1'")->result_array();
			if(!empty($latest_podcast)) {
				foreach ($latest_podcast as $keylp => $lpvalue) {
					if(!empty($lpvalue['podcast_cover_image'])) {
						$lpvalue['podcast_cover_image'] = base_url().'uploads/podcast/cover_image/'.$lpvalue['podcast_cover_image'];
					} else {
						$lpvalue['podcast_cover_image'] = base_url().'uploads/no_image.png';
					}
					
					$returnlp[$keylp] = $lpvalue;
				}
			} else {
				$returnlp = "";
			}
			$data['latest_podcast'] = $returnlp;

			//$latest_videos = $this->db->query("SELECT all_videos.id, users.organizername, users.profilePic, category.category_name, all_videos.video_cover_image, all_videos.videos_name, all_videos.videos_description, all_videos.videos_file, all_videos.videos_link, all_videos.view_count FROM all_videos JOIN category ON all_videos.videos_cat_id = category.id JOIN users ON all_videos.user_id = users.userId WHERE all_videos.status = '1' AND all_videos.is_delete = '1'")->result_array();
			$latest_videos = $this->db->query("SELECT all_videos.id, users.organizername, users.profilePic, all_videos.video_cover_image, all_videos.videos_name, all_videos.videos_description, all_videos.videos_file, all_videos.videos_link, all_videos.view_count FROM all_videos LEFT JOIN users ON all_videos.user_id = users.userId WHERE all_videos.status = '1' AND all_videos.is_delete = '1' ORDER BY id DESC")->result_array();
			if(!empty($latest_videos)) {
				foreach ($latest_videos as $keylv => $lvvalue) {
					if(!empty($lvvalue['profilePic'])) {
						$lvvalue['profilePic'] = base_url().'uploads/users/'.$lvvalue['profilePic'];
					} else {
						$lvvalue['profilePic'] = base_url().'uploads/no_image.png';
					}
					if(!empty($lvvalue['video_cover_image'])) {
						$lvvalue['video_cover_image'] = base_url().'uploads/videos/cover_image/'.$lvvalue['video_cover_image'];
					} else {
						$lvvalue['video_cover_image'] = base_url().'uploads/no_image.png';
					}
					if(!empty($lvvalue['videos_file'])) {
						$lvvalue['videos_file'] = base_url().'uploads/videos/videos_file/'.$lvvalue['videos_file'];
					} else {
						$lvvalue['videos_file'] = base_url().'uploads/no_image.png';
					}
					$returnlv[$keylv] = $lvvalue;
				}
			} else {
				$returnlv = "";
			}
			$data['latest_videos'] = $returnlv;

	        $response = array('status'=> 'success','result'=> $data);
		} catch (\Exception $e) {
			$response = array('status'=> 'error','result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function about_us() {
		try {
			$getAboutData = $this->db->query("SELECT * FROM manage_cms WHERE id = 2 and status='Active'")->result_array();
			if(!empty($getAboutData)) {
				$response = array('status'=> 'success', 'result'=> $getAboutData);
			} else {
				$aboutData = array('status'=> 'error', 'result'=> 'No Data Found');
			}
			
		} catch (\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function contact() {
		try {
			$getContactData = $this->db->query("SELECT * FROM setting")->result_array();
			if(!empty($getContactData)) {
				$contactData = array();
				foreach ($getContactData as $abtKey => $abtValue) {
					$contactData[$abtKey]['website_name'] = $abtValue['website_name'];
					$contactData[$abtKey]['phone'] = ucwords($abtValue['phone']);
					$contactData[$abtKey]['email'] = $abtValue['email'];
					$contactData[$abtKey]['address'] = strip_tags($abtValue['address']);
				}
			} else {
				$contactData = 'No Data Found';
			}
			$response = array('status'=> 'success', 'result'=> $contactData);
		} catch (\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function save_contact() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$data = array(
				'name'=> $formdata['name'],
				'email'=> $formdata['email'],
				'subject'=> $formdata['subject'],
				'message'=> $formdata['message'],
			);
			$this->Mymodel->insert('contact_us', $data);
			$insert_id = $this->db->insert_id();
			$get_setting=$this->Crud_model->get_single('setting');
			if(!empty($insert_id)) {
				$subject = $formdata['subject'];
				$imagePath = base_url().'uploads/logo/'.$get_setting->flogo;
				$message = "<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'><tbody> <tr><td align='center'><table class='col-600' width='600' border='0' align='center' cellpadding='0' cellspacing='0' style='margin-left:20px; margin-right:20px; border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9; border-top:2px solid #232323'> <tbody> <tr> <td height='35'></td> </tr> <tr> <td align='left' style='padding:5px 10px;font-family: Raleway, sans-serif; font-size:16px; font-weight: bold; color:#2a3a4b;'><img src='" . $imagePath . "' style='width: 250px'/></td> </tr> <tr> <td height='35'></td> </tr> <tr> <td align='left' style='padding:5px 10px;font-family: Raleway, sans-serif; font-size:16px; font-weight: bold; color:#2a3a4b;'>Hello Team,</td> </tr> <tr> <td height='10'></td> </tr> <tr> <td align='left' style='padding:5px 10px;font-family: Lato, sans-serif; font-size:16px; color:#444; line-height:24px; font-weight: 400;'> Please find the below contact form details. </td> </tr> </tbody> </table> </td> </tr> <tr> <td align='center'> <table class='col-600' width='600' border='0' align='center' cellpadding='0' cellspacing='0' style='margin-left:20px; margin-right:20px; border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9; border-bottom:2px solid #232323'> <tbody> <tr> <td height='10'></td> </tr> <tr> <td align='left' style='padding:5px 10px;font-family: Raleway, sans-serif; font-size:16px; font-weight: bold; color:#2a3a4b;'>Name : ".$formdata['name'].",</td> </tr> <tr> <td height='10'></td> </tr> <tr> <td align='left' style='padding:5px 10px;font-family: Raleway, sans-serif; font-size:16px; font-weight: bold; color:#2a3a4b;'>Email : ".$formdata['email'].",</td> </tr> <tr> <td height='10'></td> </tr> <tr> <td align='left' style='padding:5px 10px;font-family: Raleway, sans-serif; font-size:16px; font-weight: bold; color:#2a3a4b;'>".$formdata['message'].",</td> </tr> <tr> <td height='10'></td> </tr> <tr> <td align='left' style='padding:0 10px;font-family: Lato, sans-serif; font-size:14px; color:#232323; line-height:24px; font-weight: 700;'> Sincerely, </td> </tr> <tr> <td align='left' style='padding:0 10px;font-family: Lato, sans-serif; font-size:14px; color:#232323; line-height:24px; font-weight: 700;'>".$formdata['name']."</td> </tr> <tr> <td height='30'></td> </tr> </tbody> </table> </td> </tr> </tbody> </table>";
				require 'vendor/autoload.php';
				$mail = new PHPMailer(true);
				$mail->CharSet = 'UTF-8';
				$mail->SetFrom($formdata['email']);
				$mail->AddAddress('info@120army.com', '120 Army');
				$mail->IsHTML(true);
				$mail->Subject = $subject;
				$mail->Body = $message;
				$mail->IsSMTP();
				$mail->SMTPAuth   = true;
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
				$mail->Host = "mail.120army.com";
				$mail->Port = 587; //587 465
				$mail->Username = "info@120army.com";
				$mail->Password = "Y&u,nPsT4JW6";
				$mail->send();
				if(!$mail->send()) {
					$response = array('status'=> 'error', 'result'=>'Your message could not be sent. Please, try again later.');
				} else {
					$response = array('status'=> 'success', 'result'=>'The email message was sent.');
				}
			}
		} catch (\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function privacy_policy() {
		try {
			$getPrivacyData = $this->db->query("SELECT * FROM manage_cms WHERE id = 3 and status='Active'")->result_array();
			if(!empty($getPrivacyData)) {
				$response = array('status'=> 'success', 'result'=> $getPrivacyData);
			} else {
				$aboutData = array('status'=> 'error', 'result'=> 'No Data Found');
			}
			
		} catch (\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function term_and_conditions() {
		try {
			$getTemsData = $this->db->query("SELECT * FROM manage_cms WHERE id = 1 and status='Active'")->result_array();
			if(!empty($getTemsData)) {
				$response = array('status'=> 'success', 'result'=> $getTemsData);
			} else {
				$aboutData = array('status'=> 'error', 'result'=> 'No Data Found');
			}
			
		} catch (\Exception $e) {
			$response = array('status'=> 'error', 'result'=> $e->getMessage());
		}
		echo json_encode($response);
	}

	public function get_faq() {
		$id = $_POST['id'];
		$content = $this->db->query("SELECT * FROM faq WHERE id = '".$id."'")->row();
		$data = array(
			'question' => $content->question,
			'answer' => $content->answer
		);
		echo json_encode($data);
	}
}
