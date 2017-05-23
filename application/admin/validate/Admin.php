<?php

namespace app\admin\validate;

use think\Validate;

/**
 * 管理员验证器
 * @author WeiZeng
 */
class Admin extends Validate
{
    // 验证规则
    protected $rule = [
        'admin_id|序号'     => 'require|number|gt:0',
        'account|账号'      => 'require|alphaDash|max:20',
        'password|密码'     => 'require',
        'email'             => 'require|email|max:255',
        'real_name|真实姓名' => 'require|chsAlpha|max:60',
        'type|类型'          => 'require|number|in:1,2',
        'status|状态'        => 'require|number|in:-1,0,1',
        'captcha|验证码'     => 'require|length:4|captcha',

    ];

    // 验证场景
    protected $scene = [
        // 登录
        'login'     => ['account', 'password', 'captcha'],
        // 添加
        'add' => ['account', 'password', 'real_name', 'email', 'type'],
        // 设置状态
        'setStatus' => ['admin_id', 'status'],
    ];
}
