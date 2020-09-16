<?php
/**
 * Created by IntelliJ IDEA.
 * User: LHC
 * Date: 2020/9/16
 * Time: 10:33
 */

namespace App\Models;


use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseModel implements JWTSubject
{
    protected $table = "user";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
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
}