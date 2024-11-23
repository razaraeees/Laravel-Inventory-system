<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use App\Models\User;
use File;



class AdminController extends Controller
{
     public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' =>'User Logout Successfully',
            'alert-type' => 'info'
       );

        return redirect('/login')->with($notification);
    }
    public function Profile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData')); 
    }
    public function EditProfile()
    {
        $id = Auth::user()->id;
        $profileEdit = User::find($id);
        return view('admin.admin_profile_edit', compact('profileEdit')); 
    }

    public function ProfileUpdate(Request $request){
       $user = Auth::user();
       $fileName = $user->profile_image;

       if (request()->hasFile('profile_image'))
       {
          $file = request()->file('profile_image');
          $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
          $file->move('./uploads/admin_image/', $fileName );
          File::delete('./uploads/admin_image/' . $user->profile_image);
       }
       
       $data = $request->all();
       $data['profile_image'] = $fileName;
       $user->update($data);

       $notification = array(
            'message' =>'Admin Profile Update Successfully',    
            'alert-type' => 'info'
       );
       
       return redirect()->route('admin.profile')->with($notification);
    }

    public function ChangePassword(){

        return view('admin.admin_change_password');

    }

    public function UpdatePassword(Request $request){
        
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirmpassword' => 'required|same:newpassword',
        ]);
        
        $hashedPassword = Auth()->user()->password;
        if (Hash::check($request->oldpassword,$hashedPassword)) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();
            
           session()->flash('message', 'Password Updated Successfully');
           return  redirect()->back(); 
        }
        else {
           session()->flash('message', 'Old password is not match');
           return  redirect()->back(); 
        }
    }

}
