<?php

namespace App\Models;
use CodeIgniter\Model;

class AdminModel extends Model{
    protected $table = "tbl_admin";
    protected $primaryKey = "admin_id";
    protected $allowedFields = ['admin_id','username','password','status'];
}

?>