<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Analytics;
use Spatie\Analytics\Period;
use Auth;

class AdminHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(30));
        
        $dates = array();
        $visitors = array();
        foreach ($analyticsData as $a){
            $dates[]=$a['date']->toDateString();
            $visitors[] = $a['visitors'];
        };
       

        $num_downloads = DB::select("SELECT date_format(created_at,'%b %y') as name,month(created_at) mon,year(created_at) year, COUNT(id) y 
                FROM downloads group by name,mon,year order by year,mon asc  limit 12");

        $status = DB::select("select state,status,count(id) count from hospital_details_history group by state,status");

        $columns = array();
        $facility_status = array();
        $looped_states = array();
        $statecheck = 0;
        $columns = array_fill(1, 10, 0);

        foreach($status as $s){
            if(!in_array($s->state,$looped_states)){
                foreach($status as $s2){
                    if($s->state == $s2->state){
                        $columns[0] = $s2->state;
                        $looped_states[] = $s2->state;
                        if ($s2->status == "Pending Creation"){
                            $columns[1] = $s2->count;
                        }
                        if ($s2->status == "Facility Creation Rejected"){
                            $columns[2] = $s2->count;
                        }
                        if ($s2->status == "Pending Update"){
                            $columns[3] = $s2->count;                       
                        }
                        if ($s2->status =="Facility Update Rejected"){
                            $columns[4] = $s2->count;                       
                        }
                        if ($s2->status == "Pending Deletion"){
                            $columns[5] = $s2->count;                       
                        }
                        if ($s2->status == "Facility Deletion Rejected"){
                            $columns[6] = $s2->count;                       
                        }
                        if ($s2->status == "Facility Verified"){
                            $columns[7] = $s2->count;                       
                        }
                        if ($s2->status == "Facility Validated"){
                            $columns[8] = $s2->count;                      
                        }
                        if ($s2->status == "Facility Published"){
                            $columns[9] = $s2->count;                       
                        }
            
                    }
                         
                }
               
                $facility_status[] = $columns; 
            }
          
        }
       

        return view("admin_dashboard",compact('num_downloads','facility_status','dates','visitors'));
    }


}
