<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/18
 * Time: 11:03
 *
 * 接口权限验证
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class AdminPermission
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $admin;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct()
    {

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

        return $next($request);
    }
}