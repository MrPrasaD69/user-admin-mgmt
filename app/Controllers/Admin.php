<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\SongModel;
use App\Models\UserModel;

class Admin extends BaseController
{

    public function login()
    {
        if (!isset($_SESSION['admin_id'])) {
            return view('admin/login');
        } else {
            return redirect()->to(base_url() . "admin/dashboard");
        }
    }

    public function dashboard()
    {
        // if(empty($_SESSION['admin_id'])){
        //     return redirect()->to(base_url() . "admin/login");
        // }
        return view('admin/dashboard');
    }

    public function loginSubmit()
    {
        $mode = (!empty($_REQUEST['mode']) ? $_REQUEST['mode'] : '');
        $model_admin = new AdminModel;

        if (empty($mode)) {
            echo "400::Mode not Found!";
            exit;
        }

        if ($mode == 'L') {
            //Login Admin
            $check = $model_admin->where('username="' . $_REQUEST['login_username'] . '" AND status="1"')->first();
            if (empty($check)) {
                echo "400::Invalid Username!";
                exit;
            }

            if ($check['password'] != md5($_REQUEST['login_password'])) {
                echo "400::Invalid Password";
                exit;
            }

            $_SESSION['admin_id'] = $check['admin_id'];
            echo "200::Login Successful!";
            exit;
        } else {
            //Signup Admin
            $check = $model_admin->where('username="' . $_REQUEST['signup_username'] . '" AND status="1"')->first();

            if (!empty($check)) {
                echo "400::Username already Exists!";
                exit;
            }

            $data['username'] = $_REQUEST['signup_username'];
            $data['password'] = md5($_REQUEST['signup_password']);
            $model_admin->save($data);

            echo "200::Sign Up Successful!";
            exit;
        }
    }

    public function userList()
    {
        // if(empty($_SESSION['admin_id'])){
        //     return redirect()->to(base_url() . "admin/login");
        // }

        $data = array();
        $model_user = new UserModel;
        $data['result'] = $model_user->orderBy('user_id','desc')->paginate(5);
        $data['pager'] = $model_user->pager;
        // echo "<pre>";print_r($data['result']);exit;

        $currentPage = $data['pager']->getCurrentPage();
        $perPage = $data['pager']->getPerPage();
        $data['startIndex'] = ($currentPage - 1) * $perPage;

        return view('admin/userList', $data);
    }

    public function userAdd(){
        // if(empty($_SESSION['admin_id'])){
        //     return redirect()->to(base_url() . "admin/login");
        // }

        $model_user = new UserModel;
        $data = array();

        if(!empty($_REQUEST['id'])){
            $data['user_data'] = $model_user->where('user_id="'.$_REQUEST['id'].'"')->first();
        }

        return view('admin/userAdd',$data);
    }

    public function userSave(){
        $model_user = new UserModel;
        $allowed_extension = ['image/jpg','image/jpeg','image/png'];
        $allowed_size = 2 * 1024 * 1024; // 2MB in bytes

        if(!empty($_REQUEST['user_id'])){
            $user_data = $model_user->where('user_id="'.$_REQUEST['user_id'].'" ')->first();

            if(!empty($user_data)){
                //Update User

                $user_data['username'] = (!empty($_REQUEST['username']) ? $_REQUEST['username'] : '');
                $user_data['password'] = (!empty($_REQUEST['password']) ? md5($_REQUEST['password']) : $user_data['password']);
                
                //Logout User when password is changed
                if(!empty($_REQUEST['password'])){
                    if(!empty($_SESSION['user_id'])){
                        $this->destroySession($user_data['user_id']);
                        $this->destroySession($user_data['username']);   
                        $this->destroySession('token');
                    }
                    
                    $token_value = $this->generateToken();
                    $this->setSession('token',$token_value);
                    $user_data['token'] = $token_value;
                }

                $user_data['status'] = (!empty($_REQUEST['user_status']) ? $_REQUEST['user_status'] : '0');
                
                if(!empty($_FILES['profile_pic'])){
                    
                    if(!in_array($_FILES['profile_pic']['type'],$allowed_extension)){
                        echo "400::Only JPEG/JPG/PNG files allowed!";
                        exit;
                    }

                    if($_FILES['profile_pic']['size'] > $allowed_size){
                        echo "400::Images less than 2MB allowed!";
                        exit;
                    }

                    $image_name = $_FILES['profile_pic']['name'].time();
                    $folder = FCPATH.'/upload/profile_pic/';

                    if(!is_dir($folder)){
                        mkdir($folder,0777, true);
                    }

                    $path = $folder.$image_name;
                    move_uploaded_file($_FILES['profile_pic']['tmp_name'],$path);
                    $user_data['profile_pic'] = $image_name;
                }

                $model_user->update($user_data['user_id'],$user_data);
                echo "200::User Data Updated Successfully!";
                exit;
            }
            else{
                echo "400::User Data Not Found!";
                exit;
            }
        }
        else{
            //New User

            $data['username'] = (!empty($_REQUEST['username']) ? $_REQUEST['username'] : '');
            $data['password'] = (!empty($_REQUEST['password']) ? md5($_REQUEST['password']) : '');

            if(!empty($_FILES['profile_pic'])){
                
                if(!in_array($_FILES['profile_pic']['type'],$allowed_extension)){
                    echo "400::Only JPEG/JPG/PNG files allowed!";
                    exit;
                }

                if($_FILES['profile_pic']['size'] > $allowed_size){
                    echo "400::Images less than 2MB allowed!";
                    exit;
                }

                $image_name = $_FILES['profile_pic']['name'].time();
                $folder = FCPATH.'/upload/profile_pic/';

                if(!is_dir($folder)){
                    mkdir($folder,0777, true);
                }

                $path = $folder.$image_name;
                move_uploaded_file($_FILES['profile_pic']['tmp_name'],$path);
                $data['profile_pic'] = $image_name;
            }

            $model_user->save($data);
            echo "200::User Data Saved Successfully!";
            exit;
        }
    }

