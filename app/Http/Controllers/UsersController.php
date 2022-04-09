<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Notifications\InviteNotification;
use App\Role;
use App\User;
use Carbon\Carbon;
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
            'email' => 'required|email|unique:users,email',
            'companyName' => 'required',
            'role_id' => 'required'
        ]);
        $validator->after(function ($validator) use ($request) {
            if (Invite::where('email', $request->input('email'))->exists()) {
                $validator->errors()->add('email', 'There exists an invite with this email!');
            }
        });
        if ($validator->fails()) {
            return response()->json(['message' => 'Kindly input a user that does not exist yet']);
        }
        // do {
        //     $token = Str::random(20);
        // } while (Invite::where('token', $token)->first());

        if ($request->input('role_id') == 3) {
            $usersPassword = "mypassword";
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phoneNumber' => "",
                'companyName' => $request->get('companyName'),
                'companyRole' => "",
                'googleProfile' => "",
                'facebookProfile' => "",
                'image' => null,
                'role_id' => Role::where('role_id', 3)->first()->role_id,
                'companyWebsite' => $request->get('companyWebsite'),
                'timeIn' => null,
                'timeOut' => null,
                'password' => Hash::make($usersPassword),
            ]);
        }
        if ($request->input('role_id') == 2) {
            $usersPassword = "mypassword";
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phoneNumber' => "",
                'companyName' => $request->get('companyName'),
                'companyRole' => "",
                'googleProfile' => "",
                'facebookProfile' => "",
                'image' => null,
                'role_id' => Role::where('role_id', 2)->first()->role_id,
                'companyWebsite' => $request->get('companyWebsite'),
                'timeIn' => Carbon::now()->toDateTimeString(),
                'timeOut' => null,
                'password' => Hash::make($usersPassword),
            ]);
        }

        $url = URL::temporarySignedRoute(
            'invitation_password_reset',
            now()->addMinutes(300),
            ['token' => $request->input('email')]
        );

        Notification::route('mail', $request->input('email'))->notify(new InviteNotification($url, $user));

        return Response()->json(['message' => 'Invitation successfully sent'], 200);
    }

    public function getinvitationPwdReset(Request $request)
    {
        return response()->json(['message' => 'Reset passsword page should be here... Kindly create three fields (email, password and password confirmation)'], 201);
    }

    public function invitationSetPassword(Request $request)
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

    // public function registration_view($token)
    // {
    //     $invite = Invite::where('token', $token)->first();
    //     return "Registration Form should be here";
    //     // return Response()->json(['message' => 'Welcome User', 'invite' => $invite], 200);
    // }

    // Password reset for users.....

    public function getresetPassword(Request $request)
    {
        return response()->json(['message' => 'Reset passsword page should be here... Kindly create three fields (email, password and password confirmation)'], 201);
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
