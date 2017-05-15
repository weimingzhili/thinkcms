<?php

namespace app\admin\controller;

use think\Loader;

use think\Request;

/**
 * 首页
 * @author WeiZeng
 */
class Index extends Base
{
    /**
     * 输出页面
     * @access public
     * @param Request $request 请求对象
     * @return \think\Response
     */
    public function index(Request $request)
    {
        // 获取管理员最后登录的时间和ip
        $last_login_time = $request->session('admin.last_login_time');
        $last_login_ip   = $request->session('admin.last_login_ip');

        // 获取文章总数
        $articleModel = Loader::model('Article');
        $articleTotal = $articleModel->getArticleTotal();
        // 获取菜单总数
        $menuModel = Loader::model('Menu');
        $menuTotal = $menuModel->getMenuTotal();
        // 获取管理员总数
        $adminModel      = Loader::model('Admin');
        $adminTotal      = $adminModel->getAdminTotal();

        // 获取站点域名
        $domain          = $request->server('HTTP_HOST', '未知');
        // 获取操作系统
        $os              = php_uname();
        // 获取服务器软件
        $serverSoftware  = $request->server('SERVER_SOFTWARE', '未知');

        // 注册数据
        $this->assign([
            'last_login_time' => $last_login_time,
            'last_login_ip'   => $last_login_ip,
            'articleTotal'    => $articleTotal,
            'menuTotal'       => $menuTotal,
            'adminTotal'      => $adminTotal,
            'domain'          => $domain,
            'OS'              => $os,
            'serverSoftware'  => $serverSoftware,
        ]);

        // 输出页面
        return $this->fetch();
    }
}
