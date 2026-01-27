<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Application;
use App\models\ApplicationStatus;
use Illuminate\Support\Facades\Validator;

class NewApplicationController extends Controller
{
    public function newApplication(){
        return view('admin.careers.newapplication');
        }
    // public function addNewApplication(Request $request){
    //   $data = $request->validate([
    // 'name'             => 'required|string|max:255',
    // 'mobile_number'    => 'required|string|digits:10',
    // 'email'            => 'required|email|max:255',
    // 'linkedin_profile' => 'required|string|max:255',
    // 'job_role'         => 'required|string|max:255',
    // 'exprience'        => 'nullable|string|max:100',
    // 'uploadcv'         => 'required|file|mimes:pdf|max:2048',
    // 'current_ctc'      => 'nullable|integer',
    // 'expected_ctc'     => 'nullable|integer',
    // 'cover_letter'     => 'nullable|string',
    // 'status'         =>'string'
    // ]);
    //     if ($request->hasFile('uploadcv')) {
    //         $file = $request->file('uploadcv');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $file->move(public_path('Application_cv'), $filename);
    //         $data['uploadcv'] = $filename; 
    //         }
    //     $data['created_at'] = now();
    //     $data['updated_at'] = now();
    //     $validation=Application::create($data);
    //     if($validation){
    //     return redirect(route('show-application'))->with('success','Application submittetd sucessfull');
    //     }
        //}
    public function ShowApplication(){
        $user=Application::all();
        $statuses=ApplicationStatus::all();
        if($user){
        return view('admin.careers.showapplication',['data'=>$user,'statuses'=>$statuses]);
        }
        else{
            return "<h1> not found</h1>";
        }
        }
    public function deleteApplication($id){
        $delete=Application::find($id)->delete();

        if($delete)
        return redirect(route('show-application'))->with("success","Application Deleted sucessfully");
     }
    public function singleApplication(Request $request,$id){
        $user=Application::findorFail($id);
        $user->viewed = true;
        $user->save();
        $statuses = ApplicationStatus::all();
        
        return view('admin.careers.showsingleapplication',[
        'user' => $user,
        'data' => $statuses  // This is used in the dropdown
    ]);
        }
//    public function showSingleApplication($id)
// {
//     $application = Application::findOrFail($id);
//     $application->update(['viewed' => true]);
    
//     return view('single-application', compact('application'));
// }



    public function addStatus(Request $request, $id)
    {

    $data = $request->validate([
        'status' => 'string'
    ]);

     

    // Fetch the updated application
    Application::where('id', $id)->update($data);

    return redirect()->back()->with('success', 'Status updated successfully.');
        }

    public function setStatus(Request $request)
    {
    $data = $request->validate([
        'status_id' => 'required|string|unique:app_status,status_id',
        'status'    => 'required|string',
    ]);
        $data['created_at'] = now();
        $data['updated_at'] = now();
        $validate=ApplicationStatus::create($data);
    
        if($validate){
        return redirect()->route('admin.setup.status.show')->with('success', 'Status added successfully!');
        }
     }

// 
    public function showStatus(){
        $statuses = ApplicationStatus::all();
          // This is used in the dropdown
   
    return view('admin.status.set_status',['data'=> $statuses]);
        }

    public function allStatus($id)
    {
    $status_data = ApplicationStatus::all();  
    $user = Application::find($id);    

    return view('admin.careers.showsingleapplication', [
        'data' => $status_data,
        'user' => $user
    ]);
     }

    public function editStatus($id){
        $data=ApplicationStatus::find($id);
        return view('admin.status.edit_status',['data'=>$data]);
    }

    // public function updateStatus(Request $request,$id){
    // $data=$request->validate([
    //     'status'=>'string',
    //     'status_id'=>'string'
    //     ]);
    //  ApplicationStatus::where('id', $id)->update($data);
    //  $status_data = ApplicationStatus::all();  
    // //return view('admin.status.set_status',['data' => $status_data]);
    // return redirect()->route('admin.setup.status.show')->with('success', 'Status updated successfully!');
    //     }
   

    public function updateStatus(Request $request, $id) {
    $validator = Validator::make($request->all(), [
        'status_id' => 'required|string',
        'status' => 'required|string',
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator, 'editStatus') // 👉 named bag
            ->withInput();
    }

    ApplicationStatus::where('id', $id)->update([
        'status_id' => $request->status_id,
        'status' => $request->status,
    ]);

    return redirect()->route('admin.setup.status.show')->with('success', 'Status updated successfully!');
}

    public function deleteStatus($id){
    ApplicationStatus::find($id)->delete();

    return redirect()->route('admin.setup.status.show')->with('success', 'Status deleted successfully!');;
        }
}
