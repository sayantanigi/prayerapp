<?php
defined('BASEPATH') OR exit('No direct script are allowed');
class Manage_podcast extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Podcastmodel');
    }
    public function index() {
        $get_podcast=$this->Crud_model->GetData('all_podcasts');
        $get_category=$this->Crud_model->GetData('category');
        $header = array('title' => 'Podcast');
        $data = array(
            'heading' => 'Podcast',
            'get_podcast' => $get_podcast,
            //'get_category' => $get_category
        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/podcast/list',$data);
        $this->load->view('admin/footer');
    }
    public function ajax_manage_page() {
        $cond = "1=1";
        // $category = $_POST['SearchData6'];
        $create_date = $_POST['SearchData7'];
        // if($category != '') {
        //     $cond .=" and all_podcasts.podcast_cat_id = '".$category."' ";
        // }
        if($create_date!='') {
            $cond .=" and all_podcasts.created_date >= '".date('Y-m-d',strtotime($create_date))."' ";
        }
        $GetData = $this->Podcastmodel->get_datatables($cond);
        if(empty($_POST['start'])) {
            $no=0;
        } else {
            $no =$_POST['start'];
        }
        $data = array();
        foreach ($GetData as $row) {
            $btn = ''.'<a href=manage_podcast/update/'.base64_encode($row->id).' class="btn btn-sm bg-success-light"><i class="far fa-edit"></i></a>';
            $btn .= ' | '.'<a href=manage_podcast/view/'.base64_encode($row->id).' class="btn btn-sm bg-success-light"><i class="far fa-eye"></i></a>';
            $btn .= ' | '.'<span data-placement="right" class="btn btn-sm btn-danger" onclick="podcastDelete(this,'.$row->id.')"><i class="fa fa-trash"></i></span>';
            //$btn .= ' | '.'<span class="btn btn-sm bg-success-light" data-placement="right" class="btn btn-sm btn-success" onclick="podcastDetails(this,'.$row->id.')"><i class="fa fa-eye"></i></span>';
            if(!empty($row->podcast_cover_image)) {
                if(!file_exists("uploads/podcast/cover_image/".$row->podcast_cover_image)) {
                    $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
                } else {
                    $img ='<a href="'.base_url('uploads/podcast/cover_image/'.$row->podcast_cover_image).'" data-lightbox="roadtrip"><img class="rounded service-img mr-1"src="'.base_url('uploads/podcast/cover_image/'.$row->podcast_cover_image).'"><a>';
                }
            } else {
                $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
            }
            if(strlen($row->podcast_description)>100) {
                $desc = substr($row->podcast_description,0,70).'...';
            } else {
                $desc = $row->podcast_description;
            }
            $get_category = $this->Crud_model->get_single('category',"id='".$row->podcast_cat_id."'");
            @$cat_name = $get_category->category_name;
            $no++;
            $nestedData = array();
            $nestedData[] = $no;
            $nestedData[] = $img;
            //$nestedData[] = $cat_name;
            $nestedData[] = $row->podcast_name;
            $nestedData[] = ucwords($desc);
            $nestedData[] = date('d-m-Y h:i:s A',strtotime($row->created_date));
            $nestedData[] = $btn;
            $data[] = $nestedData;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Podcastmodel->count_all($cond),
            "recordsFiltered" => $this->Podcastmodel->count_filtered($cond),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function create() {
        $category = $this->Crud_model->GetData('category');
        $header = array('title'=> 'Add');
        $data = array(
            'heading'=>'Add New Podcast',
            'button'=>'Create',
            'user_id' => $_SESSION['afrebay_admin']['id'],
            'podcast_cat_id' =>set_value('podcast_cat_id'),
            'podcast_name' =>set_value('podcast_name'),
            'podcast_description' =>set_value('podcast_description'),
            'category' => $category,
            'id' =>set_value('id')
        );
        //print_r($data); die;
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/podcast/form',$data);
        $this->load->view('admin/footer');
    }
    public function create_action() {
        // print_r($this->input->post()); die();
        if(!empty($this->input->post())) {
            $get_data = $this->Crud_model->get_single('all_podcasts',"podcast_name = '".$_POST['podcast_name']."'");
            if(empty($get_data)) {
                if (!empty($_FILES['singer_image']['name'])) {
                    $uploadDir = getcwd() . '/uploads/podcast/singer_image/';
                    $src_simage = $_FILES['singer_image']['tmp_name'];
                    $filEncImg = time();
                    $avatar_simage = rand(0000, 9999) . "_" . $_FILES['singer_image']['name'];
                    $avatarsImage = str_replace(array('(', ')', ' '), '', $avatar_simage);
                    $dest_simage = getcwd() . '/uploads/podcast/singer_image/' . $avatarsImage;
                    if (move_uploaded_file($src_simage, $dest_simage)) {
                        $simgfile  = $avatarsImage;
                        // @unlink('uploads/podcast/singer_image/' . $_POST['old_simage']);
                        if (!empty($_POST['old_simage'])) {
                            @unlink($uploadDir . $_POST['old_simage']);
                        }
                    }
                } else {
                    $simgfile  = $_POST['old_simage'];
                }
                if (!empty($_FILES['cover_image']['name'])) {
                    $uploadDir = getcwd() . '/uploads/podcast/cover_image/';
                    $src_image = $_FILES['cover_image']['tmp_name'];
                    $filEncImg = time();
                    $avatar_image = rand(0000, 9999) . "_" . $_FILES['cover_image']['name'];
                    $avatarImage = str_replace(array('(', ')', ' '), '', $avatar_image);
                    $dest_image = getcwd() . '/uploads/podcast/cover_image/' . $avatarImage;
                    if (move_uploaded_file($src_image, $dest_image)) {
                        $_imgfile  = $avatarImage;
                        // @unlink('uploads/podcast/cover_image/' . $_POST['old_image']);
                        if (!empty($_POST['old_image'])) {
                            @unlink($uploadDir . $_POST['old_image']);
                        }
                    }
                } else {
                    $_imgfile  = $_POST['old_image'];
                }
                if (!empty($_FILES['podcast_file']['name'])) {
                    $uploadDir = getcwd() . '/uploads/podcast/podcast_file/';
                    $src_file = $_FILES['podcast_file']['tmp_name'];
                    $filEncFile = time();
                    $avatar_file = rand(0000, 9999) . "_" . $_FILES['podcast_file']['name'];
                    $avatarFile = str_replace(array('(', ')', ' '), '', $avatar_file);
                    $dest_file = getcwd() . '/uploads/podcast/podcast_file/' . $avatarFile;
                    if (move_uploaded_file($src_file, $dest_file)) {
                        $podcast_file  = $avatarFile;
                        if (!empty($_POST['old_podcast_file'])) {
                            @unlink($uploadDir . $_POST['old_podcast_file']);
                        }
                        // @unlink('uploads/podcast/podcast_file/' . $_POST['old_podcast_file']);
                    }
                } else {
                    $podcast_file  = $_POST['old_file'];
                }
                $data = array(
                    'user_id'=> $_SESSION['afrebay_admin']['id'],
                    //'podcast_cat_id' =>$_POST['podcast_cat_id'],
                    'podcast_name'=> $_POST['podcast_name'],
                    'podcast_description'=> $_POST['podcast_description'],
                    'podcast_singer_name'=> $_POST['podcast_singer_name'],
                    'podcast_singer_image'=> $simgfile,
                    'podcast_cover_image'=> $_imgfile,
                    'podcast_file'=> $podcast_file,
                    'created_date'=> date('Y-m-d H:i:s')
                );
                $this->Crud_model->SaveData('all_podcasts',$data);
                $this->session->set_flashdata('message', 'Podcast created successfully');
                // echo 1; exit;
                /*$last_id = $this->db->insert_id();
                if(!empty($last_id)) {
                    if ($_FILES['podcast_file']['name'] != '') {
                        $count = count($_FILES['podcast_file']['name']);
                        for ($i=0; $i < $count; $i++) {
                            $src = $_FILES['podcast_file']['tmp_name'][$i];
                            $filEnc = time();
                            $avatar = rand(0000, 9999) . "_" . $_FILES['podcast_file']['name'][$i];
                            $avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
                            $dest = getcwd() . '/uploads/podcast/podcast_file/' . $avatar1;
                            if (move_uploaded_file($src, $dest)) {
                                $file  = $avatar1;
                                @unlink('uploads/podcast/podcast_file/' . $_POST['old_podcast_file']);
                            }
                            $details_data = array(
                                'podcast_id'=> $last_id,
                                'content_title'=> $_POST['content_title'][$i],
                                'podcast_file'=> $file,
                                'created_date'=> date('Y-m-d H:m:s')
                            );
                            $this->Crud_model->SaveData('all_podcast_contents',$details_data);
                            $this->session->set_flashdata('message', 'Podcast created successfully');
                        }
                    } else {
                        $file = $_POST['old_podcast_file'];
                        $count = count($this->input->post('content_title'));
                        for ($i=0; $i < $count; $i++) {
                            $details_data = array(
                                'podcast_id'=> $last_id,
                                'content_title'=> $_POST['content_title'][$i],
                                'podcast_file'=> $file,
                                'created_date'=> date('Y-m-d H:m:s')
                            );
                            $this->Crud_model->SaveData('all_podcast_contents',$details_data);
                            $this->session->set_flashdata('message', 'Podcast created successfully');
                            echo "2"; exit;
                        }
                    }
                }*/
            }
        }
        redirect(base_url('admin/manage_podcast'));
    }
    public function get_value() {
        $podcast_data=$this->Crud_model->get_single('all_podcasts',"id='".$_POST['id']."'");
        if(!empty($podcast_data->podcast_image)) {
            if(!file_exists("uploads/podcast/coder".$podcast_data->podcast_image)) {
                $img ='<img class="rounded service-img mr-1" src="'.base_url('category/no_image.png').'">';
            } else {
                $img ='<img  class="rounded service-img mr-1" src="'.base_url('uploads/podcast/'.$podcast_data->podcast_image).'" >';
            }
        } else {
            $img ='<img class="rounded service-img mr-1" src="'.base_url('uploads/no_image.png').'">';
        }
        $data=array(
            'id'=>$podcast_data->id,
            'podcast_title'=>$podcast_data->podcast_title,
            'podcast_desc'=>$podcast_data->podcast_desc,
            'podcast_image'=>$podcast_data->podcast_image,
            'podcast_location'=>$podcast_data->podcast_location,
            'event_datetime'=>date('Y-m-d\TH:i', strtotime($podcast_data->event_datetime)),
            'image'=>$img,
            'old_image'=>$podcast_data->podcast_image,
        );
        echo json_encode($data);exit;
    }
    public function update($id) {
        $get_category=$this->Crud_model->GetData('category');
        $pod_id=base64_decode($id);
        $update_pod=$this->Crud_model->get_single('all_podcasts',"id = '".$pod_id."'");
        //print_r($update_pod); die();
        //$pod_content=$this->Crud_model->GetData('all_podcast_contents','',"podcast_id = '".$update_pod->id."'");
        $header=array('title'=>'update');
        $data=array(
            'heading'=>'Edit Podcast',
            'button'=>'Update',
            //'podcast_cat_id'=>set_value('podcast_cat_id',$update_pod->podcast_cat_id),
            'podcast_name'=>set_value('podcast_name',$update_pod->podcast_name),
            'podcast_description'=>set_value('podcast_description',$update_pod->podcast_description),
            'podcast_singer_name'=>set_value('podcast_singer_name',$update_pod->podcast_singer_name),
            'podcast_cover_image'=>set_value('podcast_cover_image',$update_pod->podcast_cover_image),
            'podcast_singer_image'=>set_value('podcast_singer_image',$update_pod->podcast_singer_image),
            'podcast_file'=>set_value('podcast_file',$update_pod->podcast_file),
            'id'=>$pod_id,
            //'pod_content'=>$pod_content,
            'category' => $get_category
        );
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/podcast/form',$data);
        $this->load->view('admin/footer');
    }
    /*public function update_action() {
        if(!empty($this->input->post())) {
            $get_data=$this->Crud_model->get_single_record('all_podcasts',"podcast_name = '".$_POST['podcast_name']."' and id != '".$_POST['id']."'");
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
                        $file  = $_POST['cover_image'];
                    }
                } else {
                    $file  = $_POST['old_image'];
                }
                if (!empty($_FILES['podcast_file']['name'] != '')) {
                    //print_r($_FILES['podcast_file']); die();
                    $src = $_FILES['podcast_file']['tmp_name'];
                    $filEnc = time();
                    $avatar = rand(0000, 9999) . "_" . $_FILES['podcast_file']['name'];
                    $avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
                    $dest = getcwd() . '/uploads/podcast/podcast_file/' . $avatar1;
                    if (move_uploaded_file($src, $dest)) {
                        $file_content  = $avatar1;
                        @unlink('uploads/podcast/podcast_file/' . $_POST['old_podcast_file']);
                    }
                } else {
                    $file_content  = $_POST['old_file'];
                }
                $data = array(
                    'user_id'=> $_SESSION['afrebay_admin']['id'],
                    'podcast_cat_id' =>$_POST['podcast_cat_id'],
                    'podcast_name'=> $_POST['podcast_name'],
                    'podcast_description'=> $_POST['podcast_description'],
                    'cover_image'=> $file,
                    'podcast_file'=> $file_content,
                    'created_date'=> date('Y-m-d H:i:s')
                );
                $this->Crud_model->SaveData('all_podcasts',$data,"id = '".$_POST['id']."'");
                $last_id=$_POST['id'];
                $this->Crud_model->DeleteData('all_podcast_contents',"podcast_id = '".$_POST['id']."'");
                if (!empty($_FILES['podcast_file']['name'] != '')) {
                    $count = count($_FILES['podcast_file']['name']);
                    for ($i=0; $i < $count; $i++) {
                        $src = $_FILES['podcast_file']['tmp_name'][$i];
                        $filEnc = time();
                        $avatar = rand(0000, 9999) . "_" . $_FILES['podcast_file']['name'][$i];
                        $avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
                        $dest = getcwd() . '/uploads/podcast/podcast_file/' . $avatar1;
                        if (move_uploaded_file($src, $dest)) {
                            $file_content  = $avatar1;
                            @unlink('uploads/podcast/podcast_file/' . $_POST['old_podcast_file']);
                        }
                        $details_data = array(
                            'podcast_id'=> $last_id,
                            'content_title'=> $_POST['content_title'][$i],
                            'podcast_file'=> $file_content,
                            'created_date'=> date('Y-m-d H:m:s')
                        );
                        $this->Crud_model->SaveData('all_podcast_contents',$details_data);
                        $this->session->set_flashdata('message', 'Podcast created successfully');
                    }
                } else {
                    $count = count($this->input->post('content_title'));
                    for ($i=0; $i < $count; $i++) {
                        $file_content = $_POST['old_podcast_file'][$i];
                        $details_data = array(
                            'podcast_id'=> $last_id,
                            'content_title'=> $_POST['content_title'][$i],
                            'podcast_file'=> $file_content,
                            'created_date'=> date('Y-m-d H:m:s')
                        );
                        $this->Crud_model->SaveData('all_podcast_contents',$details_data);
                        $this->session->set_flashdata('message', 'Podcast created successfully');
                        echo "2"; exit;
                    }
                }
                $this->session->set_flashdata('message', 'Podcast updated successfully');
            } else {
                $this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
            }
        }
        redirect(base_url('admin/manage_podcast'));
    }*/
    public function update_action() {
        if ($_FILES['cover_image']['name'] != '') {
            $src_image = $_FILES['cover_image']['tmp_name'];
            $filEncImg = time();
            $avatar_image = rand(0000, 9999) . "_" . $_FILES['cover_image']['name'];
            $avatarImage = str_replace(array('(', ')', ' '), '', $avatar_image);
            $dest_image = getcwd() . '/uploads/podcast/cover_image/' . $avatarImage;
            if (move_uploaded_file($src_image, $dest_image)) {
                $_imgfile  = $avatarImage;
                @unlink('uploads/podcast/cover_image/' . $_POST['old_image']);
            }
        } else {
            $_imgfile  = $_POST['old_image'];
        }
        if ($_FILES['podcast_file']['name'] != '') {
            $src_file = $_FILES['podcast_file']['tmp_name'];
            $filEncFile = time();
            $avatar_file = rand(0000, 9999) . "_" . $_FILES['podcast_file']['name'];
            $avatarFile = str_replace(array('(', ')', ' '), '', $avatar_file);
            $dest_file = getcwd() . '/uploads/podcast/podcast_file/' . $avatarFile;
            if (move_uploaded_file($src_file, $dest_file)) {
                $podcast_file  = $avatarFile;
                @unlink('uploads/podcast/podcast_file/' . $_POST['old_podcast_file']);
            }
        } else {
            $podcast_file  = $_POST['old_file'];
        }
        if ($_FILES['singer_image']['name'] != '') {
            $src_simage = $_FILES['singer_image']['tmp_name'];
            $filEncImg = time();
            $avatar_simage = rand(0000, 9999) . "_" . $_FILES['singer_image']['name'];
            $avatarsImage = str_replace(array('(', ')', ' '), '', $avatar_simage);
            $dest_simage = getcwd() . '/uploads/podcast/singer_image/' . $avatarsImage;
            if (move_uploaded_file($src_simage, $dest_simage)) {
                $simgfile  = $avatarsImage;
                @unlink('uploads/podcast/singer_image/' . $_POST['old_simage']);
            }
        } else {
            $simgfile  = $_POST['old_simage'];
        }
        $get_data=$this->Crud_model->get_single_record('all_podcasts',"podcast_name = '".$_POST['podcast_name']."' and id != '".$_POST['id']."'");
        if(empty($get_data)) {
            $data = array(
                //'user_id'=> $_SESSION['afrebay_admin']['id'],
                //'podcast_cat_id' =>$_POST['podcast_cat_id'],
                'podcast_name'=> $_POST['podcast_name'],
                'podcast_description'=> $_POST['podcast_description'],
                'podcast_singer_name'=> $_POST['podcast_singer_name'],
                'podcast_cover_image'=> $_imgfile,
                'podcast_file'=> $podcast_file,
                'podcast_singer_image'=> $simgfile,
                'created_date'=> date('Y-m-d H:i:s')
            );
            //print_r($_POST); die;
            $this->Crud_model->SaveData('all_podcasts',$data,"id='".$_POST['id']."'");
            $this->session->set_flashdata('message', 'Podcats updated successfully');
            //echo 1; exit;
        } else {
            $this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
            //echo 0; exit;
        }
        redirect(base_url('admin/manage_podcast'));
    }
    public function view($id) {
        $pod_id=base64_decode($id);
        $update_pod=$this->Crud_model->get_single('all_podcasts',"id = '".$pod_id."'");
        $pod_content=$this->Crud_model->GetData('all_podcast_contents','',"podcast_id = '".$update_pod->id."'");
        $header=array('title'=>'View');
        $data=array(
            'heading'=>'Podcast View',
            'pod_main'=>$update_pod,
            'pod_content'=>$pod_content,
        );
        $this->load->view('admin/header',$header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/podcast/details',$data);
        $this->load->view('admin/footer');
    }
    public function delete() {
        if(isset($_POST['cid'])) {
            $this->Crud_model->DeleteData('all_podcasts',"id='".$_POST['cid']."'");
            // $data = array('is_delete' => '2');
            // $this->Crud_model->SaveData('all_podcasts',$data,"id='".$_POST['id']."'");
            $this->session->set_flashdata('message', 'Event deleted successfully');
            echo 0; exit;
        }
    }
}
