<?php

/**
 * Created by PhpStorm.
 * User: tinywan
 * Date: 2017/7/8
 * Time: 7:16
 */
namespace app\backend\validate;
use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'email'  =>  'require|email',
        'password' =>  'require',
        'code' =>  'require|captcha',
    ];

    // 自定义验证信息
    protected $message  =   [
        'email.require' => '邮箱不能为空',
        'email.email' => '邮箱格式不正确',
        'password.require'   => '密码不能为空',
        'code.require'        => '验证码不能为空',
        'code.captcha'        => '验证码不正确',
    ];

    // 验证场景
    protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];

}