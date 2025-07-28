<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:32',
            'messageType' => 'required|in:personal,business',
            'interest' => 'array',
            'interest.*' => 'string',
            'message' => 'required|string',
        ]);

        // Send email to site admin
        Mail::to(config('mail.from.address'))
            ->send(new ContactFormSubmitted($validated));

        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
