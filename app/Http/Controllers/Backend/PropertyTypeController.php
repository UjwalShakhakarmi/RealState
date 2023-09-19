<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function AllType()
    {
        $types = PropertyType::latest()->get();
        return view('backend.type.All_type',compact('types'));
    }
    public function AddType()
    {
        return view('backend.type.Add_Type');
    }
    public function StoreType(Request $req)
    {
        $req->validate([
            //doesnot allow to add same name multiple times in property_types table
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required'
        ]);

        PropertyType::insert([
            'type_name' => $req->type_name,
            'type_icon' => $req->type_icon,
        ]);

        $notification = array(
            'message' => 'Property Type Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.type')->with($notification);
    }
    public function EditType($id)
    {
        $types = PropertyType::findOrFail($id);
        return view('backend.type.edit_type',compact('types'));
    }
    public function UpdateType(Request $req)
    {
        $id = $req->id;
        PropertyType::findOrFail($id)->update([
            'type_name' => $req->type_name,
            'type_icon' => $req->type_icon, 
        ]);
        $notification  = array(
            'message' => 'Property Type Updated Sucessfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.type')->with($notification);
    }
    public function DeleteType($id)
    {
        $type = PropertyType::findOrFail($id);
        $type->delete();

        $notification = array(
            'message' => 'Property Type Deleted Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);


    }
}
