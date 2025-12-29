<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP8!';
});

Route::get('hello/:name', 'index/hello');

// 后台管理路由 - 支持 /admin/controller/action 格式
Route::group('admin', function () {
    Route::any('dashboard/:action?', 'admin.Dashboard/:action');
    Route::any('banner/:action?', 'admin.Banner/:action');
    Route::any('company/:action', 'admin.Company/:action');
    Route::any('product/:action?', 'admin.Product/:action');
    Route::any('solution/:action?', 'admin.Solution/:action');
    Route::any('news/:action?', 'admin.News/:action');
    Route::any('message/:action?', 'admin.Message/:action');
    Route::any('partner/:action?', 'admin.Partner/:action');
    Route::any('setting/:action', 'admin.Setting/:action');
    Route::any('upload/:action', 'admin.Upload/:action');
});
