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
        'admin_id|序号'  => 'require|number|gt:0',
        'account|账号'   => 'require|alphaDash|max:20',
        'password|密码'  => 'require',
        'captcha|验证码' => 'require|length:4|captcha',
        'status|状态'    => 'require|number|in:-1,0,1'
    ];

    // 验证场景
    protected $scene = [
        // 登录
        'login'     => ['account', 'password', 'captcha'],
        // 设置状态
        'setStatus' => ['admin_id', 'status'],
    ];
}
