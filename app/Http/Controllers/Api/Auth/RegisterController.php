<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterFormRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterFormRequest $request)
    {
        $password = Str::random(80);
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($password),
            'vk_link' => $request->vk_link,
            'description' => $request->description,
            'foto_link' => $request->foto_link,
        ]);

        $token = $user->createToken(config('Test'));
        $token->token->save();

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'token_type' => 'Bearer',
            'token' => $token->accessToken,
        ], 200);
    }
}
