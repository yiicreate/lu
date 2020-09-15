<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/15
 * Time: 16:45
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index()
    {
        echo $this->kk_md5("223");
        echo "<br/>";
        echo Crypt::encrypt("222");
        echo 2;
    }
}