<?php

namespace app\admin\validate;

use think\Validate;

/**
 * 推荐位内容验证器
 * @author WeiZeng
 */
class PositionContent extends Validate
{
    // 验证规则
    protected $rule = [
        'position_content_id|推荐位内容序号' => 'require|number|gt:0',
        'position_id|推荐位'                => 'require|number|gt:0',
        'title|文章标题'                    => 'require|max:150',
        'list_order|排序序号'               => 'require|number|egt:0',
        'status|状态'                       => 'require|number|in:-1,0,1',
    ];

    // 验证场景
    protected $scene = [
        // 筛选
        'filter' => ['position_id' => 'number', 'title' => 'max:150'],
        // 排序
        'sort' => ['position_content_id', 'list_order'],
        // 设置状态
        'setStatus' => ['position_content_id', 'status'],
    ];
}
