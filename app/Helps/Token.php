<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/16
 * Time: 11:42
 */

namespace App\Helps;


use Tymon\JWTAuth\JWTManager;
use Tymon\JWTAuth\Providers\JWT\JWTInterface;

class Token
{
    protected $jwt;

    public function __construct(JWTInterface $jwt)
    {
        $this->jwt = $jwt;
    }

    public function createToken()
    {
        $data = [
            'a'=>"bbbb",
        ];
        $str =  $this->jwt->encode($data);
//        $str = md5(uniqid(md5(microtime()), true));
//        $str = sha1($str);
        return $str;
    }

    public function getToken($token)
    {
        return $this->jwt->decode($token);
    }
}