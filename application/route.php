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
Route::get(['login' => 'admin/Login/index']);       // 登录页
Route::post(['loginCheck' => 'admin/Login/login']); // 登录
Route::get(['logout' => 'admin/Login/logout']);     // 注销

// 后台首页
Route::get(['dashboard' => 'admin/Index/index']);

// 菜单管理
Route::get(['menu' => 'admin/Menu/index']);                              // 列表
Route::rule('menu/add', 'admin/Menu/add', 'GET|POST');   // 添加
Route::rule('menu/edit', 'admin/Menu/edit', 'GET|POST'); // 编辑
Route::post(['menu/sort' => 'admin/Menu/sort']);                         // 排序
Route::post(['menu/setStatus' => 'admin/Menu/setStatus']);               // 设置状态

// 文章管理
Route::get(['article' => 'admin/Article/index']);                              // 列表
Route::rule('article/add', 'admin/Article/add', 'GET|POST');   // 添加
Route::post(['article/sort' => 'admin/Article/sort']);                         // 排序
Route::post(['article/setStatus' => 'admin/Article/setStatus']);               // 设置状态
Route::post(['upload' => 'admin/Article/upload']);                             // 上传
Route::rule('article/edit', 'admin/Article/edit', 'GET|POST'); // 编辑
Route::post(['push' => 'admin/Article/push']);                                 // 推送

// 推荐位管理
Route::get(['position' => 'admin/Position/index']);                                 // 列表
Route::post(['position/setStatus' => 'admin/Position/setStatus']);                  // 设置状态
Route::rule('position/add', 'admin/Position/add', 'GET|POST');     // 添加
Route::rule('position/edit', 'admin/Position/edit', 'GET|POST');   // 编辑

// 推荐位内容管理
Route::get(['positionContent' => 'admin/PositionContent/index']);                // 列表
Route::post(['positionContent' => 'admin/PositionContent/sort']);                // 排序
Route::post(['positionContent/setStatus' => 'admin/PositionContent/setStatus']); // 设置状态
Route::rule('positionContent/add', 'admin/PositionContent/add', 'GET|POST');     // 添加
Route::rule('positionContent/edit', 'admin/PositionContent/edit', 'GET|POST');   // 编辑
