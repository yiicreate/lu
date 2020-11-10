<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/16
 * Time: 11:42
 */

namespace App\Helps;


class Token
{
    public function createToken($uid)
    {
        $str = md5(uniqid(md5(microtime(true)),true));
        $token = sha1($str.$uid);
        return $token;
    }

    public function getToken($token)
    {

    }
}