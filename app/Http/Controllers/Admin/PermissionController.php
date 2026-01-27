<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Services\Service;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller implements HasMiddleware
{

     public static function middleware()
    {
        return [
            new Middleware('permission:view permission', only: ['index']),
            new Middleware('permission:edit permission', only: ['edit']),
            new Middleware('permission:create permission', only: ['create']),
            new Middleware('permission:delete permission', only: ['delete']),
        ];
    }

    public function index()
    {
        $roles = Permission::all();
        // dd($roles);
        return view('Admin.permission.index', compact('roles'));
    }


    public function create()
    {
        return view("Admin.permission.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        // $slug = Service::generate_slug($request->name);


        try {
            Permission::create(['name' => $request->name]);
            return redirect()->route('admin.permissions')->with('success', 'permissions Created');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return view("Admin.permission.create");
    }

    public function edit($id)
    {
        $role = Permission::findOrFail($id);
        //  dd($page); 
        return view('Admin.permission.edit', compact('role'));
    }


    public function update(Request $request, $id)
    {
        $role = Permission::findOrFail($id);

        // Validate input
        $request->validate([
            'name' => 'required|string',
            
        ]);

        // $slug = Service::generate_slug($request->page_title);
        $role->name = $request->name;

        $role->save();

        return redirect()->route('admin.permissions')
            ->with('success', 'Page updated successfully!');
    }
    
     public function delete($id)
    {
        // dd($id);
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('admin.permissions')
            ->with('success', 'Page Deleted successfully!');
    }

}
