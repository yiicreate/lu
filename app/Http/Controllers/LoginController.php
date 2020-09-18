<?php
/**
 * Created by IntelliJ IDEA.
 * BaseModel: LHC
 * Date: 2020/9/16
 * Time: 10:25
 */

namespace App\Http\Controllers;

use Illuminate\Hashing\ArgonHasher;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseContorller;
use Tymon\JWTAuth\JWTGuard;
use Tymon\JWTAuth\Providers\JWT\JWTInterface;

class LoginController extends BaseContorller
{
    public function doLogin(Request $request)
    {
        $jwt = app('auth')->guard('jwt');
        //设置过期时间
        $jwt->setTTL(60*24);

        $user = $jwt->getProvider()->retrieveByCredentials($request->only('name', 'password'));
        if(!$user){
            return response()->json(['user_not_found'], 404);
        }
        $token = $jwt->login($user);
        $user->refreshToken($token);

        return response()->json(compact('token'));
    }
}