<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imaging extends Model
{
    protected $table = 'tbl_imaging';
    protected $primaryKey = 'im_id';
    public $timestamps = false;

}
