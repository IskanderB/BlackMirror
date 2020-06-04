<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class GetUserController extends Controller
{
    const PERIOD = 20;

    public function getUser(Request $request)
    {
        if ($this->checkType($request->this_user_id)) {
            if ($this->checkTime($request->this_user_id)) {
                $item = $this->getRandItem($request->this_user_id);
                $user = User::select('name', 'vk_link', 'description', 'foto_link')->skip($item)->take(1)->get();

                $permission_time = time() + self::PERIOD;
                $this->updateTime($permission_time, $request->this_user_id);
                return response()->json([
                    'user' => $user,
                    'permission_time' => $permission_time,
                ], 200);
            }
            else {
                return response()->json([
                    'success' => false,
                    'error' => 'Time is not enought. Permission denied.',
                ], 403);
            }
        }
        else {
            return response()->json([
                'success' => false,
                'error' => 'Incorrect data',
            ], 422);
        }
    }

    private function checkType($id)
    {
        return (integer)$id;
    }

    private function updateTime($permission_time, $id)
    {
        User::where('id', '=', $id)->update([
            'permission_time' => $permission_time,
        ]);
    }

    private function getRandItem($id)
    {
        while (true) {
            $item = rand(0, User::count() - 1);
            if (($item + 1) != $id) {
                return $item;
            }
        }
    }

    private function checkTime($id)
    {
        $permission_time = User::select('permission_time')->where('id', '=', $id)->limit(1)->get();
        if (time() > $permission_time[0]->permission_time) {
            return true;
        }
        else {
            return false;
        }
    }
}
