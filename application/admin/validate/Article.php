<?php

namespace app\admin\validate;

use think\Validate;

/**
 * 文章管理器
 * @author WeiZeng
 */
class Article extends Validate
{
    // 验证规则
    protected $rule = [
        'article_id|序号'     => 'require|number|gt:0',
        'column_id|栏目'      => 'require|number|gt:0',
        'title|文章标题'      => 'require|max:150',
        'list_order|排序序号' => 'require|number|egt:0',
        'status|状态'         => 'require|number|in:-1,0,1'
    ];

    // 验证场景
    protected $scene = [
        // 筛选
        'filter'    => ['column_id' => 'number', 'title' => 'max:60'],
        // 排序
        'sort'      => ['article_id', 'list_order'],
        // 设置状态
        'setStatus' => ['article_id', 'status'],
    ];
}