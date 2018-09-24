<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Download;
class DownloadController extends Controller
{
    //
    public function DownloadForm()
    {
    
        return view('public.download');
    }

    public function store(Request $request)
        {
            $request->validate([
                'firstname' => 'required|string|max:50',
                'lastname' => 'required|string|max:50',
                'organisation' => 'nullable|string|max:100',
                'country' => 'required',
                'designation' => 'required',
                'country' => 'required',
                'purpose' => 'required|max:200',
                'email' => 'required|string|email|max:100',
                'g-recaptcha-response' => 'required|captcha',
            ]);

            Download::create($request->all());

            session()->flash("alert-success", "Download successfully!");
            return back();
    }
}
