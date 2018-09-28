<?php

namespace App\Http\Controllers;

use App\Contactus;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function openContactForm (){
        return view('public.contact');
    }


    public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:100',
                'message' => 'required|string|max:500',
                'subject' => 'required|string|max:20',
                'email' => 'required|string|email|max:100',
           
            ]);

            Contactus::create($request->all());

            session()->flash("alert-success", "Thanks ". $request->name ." for contacting us!'");
            return back();
    }
    
}
