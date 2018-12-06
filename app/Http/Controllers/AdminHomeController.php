<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Analytics;
use Spatie\Analytics\Period;

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
       

        $num_downloads = DB::select("SELECT date_format(created_at,'%b %y') as name,month(created_at) mon,COUNT(id) y 
        FROM downloads group by name,mon order by mon limit 12");

        $num_feedbacks = DB::select("SELECT date_format(created_at,'%b %y') name, month(created_at) mon, COUNT(id) as y 
        FROM contact_us group by name,mon order by mon limit 12");

        return view("admin_dashboard",compact('num_downloads','num_feedbacks','dates','visitors'));
    }


}
