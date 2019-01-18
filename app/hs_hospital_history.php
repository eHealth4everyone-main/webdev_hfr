<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\DB;


class hs_hospital_history extends Model implements Auditable 
{
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'hs_hospitals_history';
    protected $guarded = ["unique_id","start_date","operational_days","status_id","created_by","services"];
    protected $auditExclude = ['status_id', 'created_by','requested_by', 'verified_by', 'validated_by', 'published_by','update_no'];

    public function arrayValuesTostring($val)
    {
        if(is_array($val)){
           $str = implode(',', $val);
        }else{
           $str = "";
        }
        return $str;
    }

    public function generateUniqueID($lga_id,$type,$level,$owner){
        //get state and lga code
        $state_lga = DB::select("Select concat(state_code,'/',lga_code) code from ou_lgas where 
                    id = ". $lga_id ."");

        //get serial number
        $max_sn = DB::select("SELECT MAX(CAST(substring(unique_id,length(unique_id)-3,4) as unsigned)) val FROM hs_hospitals where
                    lga_id = ". $lga_id ."");
      
        $sn = $max_sn[0]->val + 1; //get serial number of the next HF in LGA


        $id = $state_lga[0]->code."/".$type."/".$level."/".$owner."/";

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

    public function getUpdateNumber($state_id){
        $update = DB::select("Select update_no+1 num from hs_hospitals_history where id = ". $state_id ."");

        return $update[0]->num;
    }

}
