<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsLetter;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;
class NewsLetterController extends Controller
{
    //
    public function ShowNewsLetter(){
        $data=NewsLetter::all();
        return view('Admin.News_letter.news_letter',['data'=>$data]);
    }
    public function EmailGroup(){
        return view('Admin.News_letter.email_group');
    }
    public function Email($id){
        $data=NewsLetter::findorFail($id);
        $data->viewed = true;
        $data->save();
        return redirect()->route('admin.news-letter');
    }
    // public function Sendmail(Request $request, $id)
    // {
    //     $contact = NewsLetter::findOrFail($id);

    //     $sendTo = $contact->email;
    //     $toName = $contact->status;
    //     $subject = $request->input('subject');
    //     $messageContent = $request->input('reply');
    //     $plainText = strip_tags($messageContent);

        
    // // $messageContent['reply'] = $plainText;

    //     Mail::to($sendTo)->send(new ContactReplyMail($plainText, $toName, $subject));
    //     $data=$request->validate([
    //         'reply'=>'string|required',
    //         'subject'=>'string|required'
    //     ]);
    //     $plainText = strip_tags($data['reply']);

        
    //     // $data['reply'] = $plainText;
    //     // $data['contact_id']=$id;
    //     // ContactReply::create($data);
    //     return redirect()->route('admin.show-contact',['id'=>$id])->with('success', 'Mail sent successfully!');
    
    // }
    public function sendMailGroup(Request $request)
{
    $data = $request->validate([
        'subject' => 'required|string',
        'reply' => 'required|string',
    ]);

    $subject = $data['subject'];

    $messageContent = strip_tags($data['reply']);

    $subscribers = NewsLetter::all();

    foreach ($subscribers as $subscriber) {
        Mail::to($subscriber->email)->send(new ContactReplyMail($messageContent, $subscriber->status, $subject));
    }

    return redirect()->back()->with('success', 'All emails sent successfully!');
}



}
