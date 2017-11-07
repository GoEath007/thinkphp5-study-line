<?php

/** .-------------------------------------------------------------------
 * |  Github: https://github.com/Tinywan
 * |  Blog: http://www.cnblogs.com/Tinywan
 * |-------------------------------------------------------------------
 * |  Author: Tinywan(ShaoBo Wan)
 * |  DateTime: 2017/8/28 14:42
 * |  Mail: Overcome.wan@Gmail.com
 * '-------------------------------------------------------------------*/

namespace app\common\controller;

use app\common\library\Auth;
use think\Hook;
use think\Request;
use think\Url;

class BaseBackend extends Base
{
    // 用户ID
    protected $uid = 0;

    // 权限实例
    protected $auth;

    // 钩子获取角色
    protected $role;

    //构造方法
    public function __construct(Request $request = null)
    {
        // 添加钩子
        $result = Hook::listen('controller_init', $this, $request, true);
        if ($result) {
            // 当前角色名
            $this->role = $result;
        }
        parent::__construct($request);
    }

    /**
     * 初始化操作
     * 初始化方法里面的return操作是无效的，也不能使用redirect助手函数进行重定向
     * 如果你是要进行重定向操作（例如权限检查后的跳转）请使用$this->redirect()方法
     */
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->uid = session('admin.admin_id');
        // 登陆检查
        if (empty($this->uid)) {
             $this->error("您还没有登录，请登录后访问！",Url::build('backend/login/login'));
        }
        // 权限检查
        if($this->check_access() === false){
             $this->error("您没有访问权限！");
        }
    }

    /**
     * 检测权限
     * @param $uid
     */
    private function check_access()
    {
        $controllerName = strtolower($this->request->controller());
        $actionName = strtolower($this->request->action());
        $checkAuth = $controllerName . '/' . $actionName;
        $this->auth = new Auth();
        $checkResult = $this->auth->check($checkAuth, $this->uid);
        // public auth
        $openAuth = config('auth_config')['open_auth'];
        if (is_array($openAuth) AND in_array($checkAuth, $openAuth)) return true;
        if (!$checkResult) return false;
        return true;
    }

}