<?php

namespace App\Http\Controllers;

use App\Contactus;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function openContactForm (){
        return view('public.contact');
    }

    public function index(){
        $message = Contactus::paginate(10);
        return view('messages.index', compact("message"));
    }
    
    public function store(Request $request)
        {
            $request->validate([
                'full_name' => 'required|string|max:100',
                'message' => 'required|string|max:500',
                'subject' => 'required|string|max:20',
                'email' => 'required|string|email|max:100',
                'g-recaptcha-response' => 'required|captcha',
            ]);

            Contactus::create($request->all());

            session()->flash("alert-success", "Thanks ". $request->name ." for your message/feedback. We will get back to you!");
            return back();
    }
    
}
