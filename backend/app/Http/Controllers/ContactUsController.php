<?php

namespace App\Http\Controllers;

use App\Contactus;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \Log::info($validated);
        // Save to database
        $contact = Contactus::create($request->all());

        // Send mail to admin
        Mail::to(env("CONTACT_US_MAIL"))->send(new ContactMail($contact));

        return response()->json(['success' => "Thanks " . $request->full_name . " for your message."], 200);
    }
}
