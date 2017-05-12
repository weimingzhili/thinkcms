<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

// 登录与注销
Route::get(['login' => 'admin/Login/index']); // 登录页
Route::post(['loginCheck' => 'admin/Login/login']); // 登录
Route::get(['logout' => 'admin/Login/logout']); // 注销

// 后台首页
Route::get(['dashboard' => 'admin/Index/index']);
