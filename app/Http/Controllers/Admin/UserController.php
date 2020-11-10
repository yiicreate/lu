<?php
/**
 * Created by IntelliJ IDEA.
 * BaseModel: LHC
 * Date: 2020/9/15
 * Time: 16:45
 */

namespace App\Http\Controllers\Admin;


use App\Http\Validates\UserValidate;
use App\Service\UserImp;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Request;
use function App\Helps\encryPass;
use function App\Helps\success;

class UserController extends Controller
{
    protected $userImp;

    public function __construct(Request $request,UserImp $userImp)
    {
        $this->userImp = $userImp;
        parent::__construct($request);
//        $this->vValidate(UserValidate::class,$request);
    }

    /**
     * 获取当前人员信息（包含菜单，角色等信息）
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser()
    {
        $jwt   = app('auth')->guard('jwt');
        echo $jwt->getProvider()->getHasher()->make(123456);
        die;
        $res = $this->userImp->getUser();
        return success($res);
    }

    /**
     * 获取人员信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList()
    {
        $id = $this->request->get('id');
        $res = $this->userImp->getList($id);
        return success($res);
    }

    /**
     * 获取人员信息列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLists()
    {
        $params = $this->request->post();
        $size = $params['pageSize']??15;
        $res = $this->userImp->getLists($params,$size);
        return success($res);
    }

    /**
     * 新增管理员
     * @return \Illuminate\Http\JsonResponse
     */
    public function setOne()
    {
        $params = $this->request->post();
        $res = $this->userImp->addUser($params,$this->user);
        return success($res);
    }

    /**
     * 修改管理员
     * @return \Illuminate\Http\JsonResponse
     */
    public function setOneFId()
    {
        $params = $this->request->post();
        $res = $this->userImp->updateUser($params);
        return success($res);
    }


    /**
     * 重置密码
     */
    public function refreshPassword()
    {
        $id = $this->request->get('id');
        $haser = encryPass(123456789);
        $res = $this->user->refreshPass($id,$haser);
        return success($res);
    }

    /**
     * 修改密码
     */
    public function resetPassword(Request $request)
    {
        $params = $this->request->post();
        $res = $this->user->resetPass($params,$this->user);
        return success($res);
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        $res = $this->user->refreshToken('');
        return success($res);
    }
}