<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/11/11
 * Time: 9:28
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller
{
    protected $request = null;
    public function __construct()
    {
        $this->init();
    }

    public function init(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 获取当前action
     * @param $request
     * @return false|string
     */
    public function getAction($request)
    {
        $a = $request->route();
        if(isset($a[1]['uses'])&&($pos = strpos($a[1]['uses'], "@")) !== false){
            return substr($a[1]['uses'], $pos + 1);
        }
        return '';
    }

    /**
     * 数据验证
     * @param $obj
     * @param $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function vValidate($obj,$request)
    {
        $action = $this->getAction($request);
        if(class_exists($obj)){
            $a =call_user_func_array([new $obj,'getScene'],[$action]);
            if($a){
                $param = $request->all();
                if($a['vli']){
                    foreach ($a['vli'] as $key=>$val){
                        $arr = explode(",",$val);
                        if(isset($arr[2])&&strpos($arr[2],"$")!==false){
                            $k = ltrim($arr[2],"$");
                            if(!isset($param[$k])){
                                $param[$k] = 0;
                            }
                            $a['vli'][$key] = str_replace($arr[2],$param[$k],$val);
                        }
                    }
                }
                //数据验证
                $this->validate($request,$a['vli'],$a['msg']);
            }
        }
    }
}