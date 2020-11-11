<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/27
 * Time: 16:32
 */

namespace App\Services;


use App\Models\RoleUser;
use Illuminate\Support\Facades\DB;
use function App\Helps\err;
use function App\Helps\succ;

class RoleUserImp extends RoleUser
{
    //获取用户菜单
    public function getMenus($userId)
    {
        try{
            do{
                $err = '';
                $roleUser = self::where("user_id",$userId)->get(["role_id"]);
                if(!$roleUser){
                    $err = "暂无分配角色";
                    break;
                }
                $roleUser = $roleUser->toArray();
                $rules = RoleImp::whereIn("id",array_column($roleUser,"role_id"))->get(['rules']);
                if(!$rules){
                    $err = "角色没有分配权限";
                    break;
                }
                $rules_str = implode(",",array_column($rules->toArray(),"rules"));
                $menus = DB::table('menu')->whereIn("id",explode(",",$rules_str))->get(["id",'code','name']);
            }while(0);
            if($err){
                return err($err,10000);
            }else{
                return succ($menus);
            }
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    //查询管理员角色
    public function getRole($userId)
    {
        try{
            $roleUser = DB::table("role_user as a")
                ->leftJoin("role as b","a.role_id",'=',"b.id")
                ->where("a.user_id",$userId)
                ->first(["a.role_id as id","b.role_name"]);
            return succ($roleUser);
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }

    }
}