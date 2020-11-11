<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/27
 * Time: 17:19
 */

namespace App\Services;


use App\Models\Role;
use function App\Helps\err;
use function App\Helps\succ;

class RoleImp extends Role
{
    /**
     * 获取所有角色(分页)
     * @param $params
     * @param int $size
     * @return array
     */
    public function getLists($params,$size=15)
    {
        try{
            $res = self::paginate($size);
            return succ($res->toArray());
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 获取角色
     * @param $params
     * @param int $size
     * @return array
     */
    public function getList($id)
    {
        try{
            $res = self::find($id);
            return succ($res->toArray());
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 设置角色权限
     * @param $params
     * @param int $size
     * @return array
     */
    public function setAuthor($params)
    {
        try{
            $model = self::find($params['id']);
            $model->rules= $params['rules'];
            $model->save();
            return succ();
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 获取所有角色(不分页)
     * @return array
     */
    public function getAllLists()
    {
        try{
            $res = $this->where('id',"<>",5)->get(['id','role_name']);
            return succ($res->toArray());
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }
}