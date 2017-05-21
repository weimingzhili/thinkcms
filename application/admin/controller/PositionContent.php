<?php

namespace app\admin\controller;

use think\Exception;

use think\Loader;

use think\Request;

/**
 * 推荐位内容控制器
 * @author WeiZeng
 */
class PositionContent extends Base
{
    /**
     * 列表页
     * @access public
     * @param Request $request 请求对象
     * @return \think\Response
     */
    public function index(Request $request)
    {
        // 初始数据
        $param = [];                         // 请求参数
        $where = ['status' => ['<>', '-1']]; // 分页查询条件
        $query = ['query' => []];            // 分页查询参数

        // 获取请求参数
        $param['position_id'] = $request->param('position_id', 0, 'intval');           // 推荐位
        $param['title']       = $request->param('title', '', 'trim,htmlspecialchars'); // 文章标题
        // 验证参数
        $checkRes = $this->validate($param, 'PositionContent.filter');
        if($checkRes !== true) {
            $this->error($checkRes);
        }

        // 将请求参数转换成分页查询条件和分页查询参数
        if(!empty($param['position_id'])) {
            $where['position_id'] = $param['position_id'];
            $query['query']['position_id'] = $param['position_id'];
        }
        if(!empty($param['title'])) {
            $where['title'] = ['like', '%' . $param['title'] . '%'];
            $query['query']['title'] = $param['title'];
        }

        // 获取分页数据
        $positionContentModel = Loader::model('PositionContent');
        $pageData             = $positionContentModel->positionContentPaginate($where, $query);

        // 获取推荐位数据
        $positionModel = Loader::model('Position');
        $positionData  = $positionModel->getPositionAll();

        // 注册数据
        $this->assign([
            'position_id'         => $param['position_id'],
            'title'               => $param['title'],
            'pageList'            => $pageData['pageList'],
            'pageNav'             => $pageData['pageNav'],
            'positionData'        => $positionData
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
            // 获取推荐位数据
            $positionModel = Loader::model('Position');
            $positionData  = $positionModel->getPositionAll();

            // 注册数据
            $this->assign('positionData', $positionData);

            return $this->fetch();
        }

        // 请求参数
        $param                = [];
        $param['title']       = $request->param('title', '', 'trim,htmlspecialchars');   // 文章标题
        $param['position_id'] = $request->param('position_id', 0, 'intval');             // 推荐位
        $param['thumb']       = $request->param('thumb', '', 'trim,htmlspecialchars');   // 缩略图
        $param['address']     = $request->param('address', '', 'trim,htmlspecialchars'); // 文章地址
        $param['article_id']  = $request->param('article_id', 0, 'intval');              // 文章序号
        // 验证参数
        $checkRes = $this->validate($param, 'PositionContent.add');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 若thumb不存在，尝试从article表中获取
        if(empty($param['thumb'])) {
            $articleModel   = Loader::model('Article');
            $param['thumb'] = $articleModel->getThumb($param['article_id']);
        }

        // 添加
        try {
            $positionContentModel = Loader::model('PositionContent');
            $result               = $positionContentModel->positionContentAdd($param);
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
        foreach ($sortData as $value) {
            $checkRes = $this->validate($value, 'PositionContent.sort');
            if($checkRes !== true) {
                return ['status' => 0, 'message' => $checkRes];
            }
        }

        // 排序
        try {
            $positionContentModel = Loader::model('PositionContent');
            $result               = $positionContentModel->positionContentSort($sortData);
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
        $param                        = [];
        $param['position_content_id'] = $request->param('position_content_id', 0, 'intval'); // 主键
        $param['status']              = $request->param('status', 0, 'intval');              // 状态
        // 验证参数
        $checkRes = $this->validate($param, 'PositionContent.setStatus');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 更新状态
        try {
            $positionContentModel = Loader::model('PositionContent');
            $result = $positionContentModel->updateStatus($param);
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
