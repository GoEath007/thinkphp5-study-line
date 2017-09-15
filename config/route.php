<?php
/**
 * Created by PhpStorm.
 * User: tinywan
 * Date: 2017/6/24
 * Time: 10:47
 */
return [
    "bnews/:id" => "backend/index/info", // http://127.0.0.1/news/234
    "d/:id" => "frontend/index/detail", // 文章详细页面：http://test.thinkphp5-line.com/d/23.html
    "t/:id" => "frontend/index/searchByTagId", // 标签页面：http://test.thinkphp5-line.com/t/3.html
    "c/:id" => "frontend/index/searchByCategoryId", // 根据分类Id查询文章：http://test.thinkphp5-line.com/c/3.html
    // 后台路由配置
    "tinywan" => "backend/login/login",
    // 路由别名
    '__alias__' => [
        'user' => 'index/User',
        'system' => 'backend/system',
        'category' => 'backend/category',
        'tag' => 'backend/tag',
        'article' => 'backend/article',
    ],
];