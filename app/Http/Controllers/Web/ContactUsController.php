<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    //
    public function index()
    {
        return view('web.contact-us');
    }


    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'mobile'  => 'required|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $validatedData['inquiry_type'] = $validatedData['subject'];
    unset($validatedData['subject']);

    ContactUs::create($validatedData);

    return response()->json([
        'success' => true,
        'message' => 'Your inquiry has been submitted successfully!'
    ]);
}

    }
