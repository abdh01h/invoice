<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use DB;
use Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show-users', [
            'only' => ['index', 'show']
        ]);
        $this->middleware('permission:add-users', [
            'only' => ['create','store']
        ]);
        $this->middleware('permission:edit-users', [
            'only' => ['edit', 'update']
        ]);
        $this->middleware('permission:delete-users', [
            'only' => ['destroy']
        ]);
    }

    public function index(Request $request)
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'confirmed'],
            'roles'     => ['required'],
            'status'    => ['required'],
        ]);

        $input              = $request->all();
        $input['password']  = Hash::make($input['password']);
        $user               = User::create($input);
        $user->markEmailAsVerified();

        $user->assignRole($request->input('roles'));

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('User Created Successfully'));
        $request->session()->flash('message', __('The User Has Been Successfully Created.'));

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit(User $user)
    {
        $roles      = Role::pluck('name', 'name')->all();
        $userRole   = $user->roles->pluck('name')->first();

        return view('users.edit',compact('user','roles', 'userRole'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => 'required|email|max:255|unique:users,email,'.$id,
            'password'  => 'same:password_confirmation',
            'roles'     => ['required'],
            'status'    => ['required'],
        ]);

        $input = $request->all();

        if(!empty($input['password'])) {

            $input['password'] = Hash::make($input['password']);

        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('User updated Successfully'));
        $request->session()->flash('message', __('The User Has Been Successfully updated.'));

        return redirect()->route('users.index');
    }

    public function destroy(Request $request)
    {
        $id = $request->user_id;

        User::find($id)->delete();


        $request->session()->flash('type', __('success'));
        $request->session()->flash('title', __('User deleted Successfully'));
        $request->session()->flash('message', __('The User Has Been Successfully deleted.'));

        return redirect()->route('users.index');
    }


}
