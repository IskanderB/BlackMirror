<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function getUser(Request $request)
    {
        $user = User::select()->where('id', '=', $request->user_id)->limit(1)->get();
        return response()->json([
            'user' => $user,
        ], 200);
    }
}
