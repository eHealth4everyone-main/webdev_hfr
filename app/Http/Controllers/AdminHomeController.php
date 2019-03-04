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

       
        $facility_status = DB::table('facility_status_state_pivot')->get();

        return view("admin_dashboard",compact('num_downloads','facility_status','dates','visitors'));
    }


}
