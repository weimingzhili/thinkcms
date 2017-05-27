<?php
namespace app\index\controller;

use think\Loader;

/**
 * 前台首页
 * @author WeiZeng
 */
class Index extends Base
{
    /**
     * 输出页面
     * @access public
     * @return \think\Response
     */
    public function index()
    {
        // 获取轮播图数据
        $positionContentModel = Loader::model('admin/PositionContent');
        $carouselData         = $positionContentModel->getCarousel();

        // 获取小图推荐数据
        $smallPicData = $positionContentModel->getSmallPic();

        // 获取文章列表
        $articleModel = Loader::model('admin/Article');
        $articleList  = $articleModel->getArticleList();

        // 注册数据
        $this->assign([
            'carouselData' => $carouselData,
            'smallPicData' => $smallPicData,
            'articleList'  => $articleList,
        ]);

        return $this->fetch();
    }
}
