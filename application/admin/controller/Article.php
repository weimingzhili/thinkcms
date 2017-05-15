<?php

namespace app\admin\controller;

use think\Exception;

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
        $query = ['query' => []];            // 分页查询参数

        // 获取请求参数
        $param['column_id'] = $request->param('column_id', '', 'intval'); // 栏目
        $param['title']     = $request->param('title', '', 'trim,htmlspecialchars'); // 文章标题
        $checkRes = $this->validate($param, 'Article.filter');
        if($checkRes === true) {
            // 将请求参数转换成分页查询条件和分页查询参数
            if(!empty($param['column_id'])) {
                $where['column_id'] = $param['column_id'];
                $query['query']['column_id'] = $param['column_id'];
            }
            if(!empty($param['title'])) {
                $where['title'] = ['like', '%' . $param['title'] . '%'];
                $query['query']['title'] = $param['title'];
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
        foreach($sortData as $value) {
            $checkRes = $this->validate($value, 'article.sort');
            if($checkRes !== true) {
                return ['status' => 0, 'message' => $checkRes];
            }
        }

        // 排序
        try {
            $articleModel = Loader::model('Article');
            $result       = $articleModel->articleSort($sortData);
            if($result === true) {
                return ['status' => 1, 'message' => '排序成功'];
            }

            return ['status' => 0, 'message' => '排序失败'];
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
        $param['article_id'] = $request->param('article_id', 0, 'intval'); // 主键
        $param['status']     = $request->param('status', 0, 'intval'); // 状态
        // 验证参数
        $checkRes = $this->validate($param, 'article.setStatus');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 更新状态
        try {
            $articleModel = Loader::model('Article');
            $result       = $articleModel->updateStatus($param);
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
