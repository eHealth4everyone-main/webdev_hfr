<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Auth;
use App\HospitalHistory;


class MyApprovalsCountComposer
{
   
        protected $hosp;


        public function __construct(HospitalHistory $hosp)
        {
                $this->hosp = $hosp;
        }


        public function compose(View $view)
        {
                $state_id = Auth::user()->state_id;
                $lga_id = Auth::user()->state_id;

                
                $verify = $this->hosp::whereIn('status_id',[1,5,8,12,15,19])
                                ->where('state_id', $state_id)
                                ->where('lga_id', 'like', '%' .  Auth::user()->lga_id . '%')
                                ->count();

                $validate = $this->hosp::whereIn('status_id',[2,7,9,14,16,21])
                                 ->where('state_id',$state_id)
                                 ->count();

                $publish = $this->hosp::whereIn('status_id',[4,11,18])
                                ->where('state_id', 'like', '%' .  Auth::user()->state_id . '%')
                                ->count();

                //get the total count to display in approvals menu depending on user access to approvals
                $count = 0;
                if (auth()->user()->hasPermissionTo(59)){
                        $count = $count + $verify;
                }
                if (auth()->user()->hasPermissionTo(60)){
                        $count = $count + $validate;
                }
                if (auth()->user()->hasPermissionTo(61)){
                        $count = $count + $publish;
                }

                $approval_count[0] = $verify;   
                $approval_count[1] = $validate;
                $approval_count[2] = $publish;
                $approval_count[3] = $count;

        
                $view->with('approval_count',$approval_count);                        
                
        }

}