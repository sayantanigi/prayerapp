<?php
defined('BASEPATH')  OR exit('No direct script are allowed');
class Manage_videos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Videosmodel');
    }

    public function index() {
        $get_videos=$this->Crud_model->GetData('all_videos');
        $get_category=$this->Crud_model->GetData('category');
        $header = array('title' => 'Videos');
        $data = array(
            'heading' => 'Videos',
            'get_podcast' => $get_videos,
            'get_category' => $get_category
        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/video/list',$data);
        $this->load->view('admin/footer');
    }

    public function ajax_manage_page() {
        $cond = "1=1";
        $category = $_POST['SearchData6'];
        $create_date = $_POST['SearchData7'];
        if($category != '') {
            $cond .=" and all_videos.video_cat_id = '".$category."' ";
        }

        if($create_date!='') {
            $cond .=" and all_videos.created_date >= '".date('Y-m-d',strtotime($create_date))."' ";
        }

        $GetData = $this->Videosmodel->get_datatables($cond);
        if(empty($_POST['start'])) {
            $no=0;
        } else {
            $no =$_POST['start'];
        }

        $data = array();
        foreach ($GetData as $row) {
            $btn = ''.'<a href=manage_videos/update/'.base64_encode($row->id).' class="btn btn-sm bg-success-light"><i class="far fa-edit"></i></a>';
            $btn .= ' | '.'<a href=manage_videos/view/'.base64_encode($row->id).' class="btn btn-sm bg-success-light"><i class="far fa-eye"></i></a>';
            $btn .= ' | '.'<span data-placement="right" class="btn btn-sm btn-danger" onclick="videosDelete(this,'.$row->id.')"><i class="fa fa-trash"></i></span>';
            //$btn .= ' | '.'<span class="btn btn-sm bg-success-light" data-placement="right" class="btn btn-sm btn-success" onclick="podcastDetails(this,'.$row->id.')"><i class="fa fa-eye"></i></span>';
            if(!empty($row->video_cover_image)) {
                if(!file_exists("uploads/videos/cover_image/".$row->video_cover_image)) {
                    $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
                } else {
                    $img ='<a href="'.base_url('uploads/videos/cover_image/'.$row->video_cover_image).'" data-lightbox="roadtrip"><img class="rounded service-img mr-1"src="'.base_url('uploads/videos/cover_image/'.$row->video_cover_image).'"><a>';
                }
            } else {
                $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
            }
            if(strlen($row->videos_description)>100) {
                $desc = substr($row->videos_description,0,70).'...';
            } else {
                $desc = $row->videos_description;
            }
            $get_category = $this->Crud_model->get_single('category',"id='".$row->videos_cat_id."'");
            @$cat_name = $get_category->category_name;
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $img;
            //$nestedData[] = $cat_name;
            $nestedData[] = $row->videos_name;
            $nestedData[] = ucwords($desc);
            $nestedData[] = date('d-m-Y h:i:s A',strtotime($row->created_date));
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Videosmodel->count_all($cond),
            "recordsFiltered" => $this->Videosmodel->count_filtered($cond),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function create() {
        $category = $this->Crud_model->GetData('category');
        $header = array('title'=> 'Add');
        $data = array(
            'heading'=>'Add New Video',
            'button'=>'Create',
            'user_id' => $_SESSION['afrebay_admin']['id'],
            'videos_cat_id' =>set_value('videos_cat_id'),
            'videos_name' =>set_value('videos_name'),
            'videos_description' =>set_value('videos_description'),
            'category' => $category,
            'id' =>set_value('id')
        );
        //print_r($data); die;
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/video/form',$data);
        $this->load->view('admin/footer');
    }

    public function create_action() {
        if(!empty($this->input->post())) {
            $get_data = $this->Crud_model->get_single('all_videos',"videos_name = '".addslashes($_POST['videos_name'])."'");
            if(empty($get_data)) {
                if (!empty($_FILES['videos_file']['name'])) {
                    $src = $_FILES['videos_file']['tmp_name'];
                    $filEnc = time();
                    $avatar = rand(0000, 9999) . "_" . $_FILES['videos_file']['name'];
                    $avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
                    $dest = getcwd() . '/uploads/videos/videos_file/' . $avatar1;
                    if (move_uploaded_file($src, $dest)) {
                        $file  = $avatar1;
                        @unlink('uploads/videos/videos_file/' . $_POST['old_videos_file']);
                    }
                    if(!empty($file)) {
                        $file = $file;
                    } else {
                        $link = "";
                    }


                    if (!empty($_FILES['cover_image']['name'] != '')) {
                        $src_image = $_FILES['cover_image']['tmp_name'];
                        $filEncImg = time();
                        $avatar_image = rand(0000, 9999) . "_" . $_FILES['cover_image']['name'];
                        $avatarImage = str_replace(array('(', ')', ' '), '', $avatar_image);
                        $dest_image = getcwd() . '/uploads/videos/cover_image/' . $avatarImage;
                        if (move_uploaded_file($src_image, $dest_image)) {
                            $_imgfile  = $avatarImage;
                            @unlink('uploads/videos/cover_image/' . $_POST['old_cover_image']);
                        }
                    } else {
                        $_imgfile  = '';
                    }





                    $details_data = array(
                        'user_id'=> $_SESSION['afrebay_admin']['id'],
                        //'videos_cat_id' =>$_POST['videos_cat_id'],
                        'videos_name'=> $_POST['videos_name'],
                        'videos_description'=> $_POST['videos_description'],
                        //'videos_type'=> $_POST['videos_type'],
                        //'videos_link'=> $_POST['videos_link'],
                        'videos_file'=> $file,
                        'video_cover_image'=>$_imgfile,
                        'created_date'=> date('Y-m-d H:m:s')
                    );
                    $this->Crud_model->SaveData('all_videos',$details_data);
                    $this->session->set_flashdata('message', 'Video created successfully');
                } else {
                    if(!empty($file)) {
                        $file = "";
                    } else {
                        $link = $_POST['videos_link'];
                    }
                    $details_data = array(
                        'user_id'=> $_SESSION['afrebay_admin']['id'],
                        //'videos_cat_id' =>$_POST['videos_cat_id'],
                        'videos_name'=> $_POST['videos_name'],
                        'videos_description'=> $_POST['videos_description'],
                        //'videos_type'=> $_POST['videos_type'],
                        //'videos_link'=> $_POST['videos_link'],
                        'videos_file'=> $file,
                        'created_date'=> date('Y-m-d H:m:s')
                    );
                    $this->Crud_model->SaveData('all_videos',$details_data);
                    $this->session->set_flashdata('message', 'Video created successfully');
                }
            }
        }
        redirect(base_url('admin/manage_videos'));
    }

    /*public function get_value() {
        $videos_data=$this->Crud_model->get_single('all_videos',"id='".$_POST['id']."'");
        if(!empty($videos_data->videos_image)) {
            if(!file_exists("uploads/videos/coder".$videos_data->videos_image)) {
                $img ='<img class="rounded service-img mr-1" src="'.base_url('category/no_image.png').'">';
            } else {
                $img ='<img  class="rounded service-img mr-1" src="'.base_url('uploads/videos/'.$videos_data->videos_image).'" >';
            }
        } else {
            $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
        }
        $data=array(
            'id'=>$videos_data->id,
            'videos_title'=>$videos_data->videos_title,
            'videos_desc'=>$videos_data->videos_desc,
            'videos_image'=>$videos_data->videos_image,
            'videos_location'=>$videos_data->videos_location,
            'event_datetime'=>date('Y-m-d\TH:i', strtotime($videos_data->event_datetime)),
            'image'=>$img,
            'old_image'=>$videos_data->podcast_image,
        );
        echo json_encode($data);exit;
    }*/

    public function update($id) {
        $get_category=$this->Crud_model->GetData('category');
        $vid_id=base64_decode($id);
        $update_vid=$this->Crud_model->get_single('all_videos',"id = '".$vid_id."'");
        $header=array('title'=>'update');
        $data=array(
            'heading'=>'Edit Video',
            'button'=>'Update',
            'videos_name'=>set_value('videos_name',$update_vid->videos_name),
            'videos_description'=>set_value('videos_description',$update_vid->videos_description),
            'video_cover_image'=>set_value('videos_file',$update_vid->video_cover_image),
            'videos_file'=>set_value('videos_file',$update_vid->videos_file),
            'id'=>$vid_id,
            'category' => $get_category
        );
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/video/form',$data);
        $this->load->view('admin/footer');
    }

    public function update_action() {
        if($_FILES['videos_file']['name']!='' ) {
			$src = $_FILES['videos_file']['tmp_name'];
            $filEnc = time();
            $avatar = rand(0000, 9999) . "_" . $_FILES['videos_file']['name'];
            $avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
            $dest = getcwd() . '/uploads/videos/videos_file/' . $avatar1;
			if (move_uploaded_file($src, $dest)) {
                $file  = @$avatar1;
                @unlink('uploads/videos/videos_file/' . $_POST['old_videos_file']);
            }
		} else {
			$file  = $_POST['old_videos_file'];
		}


        if ($_FILES['cover_image']['name'] != '') {
            $src_image = $_FILES['cover_image']['tmp_name'];
            $filEncImg = time();
            $avatar_image = rand(0000, 9999) . "_" . $_FILES['cover_image']['name'];
            $avatarImage = str_replace(array('(', ')', ' '), '', $avatar_image);
            $dest_image = getcwd() . '/uploads/videos/cover_image/' . $avatarImage;
            if (move_uploaded_file($src_image, $dest_image)) {
                $_imgfile  = $avatarImage;
                @unlink('uploads/videos/cover_image/' . $_POST['old_image']);
            }
        } else {
            $_imgfile  = $_POST['old_cover_image'];
        }







		$get_data=$this->Crud_model->get_single_record('all_videos',"videos_name = '".addslashes($_POST['videos_name'])."' and id != '".$_POST['id']."'");
		if(empty($get_data)) {
			$data = array(
                'user_id'=> $_SESSION['afrebay_admin']['id'],
                'videos_name'=> $_POST['videos_name'],
                'videos_description'=> $_POST['videos_description'],
                'videos_file'=> @$file,
                'video_cover_image'=>@$_imgfile,
                'updated_date'=> date('Y-m-d H:i:s')
            );
			$this->Crud_model->SaveData('all_videos', $data, "id = '".$_POST['id']."'");
			$this->session->set_flashdata('message', 'Videos updated successfully');
			//echo 1; exit;
		} else{
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
			//echo 0; exit;
		}
		redirect(base_url('admin/manage_videos'));
    }

    public function view($id) {
        $vid_id=base64_decode($id);
        $update_vid=$this->Crud_model->get_single('all_videos',"id = '".$vid_id."'");
        //$vid_content=$this->Crud_model->GetData('all_videos_contents','',"videos_id = '".$update_vid->id."'");
        $header=array('title'=>'View');
        $data=array(
            'heading'=>'Videos View',
            'vid_main'=>$update_vid,
            //'vid_content'=>$vid_content,
        );
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/video/details',$data);
        $this->load->view('admin/footer');
    }

    public function delete() {
        if(isset($_POST['cid'])) {
            $this->Crud_model->DeleteData('all_videos',"id='".$_POST['cid']."'");
            // $data = array('is_delete' => '2');
            // $this->Crud_model->SaveData('all_videos',$data,"id='".$_POST['id']."'");
            $this->session->set_flashdata('message', 'Videos deleted successfully');
            echo 0; exit;
        }
    }
}
