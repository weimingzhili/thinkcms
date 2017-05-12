<?php

namespace app\admin\controller;

use think\Controller;

use think\Exception;

use think\Loader;

use think\Request;

use think\Session;

/**
 * 登录控制器
 * @author WeiZeng
 */
class Login extends Controller
{
    /**
     * 登录页
     * @access public
     * @param Request $request 请求对象
     * @return \think\Response
     */
    public function index(Request $request)
    {
        // 判断管理员是否登录
        if(Session::has('admin') && $request->session('admin.isLogin') == 1) {
            // 重定向到后台首页
            $this->redirect('admin/Index/index');
        }

        // 输出页面
        return $this->fetch();
    }

    /**
     * 登录
     * @access public
     * @param Request $request 请求对象
     * @return array
     */
    public function login(Request $request)
    {
        // 获取请求参数
        $param             = [];
        $param['account']  = $request->param('account', '', 'trim,htmlspecialchars');  // 账号
        $param['password'] = $request->param('password', '', 'trim,htmlspecialchars'); // 密码
        $param['captcha']  = $request->param('captcha', '', 'trim,htmlspecialchars');  // 验证码
        // 验证参数
        $checkRes = $this->validate($param, 'Admin.login');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 登录验证
        $adminModel = Loader::model('Admin');
        $result = $adminModel->loginCheck($param['account'], $param['password']);
        if($result === false) {
            return ['status' => 0, 'message' => '登录失败'];
        }

        // 写入session
        $sessionData                    = [];
        $sessionData['account']         = $param['account'];
        $sessionData['isLogin']         = 1;
        $sessionData['type']            = $result->type;
        $sessionData['last_login_time'] = $result->last_login_time;
        $sessionData['last_login_ip']   = $result->last_login_ip;
        Session::set('admin', $sessionData);

        // 登录更新
        try {
            // 更新数据
            $updateData                    = [];
            $updateData['account']         = $param['account'];
            $updateData['last_login_time'] = time();
            $updateData['last_login_ip']   = $request->ip(0, true);
            // 更新记录
            $updateRes = $adminModel->loginUpdate($updateData);
            if($updateRes === true) {
                return ['status' => 1, 'message' => '登录成功'];
            }

            return ['status' => 0, 'message' => '登录更新失败'];
        } catch (Exception $e) {
            // 处理异常
            return ['status' => 0, 'message' => $e->getMessage()];
        }
    }

    /**
     * 注销
     * @access public
     */
    public function logout()
    {
        // 删除管理员数据
        Session::delete('admin');

        // 重定向到登录页
        $this->redirect('admin/Login/index');
    }
}
