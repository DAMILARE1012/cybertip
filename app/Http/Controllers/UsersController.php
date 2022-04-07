<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Notifications\InviteNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsersController extends Controller
{

    public function process_invites(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email'
        ]);
        $validator->after(function ($validator) use ($request) {
            if (Invite::where('email', $request->input('email'))->exists()) {
                $validator->errors()->add('email', 'There exists an invite with this email!');
            }
        });
        if ($validator->fails()) {
            return response()->json(['message' => 'Kindly input a user that does not exist yet']);
        }
        do {
            $token = Str::random(20);
        } while (Invite::where('token', $token)->first());
        Invite::create([
            'token' => $token,
            'email' => $request->input('email')
        ]);
        $url = URL::temporarySignedRoute(
            'registration',
            now()->addMinutes(300),
            ['token' => $token]
        );

        Notification::route('mail', $request->input('email'))->notify(new InviteNotification($url, $request->input('email')));

        return Response()->json(['message' => 'Invitation successfully sent'], 200);
    }

    public function registration_view($token)
    {
        $invite = Invite::where('token', $token)->first();
        return "Registration Form should be here";
        // return Response()->json(['message' => 'Welcome User', 'invite' => $invite], 200);
    }


    // Password reset for users.....

    public function getresetPassword(Request $request){
        return response()->json(['User' => $request->input('email'), 'message' => 'Reset passsword page should be here... Kindly create three fields (email, password and password confirmation)'], 201);
    }

    public function resetPassword(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        // Confirm email in the database....
        $user = DB::table('users')->where('email', '=', $request->email)->first();
        $user = User::find($user->id);
        $user->password = Hash::make($request->password);
        $user->update();
        return response()->json(['message' => 'Password registration successfully done...']);
    }
}
