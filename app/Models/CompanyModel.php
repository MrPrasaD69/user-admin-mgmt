<?php

namespace App\Models;
use CodeIgniter\Model;

class CompanyModel extends Model{
    protected $table = "tbl_company";
    protected $primaryKey = "company_id";
    protected $allowedFields = ['company_id','user_id','company_name','company_email','company_telephone','company_address','status'];
}

?>