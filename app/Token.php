<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Notifications\Send2faCode;

class Token extends Model
{

    public function generateCode()
    {
        $code = mt_rand(123456, 987654);
        return $code;
    }

    public function sendCode($user_id,$name,$code)
    {
        try {
            $user = user::find($user_id);
            $user->notify(new Send2faCode($code,$name));

        } catch (\Exception $ex) {
            return false; //un able send code
        }

        return true;
    }
}
