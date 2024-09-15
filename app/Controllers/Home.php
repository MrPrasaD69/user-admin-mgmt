<?php

namespace App\Controllers;
use App\Models\CompanyModel;
use App\Models\SongModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function dashboard(){
        // if(empty($_SESSION['user_id'])){
        //     return redirect()->to(base_url()."home/login");
        // }
        if(!empty($_SESSION['user_id'])){
            $model_user = new UserModel;
            $check = $model_user->where('user_id="'.$_SESSION['user_id'].'"')->first();
            if(!empty($check) && !empty($check['token']) && isset($_SESSION['token'])){
                if($check['token'] != $_SESSION['token']){
                    $this->destroySession('token');
                    $this->destroySession('user_id');
                    $this->destroySession('username');
                    return redirect()->to(base_url().'home/login');
                }
            }
        }
        
        return view('dashboard');
    }

    public function getUsers(){
        
        return view('userList');
    }

    public function userList(){
        $data = array();
        $limit = (!empty($_REQUEST['length']) ? (int)$_REQUEST['length'] : null);
        $start = (!empty($_REQUEST['start']) ? (int)$_REQUEST['start'] : 0);
        $model = new UserModel;
        
        if(!empty($_REQUEST['search']['value'])){
            
            $user_data = $model->where('first_name LIKE "%'.$_REQUEST['search']['value'].'%"')->findAll($limit,$start);
            $all_data = $model->where('first_name LIKE "%'.$_REQUEST['search']['value'].'%"')->countAllResults();
        }
        else if(!empty($_REQUEST['last_name'])){
            
            $user_data = $model->where('last_name LIKE "%'.$_REQUEST['last_name'].'%"')->findAll($limit,$start);
            $all_data = $model->where('last_name LIKE "%'.$_REQUEST['last_name'].'%"')->countAllResults();
        }
        else{
            $user_data = $model->findAll($limit,$start);
            $all_data = $model->countAllResults();
        }

        if(!empty($user_data)){
            foreach($user_data as $key => $value){
                $data['data'][$key]['user_id'] = $value['user_id'];
                $data['data'][$key]['first_name'] = $value['first_name'];
                $data['data'][$key]['last_name'] = $value['last_name'];
            }
            $data['recordsTotal'] = $all_data;
            $data['recordsFiltered'] = $all_data;
        }
        else{
            $data['data'] = $data;
            $data['recordsTotal'] = 0;
            $data['recordsFiltered'] = 0;
        }
        echo json_encode($data);
    }


    public function signup(){
        // if(!isset($_SESSION['user_id'])){
            return view('signup');
        // }
        
        // return redirect()->to(base_url()."home/dashboard");
    }

    public function login(){
        // if(!isset($_SESSION['user_id'])){
            return view('login');
        // }
        // return redirect()->to(base_url()."home/dashboard");
    }

    public function loginSubmit(){
        $model_user = new UserModel;
        $mode = (!empty($_REQUEST['mode']) ? $_REQUEST['mode'] : '');        
        $username = (!empty($_REQUEST['username']) ? $_REQUEST['username'] : '');
        $password = (!empty($_REQUEST['password']) ? $_REQUEST['password'] : '');

        if(!empty($mode)){

            if($mode=='L'){ //Login
                                
                $check = $model_user->where('username="'.$username.'" AND status="1"')->first();

                if(empty($check)){
                    echo "400::Invalid Username!";
                    exit;
                }

                if($check['password'] != md5($password)){
                    echo "400::Invalid Password";
                    exit;
                }

                

                //Token for handling users
                $token_value = $this->generateToken();              
                $check['is_pass_change'] = 'N';
                $check['token'] = $token_value;
                $model_user->update($check['user_id'],$check);

                $this->setSession('token',$token_value);             
                $this->setSession('user_id',$check['user_id']);
                $this->setSession('username',$check['username']);

                return redirect()->to(base_url().'home/dashboard');
                // echo "200::Login Successful!";
                // exit;
            }
            else{
                //Signup
                $check = $model_user->where('username="'.$username.'" AND status="1"')->first();
                
                if(!empty($check)){
                    echo "400::Username already Exists!";
                    exit;
                }

                $data['username'] = $username;
                $data['password'] = md5($password);
                $model_user->save($data);

                $last = $model_user->orderBy('user_id','desc')->first();

                //Token for handling users
                $token_value = $this->generateToken();              
                $last['is_pass_change'] = 'N';
                $last['token'] = $token_value;
                $model_user->update($last['user_id'],$last);

                $this->setSession('user_id',$last['user_id']);
                $this->setSession('username',$last['username']);
                $this->setSession('token',$token_value);

                echo "200::Sign up Successful!";
                exit;
            }
        }
        else{
            echo "400::Mode not found!";
            exit;
        }

    }

    public function listSong(){
        
        // if(empty($_SESSION['user_id'])){
        //     return redirect()->to(base_url()."home/login");
        // }
        if(!empty($_SESSION['user_id'])){
            $model_user = new UserModel;
            $check = $model_user->where('user_id="'.$_SESSION['user_id'].'"')->first();
            if(!empty($check)){
                if($check['token'] != $_SESSION['token']){
                    $this->destroySession('token');
                    $this->destroySession('user_id');
                    $this->destroySession('username');
                    return redirect()->to(base_url().'home/login');
                }
            }
        }

        $model_song = new SongModel;
        $limit = (!empty($_REQUEST['length']) ? $_REQUEST['length'] : null);
        $start = (!empty($_REQUEST['start']) ? $_REQUEST['start'] : 0);
        $data = array();
        $condition = 'status="1"';

        if(!empty($_REQUEST['search']['value'])){
            $condition .='and song_name LIKE "%'.$_REQUEST['search']['value'].'%"';
        }

        if(!empty($limit)){
            $song_data = $model_song->where($condition)->orderBy('song_id','desc')->findAll($limit,$start);
            $all_data = $model_song->where($condition)->countAllResults();

            if(!empty($song_data)){
                foreach($song_data as $key=>$val){
                    $data['data'][$key]['sr_no'] = $start + $key+1;
                    $data['data'][$key]['song_id'] = $val['song_id'];
                    $data['data'][$key]['song_name'] = $val['song_name'];
                    $data['data'][$key]['song_link'] = $val['song_link'];
                    $data['data'][$key]['song_document'] = base_url()."upload/songs/".$val['song_document'];
                }
                $data['recordsTotal'] = $all_data;
                $data['recordsFiltered'] = $all_data;
                
            }
            else{
                $data['data'] = $data;
                $data['recordsTotal'] = 0;
                $data['recordsFiltered'] = 0;
            }
            echo json_encode($data);
        }
        else{
            return view('listSong');
        }
    }

    public function songDetail(){
        $data = array();
        $model = new SongModel;

        if(!empty($_REQUEST['id'])){
            $data['song_data'] = $model->where('song_id="'.$_REQUEST['id'].'" AND status="1"')->first();
        }
        
        return view('songDetail',$data);
    }

    public function uploadProfile(){
        // if(empty($_SESSION['user_id'])){
        //     return redirect()->to(base_url()."home/login");
        // }
        if(!empty($_SESSION['user_id'])){
            $model_user = new UserModel;
            $check = $model_user->where('user_id="'.$_SESSION['user_id'].'"')->first();
            if(!empty($check)){
                if($check['token'] != $_SESSION['token']){
                    $this->destroySession('token');
                    $this->destroySession('user_id');
                    $this->destroySession('username');
                    return redirect()->to(base_url().'home/login');
                }
            }
        }

        return view('uploadProfile');
    }

    public function uploadProfilePicture(){
        $model_user = new UserModel;
        $allowed_extension = ['image/jpg','image/jpeg','image/png'];
        $allowed_size = 2 * 1024 * 1024; // 2MB in bytes
        $file = (!empty($_FILES['profile_pic']) ? $_FILES['profile_pic'] : '');

        if(!empty($file)){
            
            if(!in_array($_FILES['profile_pic']['type'],$allowed_extension)){
                echo "400::Only JPEG/JPG/PNG files allowed!";
                exit;
            }

            if($_FILES['profile_pic']['size'] > $allowed_size){
                echo "400::Images less than 2MB allowed!";
                exit;
            }

            $folder = FCPATH.'/upload/profile_pic/';
            if(!is_dir($folder)){
                mkdir($folder,0777, true);
            }

            $image_name = $_FILES['profile_pic']['name'].time();
            $path = $folder.$image_name;

            if(move_uploaded_file($_FILES['profile_pic']['tmp_name'],$path)){

                $user_data = $model_user->where('user_id="'.$_SESSION['user_id'].'" AND status="1"')->first();
                if(!empty($user_data)){
                    $user_data['profile_pic'] = $image_name;
                    $model_user->update($user_data['user_id'],$user_data);
                }
                echo "200::Profile Picture Uploaded!";
                exit;
            }
            else{
                echo "400::Failed to Upload!";
                exit;
            }

        }   
        else{
            echo "400::File Not Found!";
            exit;
        }
    }

    public function companyAdd(){
        // if(empty($_SESSION['user_id'])){
        //     return redirect()->to(base_url()."home/login");
        // }
        if(!empty($_SESSION['user_id'])){
            $model_user = new UserModel;
            $check = $model_user->where('user_id="'.$_SESSION['user_id'].'"')->first();
            if(!empty($check)){
                if($check['token'] != $_SESSION['token']){
                    $this->destroySession('token');
                    $this->destroySession('user_id');
                    $this->destroySession('username');
                    return redirect()->to(base_url().'home/login');
                }
            }
        }

        $data = array();
        $user_id = (!empty($_SESSION['user_id']) ? $_SESSION['user_id'] : '');
        $model_company = new CompanyModel;
        $data['company_data'] = $model_company->where('user_id="'.$user_id.'" AND status="1"')->first();

        return view('companyAdd',$data);
    }

    public function companySave(){
        $user_id = (!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '');
        $company_name = (!empty($_REQUEST['company_name']) ? $_REQUEST['company_name'] : '');
        $company_email = (!empty($_REQUEST['company_email']) ? $_REQUEST['company_email'] : '');
        $company_telephone = (!empty($_REQUEST['company_telephone']) ? $_REQUEST['company_telephone'] : '');
        $company_address = (!empty($_REQUEST['company_address']) ? $_REQUEST['company_address'] : '');
        $model_company = new CompanyModel;

        if(empty($user_id)){
            echo "400::User Id not Found!";
            exit;
        }
        
        if(empty($company_address) || empty($company_telephone) ||  empty($company_email) || empty($company_name)){
            echo "400::Input fields cannot be Empty!";
            exit;
        }

        $check = $model_company->where('user_id="'.$user_id.'" AND status="1"')->first();

        if(empty($check)){
            $data['user_id'] = $user_id;
            $data['company_name'] = $company_name;
            $data['company_email'] = $company_email;
            $data['company_telephone'] = $company_telephone;
            $data['company_address'] = $company_address;
            $model_company->save($data);
            echo "200::Company Data Saved!";
            exit;
        }
        else{
            $check['company_name'] = $company_name;
            $check['company_email'] = $company_email;
            $check['company_telephone'] = $company_telephone;
            $check['company_address'] = $company_address;
            $model_company->update($check['company_id'],$check);
            echo "200::Company Data Updated!";
            exit;
        }

    }

    public function logout(){
        $this->destroySession('user_id');
        $this->destroySession('username');
        $this->destroySession('token');

        return redirect()->to(base_url().'home/login');
    }

}