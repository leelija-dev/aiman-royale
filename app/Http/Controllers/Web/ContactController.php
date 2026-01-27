<!-- < ?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\NewsLetter;
use App\Models\Notification;
use App\Models\Service;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        $data=Service::all();

        return view('web.contact',['data'=>$data]);
    }
    public function store(Request $request){
        $data=$request->validate([
        'f_name'=>'string',
        'l_name'=>'string',
        'email'=>'string',
        'phone'=>'nullable|string',
        // 'services'=>'array',
        
        'services' => 'required|array',
        // 'services.*' => 'string|in:Web Design,Marketing,...', // optional


        'message'=>'string',
        
 

    ]);
    $message=[
        'message'=>'New Contact form submitted',
        'url' => 'admin.contacts'
    ];
    
    $data['services'] = implode(',', $request->services);
    ContactUs::create($data);
    Notification::create($message);
       
    
    return view('web.thank-you');//redirect()->route('page.index')->with('success','Form submited sucessfully');
    }
    public function Email(Request $request){
        $data=$request->validate([
            'email'=>'required|string '

        ]);
        $message=[
        'message'=>'New Email Send',
        'url' => 'admin.news-letter'
        ];
        Notification::create($message);
        NewsLetter::create($data);
        return view('web.thank-you');//redirect()->route('page.index')->with('success','Email sent Sucessfully');
        
    }
} -->
