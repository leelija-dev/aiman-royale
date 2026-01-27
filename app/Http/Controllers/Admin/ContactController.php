<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\admin\ServicesController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Models\ApplicationStatus;
//use App\Services\Service;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;
use App\Models\Service;
use App\Models\ContactReply;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class ContactController extends Controller implements HasMiddleware
{

public static function middleware()
    {
        return [

            new Middleware('permission:view contact', only: ['showContact']),
            new Middleware('permission:edit contact', only: ['editContact']),
            new Middleware('permission:create contact', only: ['insertContact']),
            new Middleware('permission:delete contact', only: ['deleteContact']),
        ];
    }
    public function index()
    {
        $contacts = ContactUs::all();
         $zeroCount = ContactUs::where('viewed', 0)->count();
        // dd($contacts);
        return view('Admin.contact.index', ['contacts'=>$contacts,'zerocount'=>$zeroCount]);
    }

     public function mail($id)
    {
        $contact = ContactUs::findOrFail($id);
        // $contacts = ContactUs::all();
        // dd($contacts);
        return view('Admin.contact.sendmail', compact('contact'));
    }

    //  public function Sendmail(Request $request, $id)
    // {

    //     $sendto = $request['to-email'];
    //     $subject = $request['mail-subject'];
    //     $message = $request['mailMessage'];

    //     // dd($request);
    //     // $contacts = ContactUs::all();
    //     // dd($contacts);
    //     // return view('Admin.contact.sendmail');
    // }

public function Sendmail(Request $request, $id)
{
    $contact = ContactUs::findOrFail($id);

    $sendTo = $contact->email;
    $toName = $contact->name;
    $subject = $request->input('subject');
    $messageContent = $request->input('reply');
    $plainText = strip_tags($messageContent);

    
   // $messageContent['reply'] = $plainText;

    Mail::to($sendTo)->send(new ContactReplyMail($plainText, $toName, $subject));
    $data=$request->validate([
        'reply'=>'string|required',
        'subject'=>'string|required'
    ]);
    $plainText = strip_tags($data['reply']);

    
    $data['reply'] = $plainText;
    $data['contact_id']=$id;
    ContactReply::create($data);
    return redirect()->route('admin.show-contact',['id'=>$id])->with('success', 'Mail sent successfully!');
 
}
// public function insertContact(Request $request){
//     $data=$request->validate([
//         'f_name'=>'string',
//         'l_name'=>'string',
//         'email'=>'string',
//         'phone'=>'nullable|string',
//         // 'services'=>'array',
        
//         'services' => 'required|array',
//         // 'services.*' => 'string|in:Web Design,Marketing,...', // optional


//         'message'=>'string',
        
 

//     ]);
//     $data['created_at'] = now();
//     $data['updated_at'] = now();
//     $data['services'] = implode(',', $request->services);
//     ContactUs::create($data);
//     $contacts = ContactUs::all();
//     return view('Admin.contact.index',['contacts'=>$contacts]);

    
    
//}
public function showForm(){
    $data=Service::all();
    
    return view('admin.contact.contact_form',[
        'data'=>$data,
       
]);
}
public function showContact($id){
    $data=ContactUs::findorFail($id);
    $data->viewed = true;
    $data->save();
    $status=ApplicationStatus::all();
    // $contact_reply=ContactReply::all($id);    
    $zeroCount = ContactUs::where('viewed', 0)->count();
    $contact_reply = ContactReply::where('contact_id', $id)->first();
    
    return view('admin.contact.single_contact',[
        'data'=>$data,
        'status_data'=>$status,
        'contact_reply'=>$contact_reply,
        'zerocount'=>$zeroCount

]);


}
public function editContact($id){
    $contact_data=ContactUs::findorFail($id);
    $service_data=Service::all();
    $status_data=ApplicationStatus::all();
    return view('admin.contact.edit_contact',[
        'contact_data'=>$contact_data,
        'service_data'=>$service_data,
        'status_data'=>$status_data
    ]);

}
public function updateStatus(Request $request,$id){
    $data=$request->validate([
        'status'=>'string'
    ]);
    ContactUs::where('id', $id)->update($data);
    return redirect()->route('admin.show-contact',$id)->with('success','Status Update Sucessfully');

}
public function deleteContact($id){
    ContactUs::findorFail($id)->delete();
    
    return redirect()->route('admin.contacts')->with('success','Contact data deleted successfully');
} 



   
}
