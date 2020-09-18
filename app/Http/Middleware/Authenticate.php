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
        try{
            app("auth")->guard("jwt")->setToken($token)->getPayload();
        }catch (JWTException $e){
            $msg = $e->getMessage();
            if($msg == 'Token has expired'){
                return response('token过期', 401);
            }
        }
        $guard =  $this->auth->guard($guard);
        if ($guard->guest()) {
            return response('请登录', 401);
        }
        return $next($request);
    }
}
