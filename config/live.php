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

// 后台登陆,这里不可以定义为get,表单提交是post格式
//Route::get('/','live/Index/index');
//Route::rule('/','blog/Index/index');
// 文章详情路由
Route::rule('liv/:id','live/Index/detail');
Route::rule('vod/:id','live/Index/vodDetail');
Route::rule('eventlist','live/Index/eventList');
Route::rule('livelist','live/Index/liveList');
