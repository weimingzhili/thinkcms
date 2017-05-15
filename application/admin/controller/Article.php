<?php

namespace app\admin\controller;

use think\Loader;

use think\Request;

/**
 * 文章控制器
 * @author WeiZeng
 */
class Article extends Base
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

        // 获取请求参数
        $param['column_id'] = $request->param('column_id', '', 'intval'); // 栏目
        $param['title']     = $request->param('title', '', 'trim,htmlspecialchars'); // 文章标题
        $checkRes = $this->validate($param, 'Article.filter');
        if($checkRes === true) {
            // 将请求参数转换成分页查询条件和分页查询参数
            if(!empty($param['column_id'])) {
                $where['column_id'] = $param['column_id'];
                $query['column_id'] = $param['column_id'];
            }
            if(!empty($param['title'])) {
                $where['title'] = ['like', '%' . $param['title'] . '%'];
                $query['title'] = $param['title'];
            }
        }

        // 获取分页数据
        $articleModel = Loader::model('Article');
        $pageData = $articleModel->articlePaginate($where, $query);

        // 获取栏目数据
        $menuModel = Loader::model('Menu');
        $columns = $menuModel->getColumnAll();

        // 注册数据
        $this->assign([
            'column_id' => $param['column_id'],
            'title'     => $param['title'],
            'pageList'  => $pageData['pageList'],
            'pageNav'   => $pageData['pageNav'],
            'columns'   => $columns,
        ]);

        // 输出页面
        return $this->fetch();
    }
}
