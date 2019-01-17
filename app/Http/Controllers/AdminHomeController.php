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
       
        //count my request
        $myrequest = DB::select("SELECT Count(*) count FROM hospital_details_history WHERE 
        (created_by = ". Auth::user()->id ." OR requested_by = ". Auth::user()->id .") 
        AND status_id NOT IN (6,13,17,20,5,7,12,14,19,21)");

        $my_num_of_requests = $myrequest[0]->count;

        $num_downloads = DB::select("SELECT date_format(created_at,'%b %y') as name,month(created_at) mon,COUNT(id) y 
        FROM downloads group by name,mon order by mon limit 12");

        $num_feedbacks = DB::select("SELECT date_format(created_at,'%b %y') name, month(created_at) mon, COUNT(id) as y 
        FROM contact_us group by name,mon order by mon limit 12");

        return view("admin_dashboard",compact('num_downloads','num_feedbacks','dates','visitors','my_num_of_requests'));
    }


}
