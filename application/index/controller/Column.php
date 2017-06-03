<?php

namespace app\index\controller;

use think\exception\HttpException;

use think\Loader;

use think\Request;

/**
 * 栏目页控制器
 * @author WeiZeng
 */
class Column extends Base
{
    /**
     * 输出页面
     * @access public
     * @param Request $request 请求对象
     * @return \think\Response
     */
    public function index(Request $request)
    {
        // 获取栏目id
        $column_id = $request->param('column_id', 0, 'intval');
        if(!preg_match('/^[1-9]\d*$/', $column_id)) {
            throw new HttpException('404');
        }

        // 获取栏目文章列表
        $articleModel      = Loader::model('admin/Article');
        $columnArticleList = $articleModel->getColumnArticleList($column_id);

        // 注册数据
        $this->assign(['columnArticleList' => $columnArticleList]);

        // 输出页面
        return $this->fetch();
    }
}
