<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function unapproved_users(){
        $users = User::where('admin_approval', '=', 0)->get();
        return response()->json($users, 200);
    }   

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['admin_approval' => 1]);
        return response()->json(['message' => 'User successfully approved...']);
    }

    public function decline($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User account declined successfully...']);
    }


    public function edit($id){
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    public function update_role(Request $request, User $user){
        
        $request->validate([
            'role_id' => 'required',
        ]);

        $user->role_id = $request->role_id;
        if($user->role_id == 3){
            $user->role_id = 2;
        }
        $user->save();
        return response()->json(['message' => 'User role updated successfully...']);
    }
}
