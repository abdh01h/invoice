<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-roles', [
            'only' => ['index', 'show']
        ]);
        $this->middleware('permission:add-roles', [
            'only' => ['create','store']
        ]);
        $this->middleware('permission:edit-roles', [
            'only' => ['edit', 'update']
        ]);
        $this->middleware('permission:delete-roles', [
            'only' => ['destroy']
        ]);
    }

    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);

        return view('roles.index', compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permissions = Permission::get();

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|unique:roles,name',
            'permission'    => 'required',
        ]);

        $role = Role::create([
            'name' => $request->input('name')
        ]);

        $role->syncPermissions($request->input('permission'));

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Role created Successfully'));
        $request->session()->flash('message', __('The Role Has Been Successfully created.'));

        return redirect()->route('roles.index');
    }

    public function show(Role $role)
    {
        $id = $role->id;

        $rolePermissions = Permission::join(
            "role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id"
        )->where("role_has_permissions.role_id", $id)->orderBy('created_at', 'ASC')->pluck('permissions.name', 'permissions.name');

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit(Role $role)
    {
        $id = $role->id;

        $permissions = Permission::get();

        $rolePermissions = DB::table("role_has_permissions")
                            ->where("role_has_permissions.role_id", $id)
                            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id');

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'          => 'required',
            'permission'    => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Role updated Successfully'));
        $request->session()->flash('message', __('The Role Has Been Successfully updated.'));

        return back();
    }

    public function destroy(Request $request)
    {
        $id = $request->role_id;

        DB::table("roles")->where('id', $id)->delete();

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('Role deleted Successfully'));
        $request->session()->flash('message', __('The Role Has Been Successfully deleted.'));

        return redirect()->route('roles.index');
    }
}
