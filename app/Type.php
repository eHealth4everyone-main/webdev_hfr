<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'tbl_fac_type';
    protected $primaryKey = 'ft_id';
    public $timestamps = false;
}
