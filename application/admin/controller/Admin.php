<?php

namespace app\admin\controller;

use think\Exception;

use think\Loader;

use think\Request;

use think\Session;

/**
 * 管理员控制器
 * @author WeiZeng
 */
class Admin extends Base
{
    /**
     * 列表页
     * @access public
     * @return \think\Response
     */
    public function index()
    {
        // 获取分页数据
        $adminModel = Loader::model('Admin');
        $pageData   = $adminModel->adminPaginate();

        // 注册数据
        $this->assign([
            'pageList' => $pageData['pageList'],
            'pageNav'  => $pageData['pageNav'],
        ]);

        // 输出页面
        return $this->fetch();
    }

    /**
     * 添加，GET请求输出添加页，POST请求执行添加操作
     * @access public
     * @param Request $request 请求对象
     * @return array|\think\Response
     */
    public function add(Request $request)
    {
        // 输出添加页
        if($request->isGet()) {
            return $this->fetch();
        }

        // 请求参数
        $param              = [];
        $param['account']   = $request->param('account', '', 'trim,htmlspecialchars');   // 账号
        $param['password']  = $request->param('password', '', 'trim,htmlspecialchars');  // 密码
        $param['real_name'] = $request->param('real_name', '', 'trim,htmlspecialchars'); // 真名
        $param['email']     = $request->param('email', '', 'trim,htmlspecialchars');     // email
        $param['type']      = $request->param('type', 2, 'intval');                      // 类型
        // 验证参数
        $checkRes = $this->validate($param, 'Admin.add');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 添加
        try {
            $adminModel = Loader::model('Admin');
            $result     = $adminModel->adminAdd($param);
            if($result === true) {
                return ['status' => 1, 'message' => '添加成功'];
            }

            return ['status' => 0, 'message' => '添加失败'];
        } catch (Exception $e) {
            // 处理异常
            return ['status' => 0, 'message' => $e->getMessage()];
        }
    }

    /**
     * 个人中心
     * @access public
     * @param Request $request 请求对象
     * @return array
     */
    public function personalCenter(Request $request)
    {
        // 输出个人中心页
        if($request->isGet()) {
            // 获取管理员账号
            $account = $request->session('admin.account', '');
            // 获取管理员信息
            $adminModel = Loader::model('Admin');
            $admin      = $adminModel->getAdminByAccount($account);

            // 注册数据
            $this->assign([
                'account'   => $account,
                'admin'     => $admin
            ]);

            return $this->fetch();
        }

        // 请求参数
        $param              = [];
        $param['admin_id']  = $request->param('admin_id', 0, 'intval');                  // 主键
        $param['account']   = $request->param('account', '', 'trim,htmlspecialchars');   // 账号
        $param['real_name'] = $request->param('real_name', '', 'trim,htmlspecialchars'); // 真名
        $param['email']     = $request->param('email', '', 'trim,htmlspecialchars');     // email
        // 验证参数
        $checkRes = $this->validate($param, 'Admin.save');
        if($checkRes !== true) {
            return ['status' =>0 ,'message' => $checkRes];
        }

        // 保存
        try {
            $adminModel = Loader::model('Admin');
            $result     = $adminModel->adminUpdate($param);
            if($result === true) {
                // 更新session
                Session::set('admin.account', $param['account']);

                return ['status' => 1, 'message' => '保存成功'];
            }

            return ['status' => 0, 'message' => '保存失败'];
        } catch (Exception $e) {
            // 处理异常
            return ['status' => 0, 'message' => $e->getMessage()];
        }
    }

    /**
     * 设置状态
     * @access public
     * @param Request $request 请求对象
     * @return array
     */
    public function setStatus(Request $request)
    {
        // 请求参数
        $param             = [];
        $param['admin_id'] = $request->param('admin_id', 0, 'intval'); // 主键
        $param['status']   = $request->param('status', 0, 'intval'); // 状态
        // 验证参数
        $checkRes = $this->validate($param, 'Admin.setStatus');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 更新状态
        try {
            $adminModel = Loader::model('Admin');
            $result     = $adminModel->updateStatus($param);
            if($result === true) {
                return ['status' => 1, 'message' => '操作成功'];
            }

            return ['status' => 0, 'message' => '操作失败'];
        } catch (Exception $e) {
            // 处理异常
            return ['status' => 0, 'message' => $e->getMessage()];
        }
    }
}
