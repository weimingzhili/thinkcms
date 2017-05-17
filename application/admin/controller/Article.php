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
    // 上传目录
    const UPLOAD_DIR = 'uploads';

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
        if($checkRes !== true) {
            $this->error($checkRes);
        }

        // 将请求参数转换成分页查询条件和分页查询参数
        if(!empty($param['column_id'])) {
            $where['column_id'] = $param['column_id'];
            $query['query']['column_id'] = $param['column_id'];
        }
        if(!empty($param['title'])) {
            $where['title'] = ['like', '%' . $param['title'] . '%'];
            $query['query']['title'] = $param['title'];
        }

        // 获取分页数据
        $articleModel = Loader::model('Article');
        $pageData     = $articleModel->articlePaginate($where, $query);

        // 获取栏目数据
        $menuModel  = Loader::model('Menu');
        $columnData = $menuModel->getColumnAll();

        // 注册数据
        $this->assign([
            'column_id'  => $param['column_id'],
            'title'      => $param['title'],
            'pageList'   => $pageData['pageList'],
            'pageNav'    => $pageData['pageNav'],
            'columnData' => $columnData,
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
            // 获取栏目数据
            $menuModel  = Loader::model('Menu');
            $columnData = $menuModel->getColumnAll();

            // 注册数据
            $this->assign(['columnData' => $columnData]);

            return $this->fetch();
        }

        // 请求参数
        $param                = [];
        $param['title']       = $request->param('title', '', 'trim,htmlspecialchars');         // 标题
        $param['subtitle']    = $request->param('subtitle', '', 'trim,htmlspecialchars');      // 子标题
        $param['thumb']       = $request->param('thumb', '', 'trim,htmlspecialchars');         // 缩略图
        $param['column_id']   = $request->param('column_id', '', 'intval');                    // 栏目
        $param['source']      = $request->param('source', '', 'trim,htmlspecialchars');        // 来源
        $param['description'] = $request->param('description', '', 'trim,htmlspecialchars');   // 描述
        $param['keywords']    = $request->param('keywords', '', 'trim,htmlspecialchars');      // 关键词
        $param['content']     = $request->param('content', '', 'htmlspecialchars'); // 文章内容
        $param['admin']       = $request->session('admin.account', '');                        // 管理员账号
        // 验证参数
        $checkRes = $this->validate($param, 'Article.add');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 新增
        try {
            $articleModel = Loader::model('Article');
            $result       = $articleModel->articleAdd($param);
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

    /**
     * 上传
     * @access public
     * @param Request $request 请求对象
     * @return string
     */
    public function upload(Request $request)
    {
        // 获取上传文件
        $file = $request->file('file');

        // 验证并移动到上传目录下
        $fileInfo = $file->validate(['ext' => 'jpg,png,gif', 'size' => 1048576])
                    ->move(ROOT_PATH . 'public' . DS . self::UPLOAD_DIR);
        if($fileInfo) {
            // 若移动成功，返回上传路径
            $uploadPath = DS . self::UPLOAD_DIR . DS . $fileInfo->getSaveName();

            return json(['code' => 0, 'data' => ['src' => $uploadPath]]);
        }

        // 若移动失败，返回错误信息
        return json(['code' => -1, 'msg' => $file->getError()]);
    }

    /**
     * 编辑，GET请求输出编辑页，POST请求执行保存操作
     * @access public
     * @param Request $request 请求对象
     * @return array|\think\Response
     */
    public function edit(Request $request)
    {
        // 输出编辑页
        if($request->isGet()) {
            // 请求数据
            $param = [];
            // 获取文章序号
            $param['article_id'] = $request->param('article_id', 0, 'intval');
            $checkRes            = $this->validate($param, 'Article.pk');
            if($checkRes !== true) {
                $this->error($checkRes);
            }

            // 获取文章数据
            $articleModel = Loader::model('Article');
            $articleData  = $articleModel->getArticleData($param['article_id']);

            // 获取栏目数据
            $menuModel  = Loader::model('Menu');
            $columnData = $menuModel->getColumnAll();

            // 注册数据
            $this->assign([
                'article_id'  => $param['article_id'],
                'articleData' => $articleData,
                'columnData'  => $columnData
            ]);

            return $this->fetch();
        }

        // 请求参数
        $param                = [];
        $param['title']       = $request->param('title', '', 'trim,htmlspecialchars'); // 标题
        $param['subtitle']    = $request->param('subtitle', '', 'trim,htmlspecialchars'); // 子标题
        $param['thumb']       = $request->param('thumb', '', 'trim,htmlspecialchars'); // 缩略图
        $param['column_id']   = $request->param('column_id', 0, 'intval'); // 栏目
        $param['source']      = $request->param('source', '', 'trim,htmlspecialchars'); // 来源
        $param['content']     = $request->param('content', '', 'htmlspecialchars'); // 内容
        $param['description'] = $request->param('description', '', 'trim,htmlspecialchars'); // 描述
        $param['keywords']    = $request->param('keywords', '', 'trim,htmlspecialchars'); // 关键词
        $param['admin']       = $request->session('admin.account', ''); // 管理员账号
        $param['article_id']  = $request->param('article_id', 0, 'intval'); // 主键
        // 验证参数
        $checkRes = $this->validate($param, 'Article.save');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 保存
        try {
            $articleModel = Loader::model('Article');
            $result       = $articleModel->articleUpdate($param);
            if($result === true) {
                return ['status' => 1, 'message' => '保存成功'];
            }

            return ['status' => 0, 'message' => '保存失败'];
        } catch (Exception $e) {
            return ['status' => 0, 'messgae' => $e->getMessage()];
        }
    }
}
