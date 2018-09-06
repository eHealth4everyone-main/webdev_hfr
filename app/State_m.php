<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State_m extends Model
{
    protected $table = "tbl_state";
    protected $primaryKey = 'state_id';
    public $timestamps = false;

}
