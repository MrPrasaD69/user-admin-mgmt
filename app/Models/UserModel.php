<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model{
    protected $table = "tbl_users";
    protected $primaryKey = "user_id";
    protected $allowedFields = ['user_id','username','password','profile_pic','is_pass_change','token','status'];
}

?>