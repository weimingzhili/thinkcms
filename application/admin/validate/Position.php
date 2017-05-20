<?php

namespace app\admin\validate;

use think\Validate;

/**
 * 推荐位验证器
 * @author WeiZeng
 */
class Position extends Validate
{
    // 验证规则
    protected $rule = [
        'position_id|序号'        => 'require|number|gt:0',
        'position_name|推荐位名称' => 'require|chsAlphaNum|max:60',
        'description|描述'        => 'max:150',
        'status|状态'             => 'require|number|in:-1,0,1'
    ];

    // 验证场景
    protected $scene = [
        // 主键
        'pk'        => 'position_id',
        // 添加
        'add'       => ['position_name', 'description', 'status' => 'require|number|in:0,1'],
        // 设置状态
        'setStatus' => ['position_id', 'status'],
        // 编辑
        'edit'      => ['position_id', 'position_name', 'description', 'status' => 'require|number|in:0,1'],
    ];
}
