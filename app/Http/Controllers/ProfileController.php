<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'companyName' => 'required',
            'domain' => 'required',
            'ipAddress' => 'required',
            'keywords' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $profile = Profile::create([
            'companyName' => $request->get('companyName'),
            'domain' => $request->get('domain'),
            'ipAddress' => $request->get('ipAddress'),
            'keywords' => $request->get('keywords')
        ]);

        return response()->json(['Profile' => $profile, 'message' => 'You have successfully registered your company\'s profile. Thanks'], 200);
    }

    public function index(){
        $digital_profile = Profile::orderBy('created_at', 'desc')->paginate(6);
        return response()->json($digital_profile, 200);
    }
}
