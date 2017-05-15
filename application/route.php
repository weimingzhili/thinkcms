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

// 菜单管理
Route::get(['menu' => 'admin/Menu/index']); // 列表
Route::rule('menu/add', 'admin/Menu/add', 'GET|POST'); // 添加
Route::rule('menu/edit', 'admin/Menu/edit', 'GET|POST'); // 编辑
Route::post(['menu/sort' => 'admin/Menu/sort']); // 排序
Route::post(['menu/setStatus' => 'admin/Menu/setStatus']); // 设置状态

// 文章管理
Route::get(['article' => 'admin/Article/index']); //列表
Route::post(['article/sort' => 'admin/Article/sort']); // 排序
Route::post(['article/setStatus' => 'admin/Article/setStatus']); // 设置状态
