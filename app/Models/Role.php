<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/27
 * Time: 17:18
 * 角色表
 */

namespace App\Models;

use App\Services\MenuImp;

class Role extends BaseModel
{
    protected $table = 'role';

    protected $casts = [
        'create_time'=>"datetime:Y-m-d",
    ];

    protected $appends = ['rules_txt'];

    public function getRulesTxtAttribute()
    {
        if($this->rules){
            $menu = new MenuImp();
            $res = $menu->getMenusFid($this->rules);
            $name = '';
            foreach ($res as $val){
                $name .= $val['name'].',';
            }
            return rtrim($name,',');
        }else{
            return '';
        }
    }
}