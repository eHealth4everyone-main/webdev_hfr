<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'tbl_hospitals';
    protected $primaryKey = 'hs_id';
    public $timestamps = false;

    protected $guarded = [ "hs_sig_unique_id","hs_id"];
}
