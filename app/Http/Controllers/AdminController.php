<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    
    public function AdminDashboard()
    {
        return view('admin.index');
    }

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login');
    }

    public function AdminLogin()
    {
        return view('admin.Admin_login');
    }
  
    public function AdminRegister(Request $request)
    {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed'],
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            return redirect('admin.Admin_Register');
    }
    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $ProfileData = User::find($id);
        return view('admin.admin_profile_view',compact('ProfileData'));
    }

    public function AdminProfileStore(Request $req)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $req->username;
        $data->name = $req->name;
        $data->email = $req->email;
        $data->phone = $req->phone;
        $data->address = $req->address;

        if($req->file('photo'))
        {
            $file = $req->file('photo');
            //replace the previous photo
            @unlink(public_path('upload/admin_images'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();// 232332.filename.png (new file name)
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();
        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function AdminChangePassword()
    {
        $id = Auth::user()->id;
        $ProfileData = User::find($id);
        return view('admin.Admin_change_password', compact('ProfileData'));
    }

    public function AdminUpdatePassword(Request $req)
    {
        $req->validate(
            [
                'Old_password' => 'required',
                'new_password' => 'required|confirmed'
            ]
        );
        //Match the old Password
        if(!Hash::check($req->Old_password, auth::user()->password)){

            $notification = array(
            'message' => 'Old Password Does not Match!',
            'alert-type' => 'error'
            );
        
            return back()->with($notification);
        }
        //Update the New password
        User::whereId(auth()->user()->id)->update([
            'password' =>Hash::make($req->new_password) 
        ]);

        $notification = array(
            'message' => ' Password Changed Successfully!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    ////////// Admin User All Method ////////////
    public function AllAdmin()
    {
        $alladmin = User::where('role','admin')->get();
        return view('backend.pages.admin.all_admin',compact('alladmin'));
    }
    public function AddAdmin()
    {
        $roles = Role::all();
        return view('backend.pages.admin.Add_Admin',compact('roles'));
    }
    public function EditAdmin($id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);
        return view('backend.pages.admin.Edit_Admin',compact('user','roles'));
    }
    
    public function StoreAdmin(Request $req)
    {
        $user = new User();
        $user->username = $req->username;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->password = Hash::make($req->password);
        $user->role = 'admin';
        $user->status = 'active';
        $user->save();
        if($req->roles)
        {
            $user->assignRole($req->roles);
        }
        $notification = array(
            'message' => ' New Aadmin User Inserted Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification);
    }
    public function UpdateAdmin(Request $req,$id)
    {
        $user = User::findOrFail($id);
        $user->username = $req->username;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->password = Hash::make($req->password);
        $user->role = 'admin';
        $user->status = 'active';
        $user->update();

        $user->roles()->detach();
        if($req->roles)
        {
            $user->assignRole($req->roles);
        }
        $notification = array(
            'message' => ' New Admin User Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification);
    }

    public function DeleteAdmin($id)
    {
        $user = User::findOrFail($id);
        if(!is_null($user)){
            $user->delete();
        }
        $notification = array(
            'message' => ' New Admin User Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('all.admin')->with($notification);
   
    }
}
