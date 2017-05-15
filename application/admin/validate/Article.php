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
        'column_id|栏目' => 'require|number|gt:0',
        'title|文章标题' => 'require|max:150',
    ];

    // 验证场景
    protected $scene = [
        // 筛选
        'filter' => ['column_id' => 'number', 'title' => 'max:60'],
    ];
}