    public function listSong()
    {
        // if(empty($_SESSION['admin_id'])){
        //     return redirect()->to(base_url() . "admin/login");
        // }

        $model_song = new SongModel;
        $limit = (!empty($_REQUEST['length']) ? $_REQUEST['length'] : null);
        $start = (!empty($_REQUEST['start']) ? $_REQUEST['start'] : 0);
        $data = array();
        $condition = 'status="1"';

        if (!empty($_REQUEST['search']['value'])) {
            $condition .= 'and song_name LIKE "%' . $_REQUEST['search']['value'] . '%"';
        }

        if (!empty($limit)) {
            $song_data = $model_song->where($condition)->orderBy('song_id', 'desc')->findAll($limit, $start);
            $all_data = $model_song->where($condition)->countAllResults();

            if (!empty($song_data)) {
                foreach ($song_data as $key => $val) {
                    $data['data'][$key]['sr_no'] = $start + $key + 1;
                    $data['data'][$key]['song_id'] = $val['song_id'];
                    $data['data'][$key]['song_name'] = $val['song_name'];
                    $data['data'][$key]['song_link'] = $val['song_link'];
                    $data['data'][$key]['song_document'] = base_url() . "upload/songs/" . $val['song_document'];
                    $data['data'][$key]['action'] = '';
                }
                $data['recordsTotal'] = $all_data;
                $data['recordsFiltered'] = $all_data;
            } else {
                $data['data'] = $data;
                $data['recordsTotal'] = 0;
                $data['recordsFiltered'] = 0;
            }
            echo json_encode($data);
        } else {
            return view('admin/listSong');
        }
    }

    public function addSong(){
        $data = array();
        // if(empty($_SESSION['admin_id'])){
        //     return redirect()->to(base_url() . "admin/login");
        // }

        if(!empty($_REQUEST['id'])){
            $model = new SongModel;
            $data['song_data'] = $model->where('song_id="'.$_REQUEST['id'].'"')->first();
        }

        return  view('admin/addSong',$data);
    }

    public function saveSong(){
        $model_song = new SongModel;
        $allowed_extension = ['audio/mpeg'];
        $allowed_size = 5 * 1024 * 1024; // 5MB in bytes

        if(!empty($_REQUEST['song_id'])){
            $check = $model_song->where('song_id="'.$_REQUEST['song_id'].'"')->first();
            if(empty($check)){
                echo "404::Song Data not Found";
                exit;
            }

            $check['song_name'] = $_REQUEST['song_name'];
            $check['song_link'] = $_REQUEST['song_link'];
        }
        else{
            $check['song_name'] = $_REQUEST['song_name'];
            $check['song_link'] = $_REQUEST['song_link'];
        }

        if(!empty($_FILES['song_document'])){

            if(!in_array($_FILES['song_document']['type'],$allowed_extension)){
                echo "400::Only MP3 files allowed!";
                exit;
            }

            if($_FILES['song_document']['size'] > $allowed_size){
                echo "400::Audio Files less than 5MB allowed!";
                exit;
            }
            $song_doc = $_FILES['song_document']['name'].time();

            $folder = FCPATH.'/upload/songs/';

            if(!is_dir($folder)){
                mkdir($folder,0777, true);
            }

            $path = $folder.$song_doc;

            move_uploaded_file($_FILES['song_document']['tmp_name'], $path);
            $check['song_document'] = $song_doc;            
        }

        
        if(empty($_REQUEST['song_id'])){
            $model_song->save($check);
            echo "200::Song Saved Successfully!";
            exit;
        }
        else{
            $model_song->update($check['song_id'],$check);
            echo "200::Song Updated Successfully!";
            exit;
        }
    }

    public function deleteUser(){
        $model = new UserModel;
        $user_id = (!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '');

        if(!empty($user_id)){
            $check = $model->where('user_id="'.$user_id.'"')->first();
            if(!empty($check)){
                $check['status'] = '0';
                $model->update($user_id,$check);
                echo "200::User Deleted!";
                exit;
            }
            else{
                echo "400::User Data Not Found!";
                exit;
            }
        }
        else{
            echo "400::User Id Not Found!";
            exit;
        }
    }

    public function deleteSong(){
        $model = new SongModel;
        $song_id = (!empty($_REQUEST['song_id']) ? $_REQUEST['song_id'] : '');

        if(!empty($song_id)){
            $check = $model->where('song_id="'.$song_id.'"')->first();
            if(!empty($check)){
                $check['status'] = '0';
                $model->update($song_id,$check);
                echo "200::Song Deleted!";
                exit;
            }
            else{
                echo "400::Song Data Not Found!";
                exit;
            }
        }
        else{
            echo "400::Song Id Not Found!";
            exit;
        }
    }

    public function logout(){
        $this->destroySession('admin_id');

        return redirect()->to(base_url() . 'admin/login');
    }
}
