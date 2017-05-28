<?php

namespace app\index\controller;

use think\Controller;

use think\Loader;

/**
 * 基础控制器
 * @author WeiZeng
 */
class Base extends Controller
{
    /**
     * 初始化
     * @access public
     */
    public function _initialize()
    {
        // 继承父类的初始化方法
        parent::_initialize();

        // 获取站点信息
        $systemModel  = Loader::model('admin/System');
        $siteSettings = $systemModel->getSiteSettings();

        // 获取栏目导航
        $menuModel  = Loader::model('admin/Menu');
        $columnData = $menuModel->getColumnAll();

        // 获取文章排行数据
        $articleModel = Loader::model('admin/Article');
        $topArticles = $articleModel->getTopArticles();

        // 获取广告位数据
        $positionContentModel = Loader::model('admin/PositionContent');
        $adData = $positionContentModel->getAd();

        // 获取栏目id
        $column_id = $this->request->param('column_id', 0, 'intval');

        // 注册数据
        $this->assign([
            'siteSettings' => $siteSettings,
            'columnData'   => $columnData,
            'topArticles'  => $topArticles,
            'adData'       => $adData,
            'column_id'    => $column_id,
        ]);
    }
}
