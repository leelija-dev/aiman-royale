<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\admin\ServicesController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
// use App\Models\ApplicationStatus;
// //use App\Services\Service;
// use Illuminate\Support\Facades\Mail;
// use App\Mail\ContactReplyMail;
// use App\Models\Service;
// use App\Models\ContactReply;
// use Illuminate\Routing\Controllers\HasMiddleware;
// use Illuminate\Routing\Controllers\Middleware;
class ContactController extends Controller
{
  
    public function index()
    {
        $contacts = ContactUs::orderBy('created_at', 'desc')->paginate(10);
        return view('Admin.contact.index', compact('contacts'));
    }

    public function show($id)
{
    $contact = ContactUs::findOrFail($id);

    return view('Admin.contact.single_contact', compact('contact'));
}

    public function destroy($id)
    {
        $contact = ContactUs::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact inquiry deleted successfully.');
    }
}
