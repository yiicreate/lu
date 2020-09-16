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
//        $jwt = app('auth')->guard('jwt');
//        $haser = $jwt->getProvider()->getHasher();
//        var_dump($haser->make(123456));die;
//        $user = $jwt->getProvider()->retrieveByCredentials($request->only('name', 'password'));
//        $token = $jwt->login($user);
        if (! $token = app('auth')->guard('jwt')->attempt($request->only('email', 'password'))) {
            return response()->json(['user_not_found'], 404);
        }
        return response()->json(compact('token'));
    }
}