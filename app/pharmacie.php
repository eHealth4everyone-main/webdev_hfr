<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pharmacie extends Model
{
    protected $guarded = ["unique_id","start_date","operational_days"];
    
}
