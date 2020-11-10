<?php
/**
 * Created by IntelliJ IDEA.
 * BaseModel: LHC
 * Date: 2020/9/16
 * Time: 10:25
 */

namespace App\Http\Controllers;

use App\Helps\AuthUser;
use Illuminate\Hashing\ArgonHasher;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseContorller;
use Tymon\JWTAuth\JWTGuard;
use function App\Helps\encryPass;
use function App\Helps\err;
use function App\Helps\succ;
use function App\Helps\success;


class LoginController extends BaseContorller
{

    public function doLogin(Request $request)
    {
        $authUser = new AuthUser();
        if (! $token = $authUser->attempt($request->only('name', 'password'))) {
            return success(err("用户名或密码错误",10000));
        }
        if($token){
            //更新token
            $authUser->user()->refreshToken($token);
            return success(succ(compact('token')));
        }else{
            return success(err("登录失败",10000));
        }
    }
}