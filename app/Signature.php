<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    protected $table = 'tbl_signatures';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $dates = ['comm_date'];
    protected $guarded = [ "sig_unique_id","fac_tpye"];

    // public function ward_m(){
    //     return $this->belongsTo('\App\Ward_m','ward','wd_id');
    // }

    public function Hospital()
    {
        return $this->hasOne('App\Hospital','hs_id','id');
    }

    public function Pharma()
    {
        return $this->hasOne('App\Pharma','ph_id','id');
    }
    public function Lab()
    {
        return $this->hasOne('App\Lab','lb_id','id');
    }
    public function Imaging()
    {
        return $this->hasOne('App\Imaging','im_id','id');
    }


    public function arrayValuesTostring($val)
    {
        if(is_array($val)){
           $str = implode(',', $val);
        }else{
           $str = "";
        }
        return $str;
    }
    
    public function makeID($state,$lga,$type,$level,$owner,$sn){
        $id = $state."/".$lga."/".$type."/".$level."/".$owner."/";

        if (strlen($sn)==1){
            $id = $id.'000'.$sn;
        }
        elseif(strlen($sn)==2){
            $id = $id.'00'.$sn;
        }
        elseif(strlen($sn)==3){
            $id = $id.'0'.$sn;
        }
        else{
            $id = $id.$sn;
        }
        return $id;
    }

}
