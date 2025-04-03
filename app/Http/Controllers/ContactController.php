<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function add(Request $request)
    {
        $lastName = $request->lastname;
        $phone = $request->contact_number;
        $description = $request->description;

        $email = env('MAIL_USERNAME');

        // Gửi email tới thông báo
        Mail::to($email)->send(new ContactMail($lastName, $phone, $description));

        return response()->json(['status' => 'success']);
    }
}
