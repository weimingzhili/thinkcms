<?php

namespace app\admin\model;

use think\Loader;

use think\Model;

/**
 * 文章模型
 * @author WeiZeng
 */
class Article extends Model
{
    /**
     * 栏目获取器
     * @access public
     * @param int $column_id 栏目id
     * @return string
     */
    public function getColumnIdAttr($column_id)
    {
        // 栏目名
        $column_name = '';

        // 获取栏目
        $menuModel = Loader::model('Menu');
        $columns = $menuModel->getColumnAll();

        // 获取栏目名
        foreach ($columns as $value) {
            if($value->menu_id == $column_id) {
                $column_name = $value->menu_name;
            }
        }

        return !empty($column_name) ? $column_name : '未知';
    }

    /**
     * 缩略图获取器
     * @access public
     * @param string $thumb 缩略图
     * @return string
     */
    public function getThumbAttr($thumb)
    {
        return !empty($thumb) ? '有' : '无';
    }

    /**
     * 来源获取器
     * @access public
     * @param string $source 来源
     * @return string
     */
    public function getSourceAttr($source)
    {
        return !empty($source) ? $source : '本站';
    }

    /**
     * 创建时间获取器
     * @access public
     * @param string $create_time 创建时间
     * @return string
     */
    public function getCreateTimeAttr($create_time)
    {
        return !empty($create_time) ? date('Y-m-d H:i:s', $create_time) : '未知';
    }

    /**
     * 状态获取器
     * @access public
     * @param string $status 状态
     * @return string
     */
    public function getStatusAttr($status)
    {
        return $status == 1 ? '启用' : '禁用';
    }

    /**
     * 分页
     * @access public
     * @param array $where 查询条件
     * @param array $query 查询参数
     * @return array
     */
    public function articlePaginate($where, $query)
    {
        // 获取分页记录
        $pageList = self::where($where)
                    ->order(['list_order' => 'desc', 'article_id' => 'desc'])
                    ->paginate(5, false, ['query' => $query]);
        // 获取分页导航
        $pageNav = $pageList->render();

        return ['pageList' => $pageList, 'pageNav' => $pageNav];
    }
}
