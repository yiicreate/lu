<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/27
 * Time: 19:00
 */

namespace App\Services;


use App\Models\Department;
use function App\Helps\err;
use function App\Helps\succ;

class DepartmentImp extends Department
{
    /**
     * 按等级查询部门
     * @param int $pid
     * @return array
     */
    public function getLevelLists($pid=0)
    {
        try{
            $res = self::where("pid",$pid)
                ->get(['id','name','level']);
            return succ($res->toArray());
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 新增部门
     * @param $params
     * @param $user
     * @return array
     */
    public function addDept($params,$user)
    {
        try{
            $model = $this;
            $model->name = $params['name'];
            $model->pid = $params['pid'];
            $model->level = $params['level'];
            $model->create_time = time();
            $model->create_man = $user->id;
            $model->save();
            return succ();
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * @param $params
     * @param $user
     * @return array
     */
    public function updateDept($params)
    {
        try{
            $model = self::find($params['id']);
            if(!$model){
                return err('无数据',10000);
            }
            $model->name = $params['name'];
            $model->pid = $params['pid'];
            $model->level = $params['level'];
            $model->save();
            return succ();
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * @param $params
     * @param $user
     * @return array
     */
    public function findDept($id)
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
     * 查询所有部门
     * @param int $pid
     * @return array
     */
    public function getAllLists($pid=0)
    {
        try{
            $res = self::where("pid",$pid)
                ->get(['id','name','level']);
            $res = $res->toArray();
            if($res){
                foreach ($res as $key=>$val){
                    $a = $this->getLevelLists($val['id']);
                    if($a['code'] == 0){
                        $res[$key]['children'] = $a['data'];
                    }
                }
            }
            return succ($res);
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 查询部门名，全
     * @param $id
     * @return string
     */
    public static function getDeptAllName($id)
    {
        $name = '';
        $res = self::where('id',$id)->first(['pid','name'])->toArray();
        $name .= "/".$res['name'];
        if($res['pid']>0){
            $res1 = self::where('id',$res['pid'])->first(['name'])->toArray();
            $name = $res1['name'].$name;
        }
        return ltrim($name,'/');

    }


    /**
     * 查询全部部门id
     * @param $id
     * @return string
     */
    public static function getDeptAllId($id)
    {
        $str = '';
        $res = self::where('id',$id)->first(['pid','name'])->toArray();
        $str .= ",".$id;
        if($res['pid']>0){
            $str = $res['pid'].$str;
        }
        return ltrim($str,',');
    }

    /**
     * 查询部门id以及power
     * @param $name
     * @return array|bool
     */
    public static function getDeptByName($name)
    {
        if(!$name){
            return  false;
        }
        $arr = explode("/",$name);
        $res = self::where('name',$arr[0])->first(['id','name']);
        if($res){
            $res = $res->toArray();
            $dept_id =  $res['id'];
            $dept_power =  $res['id'];
            if($arr[1]){
                $res1 = self::where('name',$arr[1])->where('pid',$res['id'])->first(['id','name']);
                if($res1){
                    $res1 = $res1->toArray();
                    $dept_id =  $res1['id'];
                    $dept_power .=  ','.$res1['id'];
                }
            }
            return [
                'dept_id' =>$dept_id,
                'dept_power' =>$dept_power,
            ];
        }else{
            return  false;
        }
    }
}