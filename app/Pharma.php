<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharma extends Model
{
    protected $table = 'tbl_pharmacy';
    protected $primaryKey = 'ph_id';
    public $timestamps = false;


}
