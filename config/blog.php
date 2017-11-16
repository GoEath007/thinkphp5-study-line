<?php
/** .-------------------------------------------------------------------
 * |  Github: https://github.com/Tinywan
 * |  Blog: http://www.cnblogs.com/Tinywan
 * |-------------------------------------------------------------------
 * |  Author: Tinywan(SHaoBo Wan)
 * |  DateTime: 2017/9/21 14:45
 * |  Mail: Overcome.wan@Gmail.com
 * |  Created by PhpStorm.
 * '-------------------------------------------------------------------*/
use think\Route;

// 定义路由规则 并设置60秒的缓存
Route::get('/','blog/Index/index',['cache'=>60]);
//Route::rule('/','blog/Index/index');
// 文章详情路由
Route::rule('bd/:id','blog/Index/detail');