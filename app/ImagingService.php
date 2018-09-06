<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagingService extends Model
{
    protected $table = 'tbl_imaging_service';
    protected $primaryKey = 'im_service_id';
    public $timestamps = false;
}
