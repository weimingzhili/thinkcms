<?php

namespace app\admin\controller;

use think\Exception;

use think\Loader;

use think\Request;

/**
 * 推荐位控制器
 * @author WeiZeng
 */
class Position extends Base
{
    /**
     * 列表页
     * @access public
     * @return \think\Response
     */
    public function index()
    {
        // 获取分页数据
        $positionModel = Loader::model('Position');
        $pageData      = $positionModel->positionPaginate();

        // 注册数据
        $this->assign([
            'pageList' => $pageData['pageList'],
            'pageNav'  => $pageData['pageNav'],
        ]);

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
        $param                  = [];
        $param['position_name'] = $request->param('position_name', '', 'trim,htmlspecialchars'); // 推荐位名称
        $param['description']   = $request->param('description', '', 'trim,htmlspecialchars');   // 推荐位描述
        $param['status']        = $request->param('status', 0, 'intval');                        // 状态
        // 验证参数
        $checkRes = $this->validate($param, 'Position.add');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 添加
        try {
            $positionModel = Loader::model('Position');
            $result        = $positionModel->positionAdd($param);
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
            // 请求参数
            $param = [];
            // 获取主键
            $param['position_id'] = $request->param('position_id', 0, 'intval');
            $checkRes = $this->validate($param, 'Position.pk');
            if($checkRes !== true) {
                $this->error($checkRes);
            }

            // 获取推荐位数据
            $positionModel = Loader::model('Position');
            $position      = $positionModel->getPosition($param['position_id']);

            // 注册数据
            $this->assign([
                'position_id' => $param['position_id'],
                'position'    => $position,
            ]);

            return $this->fetch();
        }

        // 请求参数
        $param                  = [];
        $param['position_id']   = $request->param('position_id', 0, 'intval');                   // 主键
        $param['position_name'] = $request->param('position_name', '', 'trim,htmlspecialchars'); // 推荐位名称
        $param['description']   = $request->param('description', '', 'trim,htmlspecialchars');   // 描述
        $param['status']        = $request->param('status', 0, 'intval');                        // 状态
        // 验证参数
        $checkRes = $this->validate($param, 'Position.edit');
        if($checkRes !== true ) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 保存
        try {
            $positionModel = Loader::model('Position');
            $result        = $positionModel->positionUpdate($param);
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
     * 设置状态
     * @access public
     * @param Request $request 请求对象
     * @return array
     */
    public function setStatus(Request $request)
    {
        // 请求参数
        $param['position_id'] = $request->param('position_id', 0, 'intval'); // 主键
        $param['status']      = $request->param('status', 0, 'intval');      // 状态
        // 验证参数
        $checkRes = $this->validate($param, 'Position.setStatus');
        if($checkRes !== true) {
            return ['status' => 0, 'message' => $checkRes];
        }

        // 更新状态
        try {
            $positionModel = Loader::model('Position');
            $result        = $positionModel->updateStatus($param);
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
