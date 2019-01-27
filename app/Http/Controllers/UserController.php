<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Auth;
use Notification;
use App\Notifications\SendEmailNewUser;

class UserController extends Controller
    {
        use HasRoles;

        public function index()
        {
            $users =User::get();
            $roles=Role::get();
            
            $lst_states = Cache::remember('lst_states', 60, function () {
                return DB::table('ou_states')
                        ->select('id','name')
                        ->orderByRaw('name ASC')
                        ->get();
            });
            return view('users.index', compact("users","roles","lst_states"));  
        }
        
    public function store(Request $request)
        {
            $data = $request->all();
            $request->validate([
                'firstname' => 'required|string|max:50',
                'lastname' => 'required|string|max:50',
                'job' => 'nullable|string|max:50',
                'organisation' => 'nullable|string|max:50',
                'mobile' => 'string|max:40',
                'role' => 'required',
                'email' => 'required|string|email|max:255|unique:users',
            ]);
        
            $password = str_random(15);

            $user=User::create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'state_id' => $data['state_id'],
                'lga_id' => $data['lga_id'],
                'job_title' => $data['job'],
                'status'=>'-1',
                'organisation' => $data['organisation'],
                'password' => Hash::make($password),
            ]);
            
            $user->assignRole($data['role']);

            $this->sendEmailtoUser($data['firstname'],$password, $data['email']);

            session()->flash("alert-success", "User registered successfully!");
            return back();
    }

    public function sendEmailtoUser($name,$password,$email)
    {
        try {
            Notification::route('mail', $email)
                        ->notify(new SendEmailNewUser($name,$password,$email));
        } catch (\Exception $ex) {
            return false; //un able send code
        }
        return true;
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'firstname1' => 'required|string|max:255',
            'lastname1' => 'required|string|max:255',
            'role1' => 'required',
            'job1' => 'nullable|string|max:50',
            'mobile1' => 'string|max:40',
            'organisation1' => 'nullable|string|max:50',
        ]);

        $data = $request->all();
       
        $user = User::findOrFail($request->UserID);
        $user->firstname = $data['firstname1'];
        $user->lastname = $data['lastname1'];
        $user->job_title = $data['job1'];
        $user->organisation = $data['organisation1'];
        $user->mobile = $data['mobile1'];
        $user->state_id = $data['state_id1'];
        $user->lga_id = $data['lga_id1'];
        $user->save();

        $user->syncRoles($data['role1']);

        session()->flash("alert-success", "User updated successfully!");
        return back();
    }


    public function deactivate(Request $request)
    {
       
        if($request->status ==1){
            $user = new User;
            $user = User::findOrFail($request->userid);
            $user->status = 0;
            $user->save();
    
            session()->flash("alert-success", "User blocked successfully!");
            return redirect()->back();
        }
        if($request->status ==0){
            $user = new User;
            $user = User::findOrFail($request->userid);
            $user->status = 1;
            $user->save();
    
            session()->flash("alert-success", "User activated successfully!");
            return redirect()->back();
        }
      
    }

    public function profile()
    {       
        $users = Auth::user();
        $roles=  $users->getRoleNames()->toArray();
       
        $role = implode(",",$roles);

        $lst_states = Cache::remember('lst_states', 60, function () {
            return DB::table('ou_states')
                    ->select('id','name')
                    ->orderByRaw('name ASC')
                    ->get();
        });

        $lst_lgas = DB::table('ou_lgas')
                    ->select('id','name')
                    ->where('state_id',Auth::user()->state_id)
                    ->get();

        return view('users.userprofile', compact("users","role","lst_states","lst_lgas"));  
    }

    
    public function updateProfile (Request $request)
    {
        //dd($request->all());
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'mobile' => 'string|max:40',
            'job' => 'nullable|string|max:50',
            'organisation' => 'nullable|string|max:50',
        ]);

        $data = $request->all();

        $user = Auth::user();
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->mobile = $data['mobile'];
        $user->job_title = $data['job'];
        $user->organisation = $data['organisation'];
        $user->save();

        session()->flash("alert-success", "Profile updated successfully!");
        return back();
    }

    
    public function changePassword(Request $request){
 
        if (!(Hash::check($request->current_password, Auth::user()->password))) {
            // The passwords matches
            session()->flash("alert-danger", "Your current password does not matches with the password you provided. Please try again.");
            return redirect()->back();
        }
 
        if(strcmp($request->current_password, $request->new_password) == 0){
            //Current password and new password are same
            session()->flash("alert-danger", "New Password cannot be same as your current password. Please choose a different password.");
            return redirect()->back();
        }
 
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        session()->flash("alert-success","Password changed successfully !");
        return redirect()->back();
    }

    public function newUserChangePasswordForm(){
        return view('auth.change_password');
    }

    public function newUserChangePassword(Request $request){
 
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->status = 1;
        $user->save();
        
        session()->flash("alert-success","Password changed successfully !");
        return redirect()->route('admin_home');
        
    }
}
