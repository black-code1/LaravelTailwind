<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMe;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function show()
    {
        return view('contact');
    }

    public function store()
    {
        request()->validate(['email' => 'required|email']);

        // send the email

        // Mail::raw('It works!', function ($message) {
        //     $message->to(request('email'))
        //     ->subject('Hello There');
           
        // });

        Mail::to(request('email'))
        ->send(new ContactMe('shirts'));

        return redirect('/contact')
        ->with('message', 'Email sent!');
    }
}
