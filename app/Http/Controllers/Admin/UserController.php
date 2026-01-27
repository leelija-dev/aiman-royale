<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view reports', only: ['index']),
            new Middleware('permission:edit users', only: ['edit']),
            new Middleware('permission:create users', only: ['create']),
            new Middleware('permission:delete users', only: ['delete']),
        ];
    }
    /**
     * @return RedirectResponse $request
     */

    public function index()
    {
        $users = Admin::orderBy('created_at', 'desc')->paginate(10);
       
        $roles = Role::orderby('name', 'ASC')->get();
        // $rolePermissions = $user->roles->pluck('id')->toArray();

        return view('Admin.user.index', ['users' => $users,'roles'=>$roles]);
    }

    public function create()
    {
        $roles = Role::orderby('name', 'ASC')->get();
        // $rolePermissions = $user->roles->pluck('id')->toArray();
        // $permissions = Permission::all();
        return view("Admin.user.create", [
            'roles' => $roles
        ]);
    }


    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'username' => 'required|string|unique:admin_users,username',
            'email' => 'required|string|email|unique:admin_users,email',
            'password' => 'required|string|min:6',//|confirmed
            'fname' => 'required|nullable|string',
            'lname' => 'required|nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'array|nullable',

        ]);
        
        // Prepare data
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'last_logon' => now(),
            'no_logon' => 0,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'address' => '',
            'image' => '',
            'description'=>$request->description,
            'created_at' => now(),
            //'modified_on' => now()
        ];
         if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload_image'), $filename);
            $data['image'] = $filename;
        }

        // Create user and get the model instance
        $user = Admin::create($data);
        // dd($user->user_id);
        
        // Assign roles/permissions if using a role system like Spatie
        if (!empty($request->permissions)) {
            foreach ($request->permissions as $name) {
                $user->syncRoles($name);
            }
        }

        return redirect()->route('admin.users.show')
            ->with('success', 'User created successfully!');
    }



    public function edit($id)
    {
        // $role = Role::findOrFail($id);
        // //  dd($page); 
        // return view('Admin.role.edit', compact('role'));

        $user = Admin::findOrFail($id);
        $roles = Role::orderby('name', 'ASC')->get();
        $rolePermissions = $user->roles->pluck('id')->toArray();

        return view('Admin.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'rolePermissions' => $rolePermissions
        ]);
    }


    public function update(Request $request, $id)
    {
        $user = Admin::findOrFail($id);

        // Validate input
        $request->validate([
            //'username' => 'required|string',
            'fname'=>'required|string',
            'lname'=>'required|string',
            'email' => 'required|string',
            'image'=>'nullable|image|mimes:jpg,jpeg,png',
            //'password' => 'nullable|string|min:6',
            'description' => 'nullable|string|max:1000',

        ]);
       
        
        // $slug = Service::generate_slug($request->page_title);
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        //$user->username = $request->username;
        $user->email = $request->email;
        $user->description = $request->description;
        
        
        if ($request->hasFile('image')) {
            if (!empty($user->image) && file_exists(public_path('upload_image/' . $user->image))) {
            unlink(public_path('upload_image/' . $user->image));
        }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload_image'), $filename);
            $user->image = $filename;
        }
        // if (!empty($request->password)) {
        // $user->password = Hash::make($request->password);
        // }
        $user->updated_at = now();

        $user->save();
        if (!empty($request->permissions)) {
            $user->syncRoles($request->permissions);
        } else {
            $user->syncRoles([]);
        }
        return redirect()->route('admin.users.show')//Admin.user.index
            ->with('success', 'User updated successfully!');
    }
    public function editPassword($id){
        $user = Admin::findOrFail($id);
        $roles = Role::orderby('name', 'ASC')->get();
        return view('Admin.user.passwordUpdate',compact('user','roles'));
    }

    public function updatePassword(Request $request, $id)
    {
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|confirmed',
    ]);

    $user = Admin::findOrFail($id);

    
    if (!Hash::check($request->current_password, $user->password)) {
       return back()->withErrors([
            'current_password' => 'The current password is incorrect.',
        ])->withInput();
        //echo "Password is incorrect!";
        //exit();
    }

    
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->route('admin.users.show')->with('success', 'Password updated successfully!');

    }

    public function delete($id)
    {
        try {
            $user = Admin::findOrFail($id);

            // Optional: remove roles (Spatie)
            $user->syncRoles([]);

            $user->delete();

            return redirect()->route('admin.users.show')
                ->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.show')
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
