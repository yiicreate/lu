<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/10/10
 * Time: 10:12
 */

namespace App\Http\Validates;


use function App\Helps\checkIdCode;

class UserValidate extends Validate
{
    public function rules(){
        $this->rule = [
            'id' =>['required',['required'=>'主键不能为空']],
            'name' =>['required|unique:user',['required'=>'用户名必须','unique'=>'用户名唯一']],
        ];
        $this->rule['id_code'] = [
            ['required',function($attribute, $value, $fail){
                $res =  checkIdCode($value);
                if(!$res){
                    return $fail('身份证错误');
                }
            }]
        ];
        $this->rule['iphone'] = [
            'regex:'.$this->regex['phone'],['regex'=>'电话有误']
        ];
    }


    public $scene = [
        'setOne'=>'name',
        'setOneFId'=>'id',
    ];
}