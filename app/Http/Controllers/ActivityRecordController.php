<?php

namespace App\Http\Controllers;

use App\ActivityRecord;
use Illuminate\Http\Request;

class ActivityRecordController extends Controller
{
    public function onlineUsers(){
        
        $activeUsers = ActivityRecord::where('activity_status', 1)->first();
        // $activeUsers = $activeUsers->reverse();
        return Response()->json(['User_Records' => $activeUsers->user], 200);
    }

    public function offlineUsers(){
        $inactiveUsers = ActivityRecord::where('activity_status', 0)->first();
        // $inactiveUsers = $inactiveUsers->reverse();
        return Response()->json(['User_Records' => $inactiveUsers->user], 200);
    }
}
