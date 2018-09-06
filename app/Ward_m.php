<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ward_m extends Model
{
    protected $table = 'tbl_ward';
    protected $primaryKey = 'wd_id';
    public $timestamps = false;
}
