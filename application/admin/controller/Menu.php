<?php

namespace app\admin\controller;

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
}
