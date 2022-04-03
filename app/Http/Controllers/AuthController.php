<?php

namespace App\Http\Controllers;

use App\ActivityRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Util\Json;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phoneNumber' => 'required|digits:11',
            'companyName' => 'required',
            'companyRole' => 'required',
            'googleProfile' => 'nullable',
            'facebookProfile' => 'nullable',
            'image' => 'nullable|image:jpeg,png,jpg,gif,svg|max:2048',
            // 'role_id' => 'required',
            'companyWebsite' => 'string|max:255|nullable',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('image')) {

            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/news_images',$fileNameToStore);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phoneNumber' => $request->get('phoneNumber'),
            'companyName' => $request->get('companyName'),
            'companyRole' => $request->get('companyRole'),
            'googleProfile' => $request->get('googleProfile'),
            'facebookProfile' => $request->get('facebookProfile'),
            'image' => $request->file('image') ? $fileNameToStore:null,
            'role_id'=> 3,
            'companyWebsite' => $request->get('companyWebsite'),
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json(['User' => $user, 'role_name' => 'User', 'token' => JWTAuth::fromUser($user),  'message' => 'Welcome new user, your account has been successfully created'], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        $activityRecord = new ActivityRecord;
        $activityRecord->user_id = $user->id;
        $activityRecord->activity_status = 1;
        $activityRecord->save();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'User credentials not found!'], 400);
        }
        if ($user->admin_approval == 0 && $user->role_id == Role::USER) {
            return response()->json(['User' => $user, 'message' => 'Welcome user, login successful'], 200);
        }

        return response()->json(['role' => $user->role->role_name, 'message' => ' login successful', 'token' => JWTAuth::fromUser($user), 'User' => $user]);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        
        $activityRecord = ActivityRecord::find($request->id);
        $activityRecord->activity_status = 0;
        $activityRecord->save();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
