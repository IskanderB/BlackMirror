<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthenticateOnceWithBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($request->id) and isset($request->password)) {
            $user = User::select()->where('id', '=', $request->id)->limit(1)->get();
            return response()->json([
                'user' => $user,
            ], 200);
            if(Hash::check($request->password, $user->password)){
                return response()->json([
                    'user' => $user,
                ], 200);
            }
            else {
                return response()->json([
                    'message' => 'Incorrect data1',
                ], 404);
            }
        }
        else {
            return response()->json([
                'message' => 'Incorrect data2',
            ], 404);
        }
        // return Auth::onceBasic() ?: $next($request);
    }
}
