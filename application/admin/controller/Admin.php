<?php

namespace app\admin\controller;

use think\Exception;

use think\Loader;

use think\Request;

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
