<?php

/** .-------------------------------------------------------------------
 * |  Github: https://github.com/Tinywan
 * |  Blog: http://www.cnblogs.com/Tinywan
 * |-------------------------------------------------------------------
 * |  Author: Tinywan(SHaoBo Wan)
 * |  Date: 2017/1/20
 * |  Time: 16:25
 * |  Mail: Overcome.wan@Gmail.com
 * |  Created by PhpStorm.
 * '-------------------------------------------------------------------*/

namespace app\backend\controller;

use app\common\controller\BaseBackend;

class LinuxShell extends BaseBackend
{
    const SERVER_USER_NAME = "www";
    const SERVER_AUTH = "12312";
    const SERVER_IP = "www.tinywan.com";
    const WS_SERVER_PORT = "62800";

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * Linux 系统管理
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 内存管理
     */
    public function internalStorage()
    {
        $this->assign('moniServerIp',self::SERVER_IP);
        $this->assign('wsServerIP',self::SERVER_IP);
        $this->assign('wsServerPort',self::WS_SERVER_PORT);
        $this->assign('memoryTitle',self::SERVER_IP."系统实时空闲内存监控");
        $this->assign('dishTitle',"视频存放空间占比率");
        return $this->fetch();
    }

    /**
     * 主题设置
     * @return mixed
     */
    public function internalStorageTheme()
    {
        $this->assign('moniServerIp',self::SERVER_IP);
        $this->assign('wsServerIP',self::SERVER_IP);
        $this->assign('wsServerPort',self::WS_SERVER_PORT);
        $this->assign('memoryTitle',self::SERVER_IP."Theme系统实时空闲内存监控");
        $this->assign('dishTitle',"Theme视频存放空间占比率");
        return $this->fetch();
    }

    /**
     * WEB内存管理
     */
    public function webInternalStorage()
    {
        //  监控的服务器IP
        $moniServerIp = "127.0.0.1";
        $moniServerSshUsername = "www";
        $moniServerSshPassword = "123456";
        return $this->fetch("webInternalStorage", [
            "moniServerIp" => $moniServerIp,
            "moniServerSshUsername" => $moniServerSshUsername,
            "moniServerSshPassword" => $moniServerSshPassword,
        ]);
    }

    /**
     * 通过用户名与密码连接函数
     */
    public function connectShellByUserPassword()
    {
        $ip = "127.0.0.1";
        $username = "tinywan";
        $password = "111";
        // 连接服务器
        $connection = ssh2_connect($ip, 22);
        if (ssh2_auth_password($connection, $username, $password)) {
            echo "Authentication Successful! ";
        } else {
            die("Authentication Failed...");
        }
        //执行远程服务器上的命令并取返回值
        $stream = ssh2_exec($connection, 'cat /proc/meminfo | grep "MemFree:"');
        stream_set_blocking($stream, true);
        echo stream_get_contents($stream);
    }

    /**
     * 通过用户名与密码连接函数
     */
    public function connectShellTest()
    {
        $ip = "127.0.0.1";
        $username = "www";
        $password = "123456";
        // 连接服务器
        $connection = ssh2_connect($ip, 22);
        if (!ssh2_auth_password($connection, $username, $password)) return 0;
        //执行远程服务器上的命令并取返回值
        $stream = ssh2_exec($connection, " cat /proc/meminfo | grep 'MemFree:' | awk '{print $2}'");
        stream_set_blocking($stream, true);
        return stream_get_contents($stream);
    }

    public function test()
    {
        echo $this->connectShellTest();
    }

}