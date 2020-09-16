<?php
/**
 * Created by IntelliJ IDEA.
 * BaseModel: LHC
 * Date: 2020/9/15
 * Time: 16:45
 */

namespace App\Http\Controllers;


use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Tymon\JWTAuth\JWTAuth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        JWTAuth::
//        var_dump($request);
//        echo $this->kk_md5("223");
        echo "<br/>";
//        echo Crypt::encrypt("222");
        echo "hello";
    }
}