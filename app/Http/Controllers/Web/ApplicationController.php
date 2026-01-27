<?php

// namespace App\Http\Controllers\web;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\models\Application; 
// use App\models\Notification; 
// use App\Models\JobVacancy;
// class ApplicationController extends Controller
// {
//     public function Thanks(){
//     return view('web.thank-you');
//     }

//     public function Apply(Request $request){
//     $data = $request->validate([
//     'name'             => 'required|string|max:255',
//     'mobile_number'    => 'required|string|digits:10',
//     'email'            => 'required|email|max:255',
//     // 'linkedin_profile' => 'required|string|max:255',
    
//     'exprience'        => 'nullable|string|max:100',
//     'uploadcv'         => 'required|file|mimes:pdf|max:2048',
//     'current_ctc'      => 'nullable|integer',
//     'expected_ctc'     => 'nullable|integer',
//     'cover_letter'     => 'nullable|string',
    
//     'job_role'         => 'required|string|max:255',
//     'vacancy_id'       => 'required|string',
//     // 'status'         =>'string'
//     ]);
//     $message=[
//         'message'=>'New Job Application form submitted',
//         'url' => 'show-application'
//     ];
    
 
    
//     Notification::create($message);
//         if ($request->hasFile('uploadcv')) {
//             $file = $request->file('uploadcv');
//             $filename = time() . '_' . $file->getClientOriginalName();
//             $file->move(public_path('Application_cv'), $filename);
//             $data['uploadcv'] = $filename; 
//             }
        
     
        
//         Application::create($data);

       
//         return view('web.thank-you');//redirect(route('page.successfull'))->with('success','Application submittetd sucessfull');
        

//     }
// }
