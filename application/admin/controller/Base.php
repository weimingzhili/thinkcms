<?php

namespace app\admin\controller;

use think\Controller;

use think\Loader;

use think\Session;

/**
 * 基础控制器
 * @author WeiZeng
 */
class Base extends Controller
{
    /**
     * 初始化
     * @access public
     */
    public function _initialize()
    {
        // 继承父类的初始化方法
        parent::_initialize();

        // 判断管理员是否登录
        $this->checkLogin();

        // 获取管理员账号
        $account = $this->request->session('admin.account');

        // 获取导航菜单
        $naves = $this->getNav();

        // 注册数据
        $this->assign([
            'account'    => $account,
            'naves'      => $naves,
        ]);
    }

    /**
     * 检查管理员是否登录
     * @access protected
     */
    protected function checkLogin()
    {
        // 判断管理员是否登录
        if(!Session::has('admin') || $this->request->session('admin.isLogin') !=1 ) {
            // 重定向到登录页
            $this->redirect('admin/Login/index');
        }
    }

    /**
     * 获取导航菜单
     * @access public
     * @return object
     */
    public function getNav()
    {
        // 获取菜单
        $menuModel = Loader::model('Menu');
        $naves     = $menuModel->getAdminMenuAll();

        // 权限控制
        if($this->request->session('admin.type') == 2) {
            foreach ($naves as $key => $value) {
                if($value->menu_name == '管理员管理') {
                    unset($naves[$key]);

                    break;
                }
            }
        }

        return $naves;
    }
}
