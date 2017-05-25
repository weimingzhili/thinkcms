<?php

namespace app\admin\controller;

use think\Loader;

use think\Request;

/**
 * 系统设置控制器
 * @author WeiZeng
 */
class System extends Base
{
    /**
     * 设置页
     * @access public
     * @return \think\Response
     */
    public function index()
    {
        // 获取站点设置
        $systemModel  = Loader::model('System');
        $siteSettings = $systemModel->getSiteSettings();

        // 注册数据
        $this->assign([
            'title'       => $siteSettings['title'],
            'keywords'    => $siteSettings['keywords'],
            'description' => $siteSettings['description'],
        ]);

        return $this->fetch();
    }

    /**
     * 保存
     * @access public
     * @param Request $request 请求对象
     * @return array
     */
    public function save(Request $request)
    {
        // 请求参数
        $param                = [];
        $param['title']       = $request->param('title', '', 'trim,htmlspecialchars');       // 站点标题
        $param['keywords']    = $request->param('keywords', '', 'trim,htmlspecialchars');    // 站点关键词
        $param['description'] = $request->param('description', '', 'trim,htmlspecialchars'); // 站点描述

        // 保存
        $systemModel = Loader::model('System');
        $result      = $systemModel->siteSettingsSave($param);
        if($result) {
            return ['status' => 1, 'message' => '保存成功'];
        }

        return ['status' => 0, 'message' => '保存失败'];
    }
}
