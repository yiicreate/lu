<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/16
 * Time: 11:42
 */

namespace App\Helps;

class AuthUser
{
    protected $jwt;

    protected $user=null;

    public function __construct()
    {
        $this->jwt = app('auth')->guard('jwt');
    }

    /**
     * 用户认证 并返回token
     * @param array $credentials
     * @return bool
     */
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

    /**
     * 返回user
     * @return null
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * 解密token
     * @param $token
     * @return array
     */
    public function getToken($token)
    {
        try{
            $res = $this->jwt->setToken($token)->getPayload();
            return $res->toArray();
        }catch (\Exception $exception){
            return [];
        }
    }
}