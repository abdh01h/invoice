<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use Validator;
use Hash;
use Image;
use Avatar;

class UserProfileController extends Controller
{

    public function index()
    {
        return view('profile');
    }


    public function update(Request $request)
    {

        $id = Auth::id();

        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => 'required|email|max:255|unique:users,email,'.$id,
            'avatar'            => ['nullable', 'mimes:jpeg,jpg,png', 'max:1024'],
        ]);

        $inputs = $request->all();

        if(!empty($inputs['old-password']) || !empty($inputs['password']))
        {
            $validator = Validator::make([], []);

            $request->validate([
                'old-password'          => 'required',
                'password'              => 'required|min:1|confirmed',
            ],[
                'password.required'     => 'The New Password field is required.',
                'password.different'    => 'New Password should not match the old password.',
                'password.confirmed'    => 'New Password and Confirm Password should match.',
            ]);

            if(Hash::check($inputs['old-password'], Auth::user()->password))
            {
                $inputs['password'] = Hash::make($inputs['password']);
                User::find(Auth::id())->update(['password' => $inputs['password']]);
                $inputs = Arr::except($inputs, ['old-password', 'password', 'password_confirmation']);

            } else {
                $validator->getMessageBag()->add('old-password', "Old Password Doesn't match");
                return redirect()->back()->withErrors($validator)->withInput();
            }


        } else {
            $inputs = Arr::except($inputs, ['old-password', 'password', 'password_confirmation']);
        }

        if ($request->hasFile('avatar')) {

            $file               = $request->file('avatar');
            $file_name          = $request->file('avatar')->getClientOriginalName(); // Original Avatar
            $file_name          = time() . "." . $file->extension(); // Change Original Avatar name
            $thum_name          = time() . '_avatar' . "." . $file->extension(); // For Image Avatar
            $path               = 'storage/avatars/' . $id . '/'; // Storage Path
            $inputs['avatar']   = $path . $thum_name; // For Database

            if(file_exists(public_path($path))) {

                File::cleanDirectory(public_path($path));
                File::makeDirectory($path, 0775, true, true);

            } else {
                File::makeDirectory($path, 0775, true, true);
            }

            $img = Image::make($file->path());
            $img->resize(128, 128, function ($const) {
                $const->aspectRatio();
            })->save($path . $thum_name);

        }

        $user = User::find($id);
        $user->update($inputs);

        $request->session()->flash('type', __('success'));
        $request->session()->flash('message', __('The Profile Has Been Successfully updated.'));

        return back();

    }

    public function delete_avatar()
    {

        $id     = Auth::id();
        $user   = User::find($id);
        $path   = 'storage/avatars/' . $id . '/';

        if(!empty($id) && file_exists(public_path($path))) {
            File::deleteDirectory(public_path($path));
        }

        $user->avatar = null;
        $user->save();

        session()->flash('type', __('success'));
        session()->flash('message', __('The avatar Has Been Successfully deleted.'));

        return back();
    }

}
