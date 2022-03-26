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
}
