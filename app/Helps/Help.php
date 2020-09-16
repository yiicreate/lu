<?php
/**
 * Created by IntelliJ IDEA.
 * BaseModel: LHC
 * Date: 2020/9/15
 * Time: 17:20
 */

namespace App\Helps;


class Help
{
    public static function kk_md5($str)
    {
        return md5(sha1($str).config("key"));
    }
}