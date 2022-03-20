<?php

namespace App\Http\Controllers;

use App\Notifications\AcceptUserNotification;
use App\User;

use Illuminate\Http\Request;
use Notification;


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

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['admin_approval' => 1]);

        $details = [
            'greeting' => 'Approval Information',
            'body' => 'Your account registration has been approved, kindly make use of the registered details to access the login form.',
            'thanks' => 'Thank you for choosing CyberTip',
            'actionText' => 'View our Site',
            'actionURL' => url('localhost:8000/api/login'),
        ];

        $user->notify(new AcceptUserNotification($details));

        dd('done');

        return response()->json(['message' => 'User successfully approved...']);
    }

    public function decline($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User account declined successfully...']);
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
}
