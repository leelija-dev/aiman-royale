<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
class UnitController extends Controller
{
    public function index(){
        $units=Unit::all();
        return view('Admin.unit.index',compact('units'));
    }
    public function create(){
        return view('Admin.unit.create');
    }
    public function store(Request $request){
        $data=$request->validate([
            //'code'=>'required|string',
            'code'=>'required|string|max:16|unique:units,code',
            'name'=>'required|string',
            //'name'=>'required|string|max:64|unique:units,name',
            'allow_decimal'=>'nullable'
        ]);
        Unit::create($data);
      
        return redirect(route('admin.unit'))->with('success','Unit Added successfully');
    }
    public function delete($id){
        $unit=Unit::findOrFail($id);
        $unit->delete();
        return redirect(route('admin.unit'))->with('success','Unit Deleted successfully');
    }
    public function update($id){
        $unit=Unit::findOrFail($id);
        return view('Admin.unit.create',compact('unit'));
    }
    public function edit(Request $request, $id)
{
    $unit = Unit::findOrFail($id);

    $data = $request->validate([
        'code' => 'required|string|max:16|unique:units,code,' . $id,
        'name' => 'required|string|max:64',
        'allow_decimal' => 'nullable',
    ]);

    $data['allow_decimal'] = $request->has('allow_decimal');

    $unit->update($data);

    return redirect()->route('admin.unit')->with('success', 'Unit updated successfully.');
}
}
