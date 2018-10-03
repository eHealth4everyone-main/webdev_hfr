<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Auth;

class UserController extends Controller
    {
        use HasRoles;

        public function index()
        {
            $users =User::get();
            $roles=Role::get();
            return view('users.index', compact("users","roles"));  
        }
        
    public function store(Request $request)
        {
            $data = $request->all();
            $request->validate([
                'firstname' => 'required|string|max:50',
                'lastname' => 'required|string|max:50',
                'job' => 'nullable|string|max:50',
                'organisation' => 'nullable|string|max:50',
                'username' => 'required|string|max:50|unique:users',
                'role' => 'required',
                'email' => 'required|string|email|max:255|unique:users',
            ]);
        
            $user=User::create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'username' => $data['username'],
                'email' => $data['email'],
                'job_title' => $data['job'],
                'status'=>'Active',
                'organisation' => $data['organisation'],
                'password' => Hash::make('password'),
            ]);
            
            $user->assignRole($data['role']);

            session()->flash("alert-success", "User added successfully!");
            return back();
    }



    public function update(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'firstname1' => 'required|string|max:255',
            'lastname1' => 'required|string|max:255',
            'role1' => 'required',
            'job1' => 'nullable|string|max:50',
            'organisation1' => 'nullable|string|max:50',
        ]);

        $data = $request->all();
    
        $user = User::findOrFail($request->UserID);
        $user->firstname = $data['firstname1'];
        $user->lastname = $data['lastname1'];
        $user->job_title = $data['job1'];
        $user->organisation = $data['organisation1'];
        $user->save();

        $user->syncRoles($data['role1']);

        session()->flash("alert-success", "User updated successfully!");
        return back();
    }


    public function deactivate(Request $request)
    {
       
        if($request->status =='Active'){
            $user = new User;
            $user = User::findOrFail($request->userid);
            $user->status = 'De-Activated';
            $user->save();
    
            session()->flash("alert-success", "User de-activated successfully!");
            return redirect()->back();
        }
        if($request->status =='De-Activated'){
            $user = new User;
            $user = User::findOrFail($request->userid);
            $user->status = 'Active';
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
   
        return view('users.userprofile', compact("users","role"));  
    }

    
    public function updateProfile (Request $request)
    {
        //dd($request->all());
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'job' => 'nullable|string|max:50',
            'organisation' => 'nullable|string|max:50',
        ]);

        $data = $request->all();

        $user = Auth::user();
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
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
            'new_password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        // $user->password = $request->new_password;
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        session()->flash("alert-success","Password changed successfully !");
        return redirect()->back();
    }

}
