<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Routing\Controllers\Middleware;

class ServicesController extends Controller
{
    public static function middleware()
    {
        return [

            new Middleware('permission:view services', only: ['ShowService']),
            new Middleware('permission:edit services', only: ['editService']),
            new Middleware('permission:create services', only: ['InsertService']),
            new Middleware('permission:delete services', only: ['deleteService']),
        ];
    }
    public function InsertService(Request $request)
    {

        $data = $request->validate([
            'name' => 'string',
            'slug' =>  'nullable|string',
            'parent_id' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'description' => 'nullable|string', 
        ]);
        
        // Generate slug from name if not provided
        if (empty($data['slug'])) {
            $slugService = new \App\Services\Service();
            $data['slug'] = $slugService->generate_slug($data['name']);
        }
        
        $status = $request->has('status') ? '1' : '0';
        $data['status'] = $status;
        $accept_lead = $request->has('accept_lead') ? '1' : '0';
        $data['accept_lead'] = $accept_lead;
        $data['parent_id'] = $request->input('parent_id', 0);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload_image'), $filename);
            $data['image'] = $filename;
        }
        $valid = Service::create($data);
        if ($valid) {
            return redirect()->route('admin.show-service')->with('success', 'Services Added Successfully');
        } else {
            return redirect()->route('admin.show-service')->with('error', 'Services Insert Unsuccessfull');
        }
    }
    public function ShowService()
    {
        $data = Service::all();
        if ($data) {
            return view('Admin.services.show', ['data' => $data]);
        }
    }
    public function ServiceForm()
    {
        $data = Service::all();
        return view('Admin.services.add', ['data' => $data]);
    }
    public function deleteService($id)
    {
        $service = Service::findOrFail($id); // Get the record or fail

        $service->delete();
        return redirect()->route('admin.show-service')->with('success', 'Services data deleted sucessfully');
    }

    public function singleService($id)
    {
        // $data=Service::find($id);
        $data = Service::where('id', $id)->first();
        return view('Admin.services.single_service', ['data' => $data]);
    }
    public function updateService($id)
    {
        $data = Service::find($id);
        $parent_id = $data->parent_id;
        $parent_name = Service::where('id', $parent_id)->value('name');
        $parent=Service::all();
        return view('Admin.services.update_service', compact('data','parent','parent_name'));
    }

    
    public function editService(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'string',
                'slug' => 'string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg',
                'description' => 'nullable|string',
                'status' => 'nullable|boolean',
                'accept_lead' => 'nullable|boolean',
            ]);

            $data['status'] = $request->has('status') ? 1 : 0;
            $data['accept_lead'] = $request->has('accept_lead') ? 1 : 0;
            $data['parent_id'] = $request->input('parent_id', 0);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload_image'), $filename);
                $data['image'] = $filename;
            }

            $update = Service::where('id', $id)->update($data);
            
            if (!$update) {
                throw new \Exception('Failed to update service');
            }

            return redirect()->route('admin.show-service')->with('success', 'service updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Service update failed: ' . $e->getMessage());
            return redirect()->route('admin.show-service')->with('error', 'Failed to update service: ' . $e->getMessage());
        }
    }
}
