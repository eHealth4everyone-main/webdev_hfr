<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equip extends Model
{
    protected $table = 'tbl_lab_equipment';
    protected $primaryKey = 'lab_eq_id';
    public $timestamps = false;
}
