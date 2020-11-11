<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/28
 * Time: 10:52
 */

namespace App\Http\Validates;


class Validate
{
    public $rule = [];

    public $scene = [];

    public function __construct()
    {
        $this->rules();
    }

    public function rules(){}

    //正则自定义
    protected $regex = [
        'phone'=>'/^1[34578]\d{9}$/',//手机号
        'QQ'=>'/^\d{5,12}$/isu',//QQ号
        'weChat'=>"/^[_a-zA-Z0-9]{5,19}+$/isu",//微信号
    ];

    //获取场景验证
    public function getScene($scene)
    {
        $data = [
            'vli'=>[],
            'msg'=>[],
        ];
        if(!$this->scene||!isset($this->scene[$scene])){
            return false;
        }
        $scene_arr = explode(",",$this->scene[$scene]);
        foreach ($scene_arr as $val){
            if(isset($this->rule[$val])){
                $rules = $this->rule[$val];
                $data['vli'][$val] = $rules[0];
                if(isset($rules[1])&&!empty($rules[1])){
                    foreach ($rules[1] as $k=>$v){
                        $data['msg'][$val.'.'.$k] = $v;
                    }
                }
            }
        }
        return $data;
    }
}