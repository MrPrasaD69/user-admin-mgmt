<?php

namespace App\Controllers;

use App\Models\UserModel;

class AppApi extends ApiBaseController{
    
    public function login(){
        $jsonData = file_get_contents('php://input');
        $REQUEST = json_decode($jsonData, true);
        
        $resp = array();
        $data = array();
        $model_user = new UserModel;
        $check = $model_user->where('username="'.$REQUEST['email_id'].'"')->first();
        
        if(empty($check)){
            $resp = array('resp_code'=>404,'data'=>'Invalid Username');
        }
        else if($check['password'] !=md5($REQUEST['password'])){
            $resp = array('resp_code'=>400,'data'=>'Invalid Password');
        }
        else{
            $resp = array('resp_code'=>200,'data'=>'Login Success');
        }

        echo json_encode($resp);
        exit;
    }

}


?>