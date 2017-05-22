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
        'menu_id|序号'        => 'require|number|gt:0',
        'menu_name|菜单名称'  => 'require|max:60',
        'module|模块'         => 'require|alpha|max:50',
        'controller|控制器'   => 'require|alpha|max:50',
        'action|方法'         => 'require|alpha|max:50',
        'list_order|排序序号' => 'require|number|egt:0',
        'type|菜单类型'       => 'require|number|in:1,2',
        'status|状态'         => 'require|number|in:-1,0,1',
    ];

    // 验证场景
    protected $scene = [
        // 主键
        'pk'        => 'menu_id',
        // 筛选
        'filter'    => ['type' => 'number|in:1,2'],
        // 添加
        'add'       => ['menu_name', 'type', 'module', 'controller', 'action', 'status'],
        // 编辑
        'save'      => ['menu_id', 'menu_name', 'type', 'module', 'controller', 'action', 'status' => 'require|number|in:0,1'],
        // 排序
        'sort'      => ['menu_id', 'list_order'],
        // 设置状态
        'setStatus' => ['menu_id', 'status'],
    ];
}
