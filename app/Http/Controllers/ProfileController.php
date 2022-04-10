<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
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

    public function index()
    {
        $digital_profile = Profile::orderBy('created_at', 'desc')->paginate(2);
        return response()->json($digital_profile, 200);
    }

    // Edit digital profile....
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return response()->json($profile, 200);
    }

    // Update digital profile....
    public function updateProfile(Request $request, $id)
    {
        $profile = Profile::find($id);

        $validate = $request->validate([
            'domain' => 'required',
            'ipAddress' => 'required',
            'keywords' => 'required',
        ]);

        $profile->domain = $request->domain;
        $profile->ipAddress = $request->ipAddress;
        $profile->keywords = $request->keywords;

        $profile->save();
        return response()->json(['Profile' => $profile, 'message' => 'Digital profile updated successfully...'], 200);
    }

    // Search digital profile by domain.....
    public function searchProfile($value)
    {
        $result = Profile::where('domain', 'LIKE', '%' . $value . '%')->get();
        if (count($result)) {
            return Response()->json($result);
        } else {
            return response()->json(['Message' => 'Record not found!'], 404);
        }
    }
}
