<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Home extends MY_Controller {
	public function index() {
		$currentDate = date('Y-m-d');
		$data['banner'] = $this->db->query("SELECT * FROM banner WHERE status = 'Active' ORDER BY created_date DESC")->result_array();
		//$data['sliderprayer'] = $this->db->query("SELECT * FROM all_prayers ORDER BY created_date DESC LIMIT 3")->result_array();
		$data['prayerEvents'] = $this->db->query("SELECT * FROM all_prayers ORDER BY created_date DESC LIMIT 6")->result_array();
		$data['ourprayerEvents'] = $this->db->query("SELECT * FROM our_prayers")->row();
		$data['futureprayer'] = $this->db->query("SELECT * FROM all_prayers WHERE prayer_datetime > $currentDate ORDER BY created_date DESC LIMIT 6")->result_array();
		$this->load->view('include/header', $data);
		$this->load->view('home', $data);
		$this->load->view('include/footer', $data);
	}
	public function about_us() {
		$data['content']=$this->db->query("SELECT * FROM manage_cms WHERE id = '2'")->row();
		$this->load->view('include/header', $data);
		$this->load->view('about_us', $data);
		$this->load->view('include/footer', $data);
	}
	public function portfolio() {
		$data['ourprayerEvents'] = $this->db->query("SELECT * FROM our_prayers")->row();
		$data['portfolio']=$this->db->query("SELECT * FROM portfolio WHERE status = '1' AND is_delete = '1'")->result_array();
		$data['title'] = 'Portfolio';
		$this->load->view('include/header', $data);
		$this->load->view('portfolio', $data);
		$this->load->view('include/footer', $data);
	}
	public function guidelines() {
		$data['guidelines']=$this->db->query("SELECT * FROM manage_cms WHERE id = '4'")->row();
		$this->load->view('include/header', $data);
		$this->load->view('guidelines', $data);
		$this->load->view('include/footer', $data);
	}
	public function terms_and_condition() {
		$data['content']=$this->db->query("SELECT * FROM manage_cms WHERE id = '1'")->row();
		$this->load->view('include/header', $data);
		$this->load->view('terms_and_condition', $data);
		$this->load->view('include/footer', $data);
	}
	public function event_details($id) {
		$data['content']=$this->db->query("SELECT * FROM manage_cms WHERE id = '1'")->row();
		$data['prayerEvents'] = $this->db->query("SELECT * FROM all_prayers WHERE id ='$id'")->row();
		$this->load->view('include/header', $data);
		$this->load->view('event_details',$data);
		$this->load->view('include/footer', $data);
	}
	public function portfolio_details($id) {
		$data['content']=$this->db->query("SELECT * FROM manage_cms WHERE id = '1'")->row();
		$data['portfolioDetails'] = $this->db->query("SELECT * FROM portfolio WHERE id ='$id'")->row();
		$this->load->view('include/header', $data);
		$this->load->view('portfolio_details',$data);
		$this->load->view('include/footer', $data);
	}
	public function privacy_policy() {
		$data['content']=$this->db->query("SELECT * FROM manage_cms WHERE id = '3'")->row();
		$this->load->view('include/header', $data);
		$this->load->view('privacy_policy', $data);
		$this->load->view('include/footer', $data);
	}
	public function contact() {
		$this->load->view('include/header');
		$this->load->view('contact');
		$this->load->view('include/footer');
	}
	public function delete_account() {
		$this->load->view('include/header');
		$this->load->view('delete_page');
		$this->load->view('include/footer');
	}
	public function deleteFormSubmit() {
        $email = $this->input->post("email");
		$check = $this->db->query("SELECT userId FROM users WHERE email = '".$email."'")->result_array();
	    $userId=@$check[0]['userId'];
		if($userId != ''){
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
			echo $msg = "1";
		}
		else{
			echo $msg = "2";
		}
	}
	public function contactFormSubmit() {
		$fname = $this->input->post("name");
        $email = $this->input->post("email");
        $phone = $this->input->post("phone");
        $sub = $this->input->post("subject");
        $msg = $this->input->post("message");
        $contactFormData = array (
            'name' => $fname,
            'email' => $email,
            'phone' => $phone,
            'subject' => $sub,
            'message' => $msg,
			'created_date'=>date('Y-m-d H:i:s')
        );
        $result = $this->db->insert('contact_us', $contactFormData);
        $insert_id = $this->db->insert_id();
		// echo $insert_id;die;
        if(!empty($insert_id)) {
			$subject = $sub;
			$getOptionsSql = "SELECT * FROM `setting`";
			$setting = $this->db->query($getOptionsSql)->row();
			//$imagePath = base_url().'uploads/logo/Logo-Makutano-inblock.png';
			$admEmail = $setting->email;
			$address = $setting->address;
			$message = "
			<body>
				<div style='width:600px;margin: 0 auto;background: #fff; border: 1px solid #e6e6e6;'>
					<div style='padding: 30px 30px 15px 30px;box-sizing: border-box;'>
						<img src='cid:Logo' style='width:100px;float: right;margin-top: 0 auto;'>
						<h3 style='padding-top:40px; line-height: 30px;'>Greetings from<span style='font-weight: 900;font-size: 35px;color: #F44C0D; display: block;'>120xARMY</span></h3>
						<p style='font-size: 18px;'> Dear Admin,</p>
						<p style='font-size: 18px;'>Please find the below details for contact query.</p>
						<p style='font-size: 18px; margin: 0px;'>Name: $fname</p>
						<p style='font-size: 18px; margin: 0px;'>Email: $email</p>
						<p style='font-size: 18px; margin: 0px;'>Phone Number: $phone</p>
						<p style='font-size: 18px; margin: 0px;'>Message: $msg</p>
						<p style='font-size: 20px;'></p>
						<p style='font-size: 18px; margin: 0px; list-style: none'>Sincerly</p>
						<p style='font-size: 12px; margin: 0px; list-style: none'><b>120xARMY</b></p>
						<p style='font-size: 12px; margin: 0px; list-style: none'><b>Visit us:</b> <span>$address</span></p>
						<p style='font-size: 12px; margin: 0px; list-style: none'><b>Email us:</b> <span>$admEmail</span></p>
					</div>
					<table style='width: 100%;'>
						<tr>
							<td style='height:30px;width:100%; background: red;padding: 10px 0px; font-size:13px; color: #fff; text-align: center;'>Copyright &copy; <?=date('Y')?> 120xARMY. All rights reserved.</td>
						</tr>
					</table>
				</div>
			</body>";
			require 'vendor/autoload.php';
			$mail = new PHPMailer(true);
			try {
				$mail->CharSet = 'UTF-8';
				$mail->SetFrom($admEmail, '120xarmy');
				$mail->AddAddress($admEmail, '120xarmy');
                $mail->IsHTML(true);
                $mail->Subject = $subject;
				$mail->AddEmbeddedImage('assets/images/logo.png', 'Logo');
                $mail->Body = $message;
                //Send email via SMTP
                $mail->IsSMTP();
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                // $mail->Host       = "smtp.gmail.com";
                $mail->Host       = "smtp-relay.brevo.com";
                $mail->Port       = 587; //587 465
                $mail->Username   = "goutampaul@goigi.in";
                // $mail->Username   = "no-reply@goigi.com";
                $mail->Password   = "b7nNQ4Fk9XdAOcL3";
                // $mail->Password   = "wj8jeml3eu0z";
                $mail->send();
			} catch (Exception $e) {
				echo $msg = "Message could not be sent. Mailer Error: $mail->ErrorInfo";
			}
			echo $msg = "1";
        } else {
            echo $msg = "2";
        }
	}
	public function email_verification($id) {
		$givenotp = base64_decode(urldecode($id));
        $sql = "SELECT * FROM `users` WHERE userId = '".$givenotp."' AND status = '0' AND `email_verified` = '0'";
        $check = $this->db->query($sql)->num_rows();
		if ($check > 0) {
            //$usr = $this->db->query($sql)->row();
            $result = $this->db->query("UPDATE `users` SET `email_verified` = 1, `status` = 1 where `userId` = '".$givenotp."'");
            if ($result) {
                $this->session->set_flashdata('message', 'Your Email Address is verified successfully and your account is active.');
				redirect(base_url('/'), 'refresh');
            } else {
                $this->session->set_flashdata('message', 'Sorry! There is error verifying your Email Address!');
                redirect(base_url('/'), 'refresh');
            }
        } else {
            //$this->session->set_flashdata('message', 'Sorry! Activation link is expired!');
            $this->session->set_flashdata('message', 'Your Email Address is already verified.');
            redirect(base_url('/'), 'refresh');
        }
	}
	public function download() {
		$iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
		$Android= stripos($_SERVER['HTTP_USER_AGENT'],"Android");
		//check if user is using ipod, iphone or ipad...
		if( $iPod || $iPhone || $iPad ){
			//we send these people to Apple Store
			header('Location: https://apps.apple.com/us/app/120-army-prayer/id6478201470'); // <-apple store link here
		} else if($Android){
			//we send these people to Android Store
			header('Location: https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer'); // <-android store link here
		}
	}
	public function checkout($uid, $total) {
		$data = array(
			'user_id' => $uid,
			'total' => $total
		);
		$this->load->view('include/header', $data);
		$this->load->view('checkout', $data);
		$this->load->view('include/footer', $data);
	}
	public function completed() {
		$this->load->view('include/header');
		$this->load->view('completed');
		$this->load->view('include/footer');
	}
	public function cancel() {
		$this->load->view('include/header');
		$this->load->view('cancel');
		$this->load->view('include/footer');
	}
}