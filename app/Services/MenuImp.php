<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/27
 * Time: 16:26
 */

namespace App\Services;


use App\Models\Menu;
use function App\Helps\err;
use function App\Helps\succ;

class MenuImp extends Menu
{
    /**
     * 新增菜单
     * @param $params
     * @param $user
     * @return array
     */
    public function addMenu($params)
    {
        try{
            $model = $this;
            $model->name = $params['name'];
            $model->code = $params['code'];
            $model->url = $params['url'];
            $model->status = $params['status'];
            $model->save();
            return succ();
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 修改菜单
     * @param $params
     * @return array
     */
    public function updateMenu($params)
    {
        try{
            $model = self::find($params['id']);
            if(!$model){
                return err('无数据',10000);
            }
            $model->name = $params['name'];
            $model->code = $params['code'];
            $model->url = $params['url'];
            $model->status = $params['status'];
            $model->save();
            return succ();
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 查询单个菜单
     * @param $params
     * @return array
     */
    public function getMenu($id)
    {
        try{
            $model = self::find($id);
            if(!$model){
                return err('无数据',10000);
            }
            return succ($model->toArray());
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 查询一些菜单
     * @param $ids
     * @return array
     */
    public function getMenusFid($ids)
    {
        try{
            $res = $this->whereIn('id',explode(",",$ids))->get(['id','name']);
            return $res->toArray();
        }catch (\Exception $exception){
            return [];
        }
    }

    /**
     * 获取菜单列表
     * @param $params
     * @param int $size
     * @return array
     */
    public function getMenus($params,$size=15)
    {
        try{
            $res = self::paginate($size);
            return succ($res->toArray());
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 获取菜单列表
     * @param $params
     * @param int $size
     * @return array
     */
    public function getAllMenus($params)
    {
        try{
            $res = $this->where('status',1)->get();
            return succ($res->toArray());
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }
}