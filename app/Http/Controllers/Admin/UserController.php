<?php
/**
 * Created by IntelliJ IDEA.
 * BaseModel: LHC
 * Date: 2020/9/15
 * Time: 16:45
 */

namespace App\Http\Controllers\Admin;


use App\Listeners\EventListener;
use Illuminate\Auth\Access\Gate;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\JWTGuard;
use Tymon\JWTAuth\Providers\JWT\Lcobucci;

class UserController extends Controller
{
    public function index(Request $request)
    {
        echo "hello";
        echo $this->user->id;
    }

    /**
     * 重置密码
     */
    public function refreshPassword()
    {
        $jwt = app('auth')->guard('jwt');
        $haser = $jwt->getProvider()->getHasher()->make(123456789);
        $this->user->refreshPass($haser);
    }

    /**
     * 修改密码
     */
    public function Password()
    {
        echo 11333;
        event(new EventListener(["aaa"]));
    }
}