<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/16
 * Time: 10:53
 */

namespace App\Http\Middleware;

use Closure;

class BeforeMiddleware
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
        return $next($request);
    }
}