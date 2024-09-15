<?php

namespace App\Models;
use CodeIgniter\Model;

class SongModel extends Model{
    protected $table = "tbl_songs";
    protected $primaryKey = "song_id";
    protected $allowedFields = ['song_id','song_name','song_link','song_document','status'];
}

?>