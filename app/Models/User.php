<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/16
 * Time: 10:33
 */

namespace App\Models;


use App\Services\ParamImp;
use Tymon\JWTAuth\Contracts\JWTSubject;
use function App\Helps\encryPass;
use function App\Helps\err;
use function App\Helps\succ;

class User extends BaseModel implements JWTSubject
{
    protected $table = "user";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 重置密码
     */
    public function refreshPass($id,$pass)
    {
        try{
            $model = self::find($id);
            $model->password =$pass;
            $model->save();
            return succ(['sysMsg'=>"重置成功，重置密码为123456789"]);
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 修改密码
     */
    public function resetPass($params,$user)
    {
        try{
            $model = self::find($user->id);
            $hasher = app('auth')->guard('jwt')->getProvider()->getHasher();
            if (!$hasher->check($params['password'],$model->password)) {
                return err("原密码错误",10000);
            }
            $haser = encryPass($params['new_password']);
            $model->password =$haser;
            $model->api_token = '';
            $model->save();
            return succ();
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    /**
     * 修改token
     */
    public function refreshToken($token)
    {
        try{
            $this->api_token =$token;
            $this->save();
            return succ();
        }catch (\Exception $exception){
            return err($exception->getMessage());
        }
    }

    //修改器
    public function getSexTxtAttribute()
    {
        $val = $this->sex;
        if($val!==''){
            return ParamImp::where("type","sex")->where("code",$val)->value('name');
        }else{
            return '';
        }
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function role(){
        $roles = $this->belongsToMany(Role::class,'role_user','user_id');
        return $roles;
    }
}