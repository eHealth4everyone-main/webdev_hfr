<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $table = 'tbl_signatures';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
