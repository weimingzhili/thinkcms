<?php

namespace app\index\controller;

use think\exception\HttpException;

use think\Loader;

use think\Request;

/**
 * 文章详情控制器
 * @author WeiZeng
 */
class Detail extends Base
{
    /**
     * 输出页面
     * @access public
     * @param Request $request 请求对象
     * @return \think\Response
     */
    public function index(Request $request)
    {
        // 获取文章id
        $article_id = $request->param('article_id', 0, 'intval');
        if(!preg_match('/^[1-9]\d*$/', $article_id)) {
            throw new HttpException('404');
        }

        // 获取文章数据
        $articleModel = Loader::model('admin/Article');
        $articleData  = $articleModel->getArticleData($article_id);
        if(empty($articleData)) {
            $this->error('文章内容获取失败');
        }

        // 注册数据
        $this->assign([
            'articleData' => $articleData,
        ]);

        // 输出页面
        return $this->fetch();
    }
}
