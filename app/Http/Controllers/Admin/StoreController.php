<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
   public function index()
{
    $search = request('search');

    $stores = Store::where('is_active', true)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('gst_number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        })
        ->paginate(10);

    return view('Admin.store.index', compact('stores'));
}
    public function create(){
        return view('Admin.store.create');
    }
    public function store(Request $request){
        $data = $request->validate([
            'name'=> 'required',
            'phone_number' => 'nullable',
            'email' => 'required',
            'address'  => 'required',
            'state' => 'required',
            'country' => 'required',
            'gst_number' => 'nullable',
            'gst_percentage' => 'required',
            'is_active' => 'required',
        ]);

        try{
            Store::create($data);
            return redirect()->route('store.index')->with('success', 'Store created successfully');
            
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    public function edit($id){
        $store = Store::find($id);
        return view('Admin.store.edit', compact('store'));
    }
    public function update(Request $request, $id){
        
        $data = $request->validate([
            'name'=> 'required',
            'phone_number' => 'nullable',
            'email' => 'required',
            'address'  => 'required',
            'state' => 'required',
            'country' => 'required',
            'gst_number' => 'nullable',
            'gst_percentage' => 'required',
            'is_active' => 'required',
        ]);

        try{

           $store = Store::findorFail($id);
           if(!$store){
               return back()->with('error', 'Store not found');
           }
           $store->update($data);
            return redirect()->route('store.index')->with('success', 'Store updated successfully');
            
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    public function delete($id){
        try{
            $store = Store::findorFail($id);
            if(!$store){
                return back()->with('error', 'Store not found');
            }
            $store->delete();
            return redirect()->route('store.index')->with('success', 'Store deleted successfully');
            
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    
}
