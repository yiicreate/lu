<?php
/**
 * 用户认证
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\RequestGuard;
use Illuminate\Contracts\Auth\Factory as Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTGuard;
use function App\Helps\err;
use function App\Helps\success;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('token');

        $res = app("auth")->guard("jwt")->setToken($token)->getPayload();
        if($res&&isset($res['exp'])&&$res['exp']<=time()){
            return success(err('token过期',601));
        }
        $guard =  $this->auth->guard($guard);
        if ($guard->guest()) {
            return success(err('用户未登录',101));
        }
        return $next($request);
    }
}
