<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Page;
use Illuminate\Support\Facades\Log;
class TestimonialController extends Controller
{
    public function index(){
        try{
        $data=Testimonial::all();
        $pageCounts = Testimonial::select('name')
            ->groupBy('name')
            ->selectRaw('name, COUNT(*) as total')
            ->get();
        return view('Admin.testimonial.index',compact('data','pageCounts'));
        }
        catch(\Exception $e){
            Log::error('Error fetching Testimonial index: ' . $e->getMessage());
           return redirect()->back()->with('error', 'Something went wrong while loading Testimonial.');
        }
    }
    public function addTestimonial()
    {   try{
        $data=Page::all();
        return view('Admin.testimonial.add_testimonial',compact('data'));
       }catch(\Exception $e){
            Log::error('Error fetching Testimonial: ' . $e->getMessage());
           return redirect()->back()->with('error', 'Something went wrong while loading Testimonial.');
        }

    }
    public function saveTestimonial(Request $request){
        try{
            $data=$request->validate([
                'page_id' => 'integer',
                'name'=>'string',
                'designation'=>'string',
                'message'=>'string',
                'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
                // 'status'=>'string'
            ]);
             
            $status = $request->has('status') ? '1' : '0';
            $data['status'] = $status;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload_image'), $filename);
                $data['image'] = $filename;
            }
            
            Testimonial::create($data);
                return redirect()->route('testimonial.list')->with('success','Testimonial data submited successfully');
            }
           
        
        catch(\Exception $e){
            dd($e->getMessage());
            Log::error('Error fetching Testimonial: ' . $e->getMessage());
           return redirect()->back()->with('error', 'Something went wrong while loading Testimonial.');
        }
    }
    public function singlePage($name){
        try{   
        $data=Testimonial::where('name',$name)->get();
            return view('Admin.testimonial.single_pages',compact('data'));
        }
        catch(\Exception $e){
            Log::error('Error fetching Testimonial: ' . $e->getMessage());
           return redirect()->back()->with('error', 'Something went wrong while loading Testimonial.');
        }
    }
    public function viewPage($id){
        try{
        $page=Testimonial::findorFail($id);
        $data=Page::all();
        return view('Admin.testimonial.view_page',compact('page','data'));
        }
        catch(\Exception $e){
            Log::error('Error fetching Testimonial: ' . $e->getMessage());
           return redirect()->back()->with('error', 'Something went wrong while loading Testimonial.');
        }
    }
    public function editPage(Request $request,$id){
        try{
        $data=$request->validate([
                'name'=>'string',
                'designation'=>'string',
                'message'=>'string',
                'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $page_id=Page::where('meta_title',$request->name)->first();
        $data['page_id']=$page_id->page_id;
        $status = $request->has('status') ? '1' : '0';
        $data['status'] = $status;
         if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload_image'), $filename);
                $data['image'] = $filename;
            }
            
        Testimonial::where('id',$id)->update($data);
        return redirect()->route('testimonial.single',$request->name)->with('success','Testinomial updated successfully');
        }
        catch(\Exception $e){
            Log::error('Error fetching Testimonial: ' . $e->getMessage());
           return redirect()->back()->with('error', $e->getMessage());
           //echo $e->getMessage();
        }
    }
}
