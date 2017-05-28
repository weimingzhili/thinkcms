<?php

namespace app\admin\model;

use think\Model;

/**
 * 文章内容模型
 * @author WeiZeng
 */
class ArticleContent extends Model
{
    // 数据加成：新增
    protected $insert = ['create_time'];

    // 数据完成：更新
    protected $update = ['update_time'];

    /**
     * 文章内容获取器
     * @access public
     * @param string $content 文章内容
     * @return string
     */
    public function getContentAttr($content)
    {
        return htmlspecialchars_decode($content);
    }

    /**
     * 创建时间修改器
     * @access public
     * @return int
     */
    public function setCreateTimeAttr()
    {
        return time();
    }

    /**
     * 更新时间修改器
     * @access public
     * @return int
     */
    public function setUpdateTimeAttr()
    {
        return time();
    }
}
