<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role ;
use DB;

class RoleController extends Controller
{
    public function AllPermission()
    {
        $permissions = Permission::all();
        return view('backend.pages.permission.all_permission',compact('permissions'));
    }
    public function AddPermission()
    {
        return view('backend.pages.permission.Add_permission');
    }
    public function StorePermission(Request $req)
    {
        $permission = Permission::create([
            'name' => $req->name,
            'group_name' => $req->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Creates Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.Permission')->with($notification);
    }
    public function EditPermission($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.pages.permission.Edit_permission',compact('permission'));
    }

    public function UpdatePermission(Request $req)
    {
        $id = $req->id;
        Permission::findOrFail($id)->update([
            'name' => $req->name,
            'group_name' => $req->group_name,
        ]);
        $notification = array(
            'message' => 'Permission has been Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.Permission')->with($notification);

    }
    public function DeletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        
        $notification = array(
            'message' => 'Permission has been Deleted Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }


    ///////// Role All Method /////////
    public function AllRoles()
    {
        $roles = Role::all();
        return view('backend.pages.roles.All_roles',compact('roles'));
    }

    public function AddRoles()
    {
        return view('backend.pages.roles.Add_roles');
    }
    public function StoreRoles(Request $req)
    {
        $roles = Role::create([
            'name' => $req->name,
        ]);
        $notification = array(
            'message' => 'Roles has been Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);

    }
    public function EditRoles($id)
    {
        $roles = Role::findOrFail($id);
        return view('backend.pages.roles.Edit_roles',compact('roles'));
    }

    public function UpdateRoles(Request $req)
    {
        $id = $req->id;
        Role::findOrFail($id)->update([
            'name' => $req->name,
        ]);
        $notification = array(
            'message' => 'Role has been Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.roles')->with($notification);

    }
    public function DeleteRoles($id)
    {
        $roles = Role::findOrFail($id);
        $roles->delete();
        
        $notification = array(
            'message' => 'Role has been Deleted Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    ////////////// Add Role Permission All MEthod //////////////
    public function AddRolesPermission()
    {
        $roles = Role::all();
        $permission = Permission::all();
        $permission_groups = User::getPermissionGroups();
        return view('backend.pages.rolesetup.add_roles_permission',compact('roles','permission','permission_groups'));
    }
    public function StoreRolesPermission(Request $req)
    {
        $data = array();
        $permissions = $req->permission;

        foreach($permissions as $key => $item)
        {
            $data['role_id'] = $req->role_id;
            $data['permission_id'] = $item;
            //we are sing DB because there is no model for that table
            DB::table('role_has_permissions')->insert($data);
        }//end for each

        $notification = array(
            'message' => 'Permission Creates Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles.permission')->with($notification);
    }

    public function AllRolesPermission(){
        $roles = Role::all();
        return view('backend.pages.rolesetup.All_roles_permission',compact('roles'));
    }

    public function AdminEditRoles($id)
    {
        $role = Role::findOrFail($id);
        $permission = Permission::all();
        $permission_groups = User::getPermissionGroups();
        return view('backend.pages.rolesetup.edit_roles_permission',compact('role','permission','permission_groups'));
 
    }

    public function AdminUpdateRoles(Request $req, $id)
    {
        $role = Role::findOrFail($id);
        $permission = $req->permission;
        
        if(!empty($permission))
        {
            $role->syncPermissions($permission);
        }
        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles.permission')->with($notification);
    }

    public function AdminDeleteRoles($id)
    {
        $role = Role::findOrFail($id);
        if(!is_null($role))
        {
            $role->delete();
        }
        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

}