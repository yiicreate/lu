<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/15
 * Time: 17:20
 */

namespace App\Http\Comm;


trait Common
{
    public function kk_md5($str)
    {
        return md5(sha1($str).config("key"));
    }
}