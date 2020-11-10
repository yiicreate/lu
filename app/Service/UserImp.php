<?php

namespace App\Service;

use App\Models\User;
use App\Services\RoleUserImp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helps\encryPass;
use function App\Helps\err;
use function App\Helps\succ;

class UserImp extends User
{
    //获取当前用户信息
    public function getUser()
    {
        try {
            $roleU = new RoleUserImp();
            $user = Auth::user();
            $menus = $roleU->getMenus($user->id);
            if($menus['code']){
                return $menus;
            }
            $role = $roleU->getRole($user->id);
            if($role['code']){
                return $role;
            }
            $data = [];
            $data['user'] = $user;
            $data['role'] = $role['data'];
            $data['menus'] = $menus['data'];
            return succ($data);
        } catch (\Exception $exception) {
            return err($exception->getMessage());
        }
    }

    //获取用户信息
    public function getList($id)
    {
        try {
            $model = $this->where("id",$id)->first(["id","name","user_name","sex","id_code","iphone"]);
            if (!$model) {
                return err('数据错误', 10001);
            }
            $res = $model->toArray();
            return succ($res);
        } catch (\Exception $exception) {
            return err($exception->getMessage());
        }
    }

    //获取用户信息
    public function getLists($params, $size = 15)
    {
        try {
            $res = $this->with(['role'])->paginate($size,["id","name","user_name","sex","id_code","iphone"]);
            $res = $res->toArray();
            if($res['data']){
                foreach ($res['data'] as $k=>$v){
                    $role = [
                        'code'=>'',
                        'name'=>''
                    ];
                    if($v['role']){
                        foreach ($v['role'] as $val){
                            $role['code'] .= $val['id'].",";
                            $role['name'] .= $val['role_name'].",";
                        }
                        $role['code'] = rtrim($role['code'],',');
                        $role['name'] = rtrim($role['name'],',');
                    }
                    $res['data'][$k]['role'] = $role;
                }
            }
            return succ($res);
        } catch (\Exception $exception) {
            return err($exception->getMessage());
        }
    }


    //新增管理员
    public function addUser($params,$user)
    {
        DB::beginTransaction();
        try{
            $model = $this;
            $model->name = $params['name'];
            $model->password = encryPass(123456789);
            $model->user_name = $params['user_name'];
            $model->api_token = '';
            $model->sex = $params['sex'];
            $model->id_code = $params['id_code'];
            $model->iphone = $params['iphone'];
            $model->create_time = time();
            $model->create_man = $user->id;
            $model->save();

            $role_arr = explode(',',$params['role']);
            if($role_arr){
                $roles = [];
                foreach ($role_arr as $val){
                    $roles[] = [
                        'role_id'=>$val,
                        'user_id'=>$model->id,
                    ];
                }
                DB::table("role_user")->insert($roles);
            }

            DB::commit();
            return succ();
        }catch (\Exception $exception){
            DB::rollBack();
            return err($exception->getMessage());
        }
    }

    //修改管理员
    public function updateUser($params)
    {
        DB::beginTransaction();
        try{
            $model = self::find($params['id']);
            if (!$model) {
                return err('数据错误', 10001);
            }
            $model->user_name = $params['user_name'];
            $model->sex = $params['sex'];
            $model->id_code = $params['id_code'];
            $model->iphone = $params['iphone'];
            $model->save();

            $role_arr = explode(',',$params['role']);
            if($role_arr){
                DB::table("role_user")->where('user_id',$model->id)->delete();
                $roles = [];
                foreach ($role_arr as $val){
                    $roles[] = [
                        'role_id'=>$val,
                        'user_id'=>$model->id,
                    ];
                }
                DB::table("role_user")->insert($roles);
            }
            DB::commit();
            return succ();
        }catch (\Exception $exception){
            DB::rollBack();
            return err($exception->getMessage());
        }
    }
}
