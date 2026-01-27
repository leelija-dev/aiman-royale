<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Services\Service;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{


     public static function middleware()
    {
        return [
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:edit roles', only: ['edit']),
            new Middleware('permission:create roles', only: ['create']),
            new Middleware('permission:delete roles', only: ['delete']),
        ];
    }

    public function index()
    {
        $roles = Role::all();
        // dd($contacts);
        return view('Admin.role.index', compact('roles'));
    }


    public function create()
    {
        $permissions = Permission::all();
        return view("Admin.role.create", compact('permissions'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string',
        ]);
        // $slug = Service::generate_slug($request->name);



        try {
            $role =    Role::create(['name' => $request->name]);
            if (!empty($request->permissions)) {
                foreach ($request->permissions as $name) {
                    $role->givePermissionTo(($name));
                }
            }
            return redirect()->route('admin.roles')->with('success', 'permissions Created');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return view("Admin.role.create");
    }

    public function edit($id)
    {
        // $role = Role::findOrFail($id);
        // //  dd($page); 
        // return view('Admin.role.edit', compact('role'));

        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('Admin.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }


    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Validate input
        $request->validate([
            'name' => 'required|string',

        ]);

        // $slug = Service::generate_slug($request->page_title);
        $role->name = $request->name;

        $role->save();
        if (!empty($request->permissions)) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }
        return redirect()->route('admin.roles')
            ->with('success', 'Role updated successfully!');
    }

    public function delete($id)
    {
        // dd($id);
        $role = Role::findOrFail($id);
        $role->syncPermissions([]);

        $role->delete();

        return redirect()->route('admin.roles')
            ->with('success', 'Page Deleted successfully!');
    }
}
