<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;

class AmenitiesController extends Controller
{
    public function AllAmenities()
    {
        $Amenities = Amenities::latest()->get();
        return view('backend.Amenities.All_Amenities',compact('Amenities'));
    }
    public function AddAmenities()
    {
        return view('backend.Amenities.Add_Amenities');
    }
    public function StoreAmenities(Request $req)
    {
        $req->validate([
            'amenities_name' => 'required',
        ]);
        Amenities::insert([
            'amenities_name' => $req->amenities_name,
        ]);
        $notification = array(
            'message' => 'Amenities has been successfully Added',
            'alert-type' => 'success'
        );
        return redirect()->route('all.amenities')->with($notification);
    }    
    public function DeleteAmenities($id)
    {
        $amenities = Amenities::findOrFail($id);
        $amenities->delete();

        $notification = array(
            'alert-type' => 'success',
            'message' => 'Amenitie has been deleted Successfully'
        );
        return back()->with($notification);

    }
    public function EditAmenities($id)
    {
        $amenities = Amenities::findOrFail($id);
        return view('backend.Amenities.Edit_Amenities',compact('amenities'));
    }
    public function UpdateAmenities(Request $req)
    {
        $amenitie = Amenities::findOrFail($req->id);
        $amenitie->amenities_name = $req->amenities_name;
        $amenitie->update();

        $notification = array(
            'alert-type' => 'success',
            'message' => 'Amenitie has been Updated Successfully',
        );

        return redirect()->route('all.amenities')->with($notification);

    }
}
