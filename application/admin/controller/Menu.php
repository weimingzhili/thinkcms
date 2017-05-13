<?php

namespace app\admin\controller;

use think\Exception;

use think\Loader;

use think\Request;

/**
 * 菜单控制器
 * @author WeiZeng
 */
class Menu extends Base
{
    /**
     * 列表页
     * @access public
     * @param Request $request
     * @return \think\Response
     */
    public function index(Request $request)
    {
        // 初始数据
        $param = [];                         // 请求参数
        $where = ['status' => ['<>', '-1']]; // 分页查询条件
        $query = [];                         // 分页查询参数

        // 获取菜单类型
        $param['type'] = $request->param('type', '', 'intval');
        // 若菜单类型有值
        if(!empty($param['type'])) {
            // 验证菜单类型
            $checkRes = $this->validate($param, 'Menu.filter');
            if($checkRes === true) {
                $where['type'] = $param['type'];
                $query['type'] = $param['type'];
            }
        }

        // 获取分页数据
        $menuModel = Loader::model('Menu');
        $pageData = $menuModel->menuPaginate($where, $query);

        // 注册数据
        $this->assign([
            'type' => $param['type'],
            'pageList' => $pageData['pageList'],
            'pageNav'  => $pageData['pageNav'],
        ]);

        // 输出页面
        return $this->fetch();
    }

    /**
     * 排序
     * @access public
     * @param Request $request 请求对象
     * @return array
     */
    public function sort(Request $request)
    {
        // 获取排序数据
        $param    = $request->param();
        $sortData = $param['sortData'];
        // 验证数据
        foreach ($sortData as $value) {
            $checkRes = $this->validate($value, 'Menu.sort');
            if($checkRes !== true) {
                return ['status' => 0, 'message' => $checkRes];
            }
        }

        // 排序
        try {
            $menuModel = Loader::model('Menu');
            $result    = $menuModel->menuSort($sortData);
            if($result === true) {
                return ['status' => 1, 'message' => '操作成功'];
            }

            return ['status' => 0, 'message' => '操作失败'];
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
        $param['menu_id'] = $request->param('menu_id', 0, 'intval'); // 菜单主键
        $param['status']  = $request->param('status', 0, 'intval');  // 状态
        // 验证参数
        $checkRes = $this->validate($param, 'Menu.setStatus');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 更新状态
        try {
            $menuModel = Loader::model('Menu');
            $result    = $menuModel->updateStatus($param);
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
