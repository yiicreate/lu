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
use function App\Helps\err;
use function App\Helps\succ;
use function App\Helps\success;


class LoginController extends BaseContorller
{
    public function doLogin(Request $request)
    {
        $jwt = app('auth')->guard('jwt');
        //设置过期时间
        $jwt->setTTL(config('conf.auth.ttl'));

        if (! $token = $jwt->attempt($request->only('name', 'password'))) {
            return success(err("用户名或密码错误",10000));
        }
        if($token){
            //更新token
            $jwt->user()->refreshToken($token);
            return success(succ(compact('token')));
        }
    }
}