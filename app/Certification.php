<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $table = 'tbl_lab_certificate';
    protected $primaryKey = 'lc_id';
    public $timestamps = false;
}
