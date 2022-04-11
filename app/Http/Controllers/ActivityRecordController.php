<?php

namespace App\Http\Controllers;

use App\ActivityRecord;
use Illuminate\Http\Request;

class ActivityRecordController extends Controller
{
    public function onlineUsers()
    {

        $activeUsers = ActivityRecord::where('activity_status', 1)->paginate(6)->with('user')->get()->pluck('user');
        // $activeUsers = $activeUsers->reverse();
        return Response()->json(['User_Records' => $activeUsers], 200);
    }

    public function offlineUsers()
    {
        $inactiveUsers = ActivityRecord::where('activity_status', 0)->paginate(6)->with('user')->get()->pluck('user');
        // $inactiveUsers = $inactiveUsers->reverse();
        return Response()->json(['User_Records' => $inactiveUsers], 200);
    }
}
