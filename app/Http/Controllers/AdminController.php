<?php

namespace App\Http\Controllers;

use App\Notifications\ApproveUserNotify;
use App\Notifications\NewPostNotify;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Notification;
use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{
    public function usersList()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(6);
        return response()->json($users, 200);
    }

    public function approvedUsers()
    {
        $users = User::where('admin_approval', 1)->paginate(6);
        return response()->json($users, 200);
    }

    public function unapproved_users()
    {
        $users = User::where('admin_approval', '=', 0)->paginate(6);
        return response()->json($users, 200);
    }

    public function approve(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['admin_approval' => 1]);

        // Send Email notification to user immediately....
        $url = URL::temporarySignedRoute(
            'password_reset',
            now()->addMinutes(300),
            ['token' => $user->email]
        );
        
        Notification::route('mail', $user->email)->notify(new PasswordResetNotification($url, $user));

        return response()->json(['message' => 'User successfully approved. User email notification sent...'], 200);
    }

    public function decline($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User request for registration successfully declined....'], 200);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    public function update_role(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required',
        ]);

        $user->role_id = $request->role_id;
        if ($user->role_id == 3) {
            $user->role_id = 2;
        }
        $user->save();
        return response()->json(['message' => 'User role updated successfully...']);
    }

    public function updateProfile(Request $request, $user)
    {
        $user = User::find($user);

        $validate = $request->validate([
            
            'name' => 'required|string|max:255',
            'phoneNumber' => 'required|digits:11',
            'companyName' => 'required',
            'companyRole' => 'required',
            'googleProfile' => 'nullable',
            'facebookProfile' => 'nullable',
            'image' => 'nullable|image:jpeg,png,jpg,gif,svg|max:2048',
            'companyWebsite' => 'string|max:255|nullable',
            
        ]);

        if ($request->hasFile('image')) {

            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/news_images',$fileNameToStore);
        }

        $user->name = $request->name;
        $user->phoneNumber = $request->phoneNumber;
        $user->companyName = $request->companyName;
        $user->companyRole = $request->companyRole;
        $user->googleProfile = $request->googleProfile;
        $user->facebookProfile = $request->facebookProfile;
        $user->image = $request->file('image') ? $fileNameToStore:null;
        $user->companyWebsite = $request->companyWebsite;
        // dd($user);

        $user->save();
        return response()->json(['User' => $user, 'message' => 'User Profile updated successfully...'], 200);
    }

    public function onlineUsers(Request $request)
    {
        $users = User::select("*")
                        ->whereNotNull('last_seen')
                        ->orderBy('last_seen', 'DESC')
                        ->paginate(10);
          
        return response()->json(['users' => $users],200);
    }
}


