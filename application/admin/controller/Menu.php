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
        $query = ['query' => []];            // 分页查询参数

        // 获取请求参数
        $param['type'] = $request->param('type', '', 'intval');
        $checkRes = $this->validate($param, 'Menu.filter');
        if($checkRes === true) {
            // 将请求参数转换成分页查询条件和分页查询参数
            if(!empty($param['type'])) {
                $where['type'] = $param['type'];
                $query['query']['type'] = $param['type'];
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
        $param               = [];
        $param['menu_name']  = $request->param('menu_name', '', 'trim,htmlspecialchars');  // 菜单名称
        $param['type']       = $request->param('type', 1, 'intval');                       // 类型
        $param['module']     = $request->param('module', '', 'trim,htmlspecialchars');     // 模块
        $param['controller'] = $request->param('controller', '', 'trim,htmlspecialchars'); // 控制器
        $param['action']     = $request->param('action', '', 'trim,htmlspecialchars');     // 方法
        $param['status']     = $request->param('status', 1, 'intval');                     // 状态
        // 验证参数
        $checkRes = $this->validate($param, 'Menu.add');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 添加
        try {
            $menuModel = Loader::model('Menu');
            $result    = $menuModel->menuAdd($param);
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
     * 编辑
     * @access public
     * @param Request $request 请求对象
     * @return array|\think\Response
     */
    public function edit(Request $request)
    {
        // 输出编辑页
        if($request->isGet()) {
            // 获取主键
            $menu_id  = $request->param('menu_id', 0, 'intval');
            // 获取菜单
            $menuModel = Loader::model('Menu');
            $menu      = $menuModel->getMenu($menu_id);

            // 注册数据
            $this->assign([
                'menu_id' => $menu_id,
                'menu'    => $menu,
            ]);

            return $this->fetch();
        }

        // 请求参数
        $param               = [];
        $param['menu_id']    = $request->param('menu_id', 0, 'intval');                    // 主键
        $param['menu_name']  = $request->param('menu_name', '', 'trim,htmlspecialchars');  // 菜单名称
        $param['module']     = $request->param('module', '', 'trim,htmlspecialchars');     // 模块
        $param['type']       = $request->param('type', 0, 'trim,htmlspecialchars');        // 类型
        $param['controller'] = $request->param('controller', '', 'trim,htmlspecialchars'); // 控制器
        $param['action']     = $request->param('action', '', 'trim,htmlspecialchars');     // 方法
        $param['status']     = $request->param('status', 0, 'trim,htmlspecialchars');      // 状态
        // 验证参数
        $checkRes = $this->validate($param, 'Menu.edit');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 保存
        try {
            $menuModel = Loader::model('Menu');
            $result    = $menuModel->menuUpdate($param);
            if($result === true) {
                return ['status' => 1, 'message' => '保存成功'];
            }

            return ['status' => 0, 'message' => '保存失败'];
        } catch (Exception $e) {
            // 处理异常
            return ['status' => 0, 'message' => $e->getMessage()];
        }
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
                return ['status' => 1, 'message' => '排序成功'];
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
        $param['menu_id'] = $request->param('menu_id', 0, 'intval'); // 主键
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
