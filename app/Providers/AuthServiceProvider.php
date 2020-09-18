<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        echo 1;
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a BaseModel instance or null. You're free to obtain
        // the BaseModel instance via an API token or any other method necessary.
        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->header('token');
            if ($token) {
                return User::where('api_token', $token)->first(["id","name","api_token"]);
            }
        });
    }
}
