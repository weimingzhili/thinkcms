<?php

namespace app\admin\validate;

use think\Validate;

/**
 * 菜单验证器
 * @author WeiZeng
 */
class Menu extends Validate
{
    // 验证规则
    protected $rule = [
        'type|菜单类型' => 'required|number|in:1,2',
    ];

    // 验证场景
    protected $scene = [
        // 筛选
        'filter' => ['type' => 'number|in:1,2'],
    ];
}
