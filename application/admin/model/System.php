<?php

namespace app\admin\model;

use think\Cache;

/**
 * 系统设置模型
 * @author WeiZeng
 */
class System
{
    /**
     * 获取站点设置
     * @access public
     * @return array
     */
    public function getSiteSettings()
    {
        // 读取站点设置
        $siteSettings = Cache::get('siteSettings', []);

        return $siteSettings;
    }

    /**
     * 保存站点设置
     * @access public
     * @param array $data 站点设置
     * @return bool
     */
    public function siteSettingsSave($data)
    {
        // 写入缓存
        $result = Cache::set('siteSettings', $data);

        return $result;
    }
}
