<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/16
 * Time: 11:42
 */

namespace App\Helps;


use Tymon\JWTAuth\Providers\JWT\Provider;

class AuthUser
{
    protected $jwt;

    protected $user;

    public function __construct()
    {
        $this->jwt = app('auth')->guard('jwt');
    }

    public function attempt(array $credentials = [])
    {
        $this->user = $user = $this->jwt->getProvider()->retrieveByCredentials($credentials);

        if ($this->hasValidCredentials($user, $credentials)) {
            return $this->jwt->login($user);
        }
        return false;
    }

    public function hasValidCredentials($user, $credentials)
    {
        return $user !== null && $this->validateCredentials($user, $credentials);
    }

    public function validateCredentials($user, $credentials)
    {
        if (empty($credentials)){
            return false;
        }
        if($user->password===encryPass($credentials['password'])){
            return true;
        }
        return false;
    }

    public function user()
    {
        return $this->user;
    }
}