<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|string|email|max:255|unique:users',
            'frequency' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $report = Report::create([

            'email' => $request->get('email'),
            'frequency' => $request->get('frequency'),
        ]);

        return response()->json(['message' => "User successfully registered for $report->frequency report"], 200);
    }

    public function index()
    {
        $reports = Report::where('user_id', auth()->user()->id)->paginate(6);
        return response()->json(['Reports' => $reports], 201);
    }

    

    public function removeReport($id)
    {
        $report = Report::where('user_id', auth()->user()->id)->findOrFail($id);
        $report->delete();
        return response()->json(['message' => 'Post successfully removed.....']);
    }

    public function search($name)
    {
        $result = Report::where('email', 'LIKE', '%' . $name . '%')->orWhere('frequency', 'like', '%' . $name . '%')->orderBy('created_at', 'desc')->paginate(6);
        if (count($result)) {
            return Response()->json($result);
        } else {
            return response()->json(['Message' => 'Record not found!'], 404);
        }
    }

    public function edit($id)
    {
        $user = Report::findOrFail($id);
        return response()->json($user, 200);
    }

    public function changeReportFrequency(Request $request, $user)
    {
        $user = Report::find($user);

        $validate = $request->validate([

            'frequency' => 'required',
        ]);

        $user->frequency = $request->frequency;

        $user->save();
        return response()->json(['User' => $user, 'message' => 'User account updated successfully...'], 200);
    }
}
