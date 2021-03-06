<?php
/** .-------------------------------------------------------------------
 * |  Github: https://github.com/Tinywan
 * |  Blog: http://www.cnblogs.com/Tinywan
 * |-------------------------------------------------------------------
 * |  Author: Tinywan(ShaoBo Wan)
 * |  DateTime: 2017/8/26 14:42
 * |  Mail: Overcome.wan@Gmail.com
 * '-------------------------------------------------------------------*/

namespace app\frontend\controller;

use app\common\controller\BaseFrontend;
use redis\MsgRedis;
use think\Db;
use think\Log;

class WebsocketClient extends BaseFrontend
{
    const SERVER_USER_NAME = "www";
    const SERVER_AUTH = "12312";
    const SERVER_IP = "www.tinywan.com";
    const WS_SERVER_PORT = "8081";
    const SHELL_SCRIPT_PATH = "/home/www/web/go-study-line/shell/auto-install/";

    /**
     * 获取基本信息
     */
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    /**
     *  http://test.thinkphp5-line.com/frontend/websocket_client/index
     * @return string
     */
    public function test()
    {
        halt(config());
    }

    public function index()
    {
        $this->view->engine->layout(false);
        return $this->fetch('index');
    }

    /**
     * http://test.thinkphp5-line.com/frontend/websocket_client/chatroom
     * 在线聊天室
     * @return mixed
     */
    public function chatRoom()
    {
        $this->assign('wsServerIP', self::SERVER_IP);
        $this->assign('wsServerPort', self::WS_SERVER_PORT);
        return $this->fetch();
    }

    public function chatRoomRedis()
    {
        $liveId = "L000112";
        $redis = MsgRedis::increaseTotalViewNum($liveId);
        var_dump($redis);
    }

    public function runShell()
    {
        $servers = '192.168.1.1 192.168.1.2 192.168.1.3 192.168.1.4';
        $pwds = 'www123 www456 www678';
        $shell_script = self::SHELL_SCRIPT_PATH . "init.sh";
        $cmdStr = "{$shell_script} {$servers} {$pwds}";
        Log::error('[' . self::formatDate(time()) . ']:' . "Shell 脚本参数 ： " . $cmdStr);
        exec("{$cmdStr} >> /home/www/web/go-study-line/shell/auto-install/shell.log 2>&1 ", $results, $status);
        if ($status !== 0) {
            return "脚本执行错误";
        }
        return "正在执行中....";
    }

    /**
     * 动态显示安装信息
     * @return string
     */
    public function showInstallInfo()
    {
        $this->assign('wsServerIP', self::SERVER_IP);
        $this->assign('wsServerPort', 63804);
        if (request()->isAjax()) {
            // 接受参数
            $buildLicense = input('post.build-license');
            $pushServer = input('post.push-server');
            $pushServerPwd = input('post.push-server-pwd');
            $node1Server = input('post.node1-server');
            $node1ServerPwd = input('post.node1-server-pwd');
            $node2Server = input('post.node2-server');
            $node2ServerPwd = input('post.node2-server-pwd');
            $proxyServer = input('post.proxy-server');
            $proxyServerPwd = input('post.proxy-server-pwd');
//            // 这里启动php-cli 进程了
//            $servers = "121.41.88.209,115.29.8.55";
//            $pwds = "ss,ss";
//            $shell_script = self::SHELL_SCRIPT_PATH . "cli.php";
//            $cmdStr = "{$shell_script} {$servers} {$pwds}";
//            exec("/usr/local/bin/php {$cmdStr} >/dev/null 2>&1 &", $results, $status);
//            if ($status == 0) {
//                // 启动一个WebSocketd 服务
//                return json(['code' => 200, 'msg' => '系统进程启动成功', 'data' => []]);
//            }
//            return json(['code' => 500, 'msg' => '系统进程未成功启动']);
//            return json(['code' => $buildLicense, 'msg' => '系统进程未成功启动']);
        }
        $findRes = Db::table('resty_auto_install')->where('id', 22)->find();
//        halt(json_decode($findRes['install_config'],true));
        $this->assign('result',json_decode($findRes['install_config'],true));
        return $this->fetch();
    }

    public function api()
    {
        //请求参数
        $appId = 13669361192;
        $domainName = 'tinywan.amai8.com';
        $appName = 'live';
        //签名密钥
        $appSecret = 'eb9a365a9d37a1354e13ddd7973d5e02409ef451';
        //拼接字符串，注意这里的字符为首字符大小写，采用驼峰命名
        $str = "AppId" . $appId . "AppName" . $appName . "DomainName" . $domainName . $appSecret;
        //签名串，由签名算法sha1生成
        $sign = strtoupper(sha1($str));
        //请求资源访问路径以及请求参数，参数名必须为大写
        $url = "http://ssconsole.amaitech.com/openapi/createPushFlowAddress?AppId=" . $appId . "&AppName=" . $appName . "&DomainName=" . $domainName . "&Sign=" . $sign;
        //CURL方式请求
        $ch = curl_init() or die (curl_error());
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 360);
        $response = curl_exec($ch);
        curl_close($ch);
        //返回数据为JSON格式，进行转换为数组打印输出
        var_dump(json_decode($response, true));
    }

    public function jquery()
    {
        return $this->fetch();
    }

    /**
     * 自动安装配置文件
     * @return mixed
     */
    public function autoInstallConf1()
    {
        $data = [
            'sign' => 'd25341478381063d1c76e81b3a52e0592a7c997f',
            'oss_config' => [
                'host' => 'oss-cn-shanghai.aliyuncs.com',
                'access_key' => 'LTAIV09s4vFZyYmd',
                'key_secret' => 'qcIEmOR3X0rZcwymRqPu7WfFJGB1Ww'
            ],
            'redis_config' => [
                'host' => '192.168.10.12',
                'post' => 69320,
                'auth' => 'qcIEmOR3X0rZcwymRqPu7WfFJGB1Ww'
            ],
            'push_config' => [
                'ip' => '192.168.10.2',
                'user' => 'www',
                'pwd' => 'www123456'
            ],
            'live_node_proxy_config' => [
                'ip' => '192.168.10.100',
                'user' => 'www',
                'pwd' => 'www123456'
            ],
            'live_node_config' => [
                'node1' => [
                    'ip' => '192.168.10.10',
                    'user' => 'www',
                    'pwd' => 'www123456'
                ],
                'node2' => [
                    'ip' => '192.168.10.12',
                    'user' => 'www',
                    'pwd' => 'www123456'
                ],
                'node3' => [
                    'ip' => '192.168.10.13',
                    'user' => 'www',
                    'pwd' => 'www123456'
                ]
            ],
        ];
        $jsonData = [
            'email' => '756684177@qq.com',
            'sign' => 'd25341478381063d1c76e81b3a52e0592a7c997f',
            'install_config' => json_encode($data)
        ];

//      $res = Db::table('resty_auto_install')->insertGetId($jsonData);
//      halt($res);
        $findRes = Db::table('resty_auto_install')->where('id', 8)->find();
        halt($findRes);
//        $data = [
//            'sign'=>'d25341478381063d1c76e81b3a52e0592a7c997f',
//            'oss_config'=>[
//                'host'=>'oss-cn-shanghai.aliyuncs.com',
//                'access_key'=>'LTAIV09s4vFZyYmd',
//                'key_secret'=>'qcIEmOR3X0rZcwymRqPu7WfFJGB1Ww'
//            ],
//            'redis_config'=>[
//                'name'=>'Stephen Dolan',
//                'email'=>'mu@netsoc.tcd.ie',
//                'data_time'=>'2013-06-22T16:30:59Z'
//            ],
//            'push_config'=>[
//                'ip'=>'192.168.10.100',
//                'user'=>'www',
//                'pwd'=>'www123456'
//            ],
//            'live_node_proxy_config'=>[
//                'ip'=>'192.168.10.100',
//                'user'=>'www',
//                'pwd'=>'www123456'
//            ],
//            'live_node_config'=>[
//                'node1'=>[
//                    'ip'=>'192.168.10.10',
//                    'user'=>'www',
//                    'pwd'=>'www123456'
//                ],
//                'node2'=>[
//                    'ip'=>'192.168.10.12',
//                    'user'=>'www',
//                    'pwd'=>'www123456'
//                ],
//                'node3'=>[
//                    'ip'=>'192.168.10.13',
//                    'user'=>'www',
//                    'pwd'=>'www123456'
//                ]
//            ],
//        ];
//        //file_put_contents('/home/www/script/auto-install/auto-install-package/'.$sign.'.json',json_encode($data));
//        return json($data);
    }

    /**
     * 自动安装配置文件
     * @return mixed
     */
    public function autoInstallConfInsert()
    {
        $data = [
            'sign' => 'd25341478381063d1c76e81b3a52e0592a7c997f',
            'server_config' => [
                'ip_group' => '120.26.78.239,118.178.56.70,120.55.184.175',
                'pwd_group' => 'RootOracle11w,RootOracle11w,RootOracle11w'
            ],
            'path_config' => [
                'script_path' => '/home/www/script/auto-install',         // 脚本路径，安装包路径
                'remote_script_path' => '/root',  // 远程脚本路径远程脚本路径
                'remote_install_package_path' => '/root', // 远程安装包路径
                'id_rsa_path' => 'RootOracle11w123,RootOracle11w456,RootOracle11w789', // 免登陆证书路径
                'logs_path' => '/home/www/bin/logs', // 脚本输出日志路径
            ],
            'version_config' => [
                'openresty_version' => '1.11.2.5',
                'rtmp_version' => '1.2.0',
                'php_version' => '5.5.9'
            ],
            'package_config' => [
                'common' => 'libreadline-dev,libncurses5-dev,libpcre3-dev,libssl-dev,perl,make,build-essential,libxml2,libxml2-dev,libxslt-dev,unzip,jq',
                'php5' => 'php5-fpm,php5-gd,php5-cli,php5-curl,php5-mcrypt,php5-mysql,php5-readline,php5-redis'
            ],
            'oss_config' => [
                'host' => 'oss-cn-shanghai.aliyuncs.com',
                'access_key' => 'LTAIV09s4vFZyYmd',
                'key_secret' => 'qcIEmOR3X0rZcwymRqPu7WfFJGB1Ww',
                'upload_path' => 'oss://tinywan-oss/data/',
                'download_url' => 'https://docs-aliyun.cn-hangzhou.oss.aliyun-inc.com/internal/oss/0.0.4/assets/sdk/OSS_Python_API_20160419.zip'
            ],
            'record_config' => [
                'callback_url' => 'https://www.tinywan.com/api/open_api/createStreamVideo',
                'screenshot_time' => '10',
                'cut_mp4' => '1',
                'cut_jpg' => '1',
                'cut_ts' => '0',
                'clear_file_time' => '10080' //分钟
            ],
            'redis_config' => [
                'host' => '139.224.239.21',
                'port' => '61227',
                'auth' => 'stream-system-auto-install-redis-password',
                'db' => '1'
            ],
            'push_config' => [
                'ip' => '192.168.10.2',
                'user' => 'www',
                'pwd' => 'www123456'
            ],
            'live_node_proxy_config' => [
                'ip' => '192.168.10.100',
                'user' => 'www',
                'pwd' => 'www123456'
            ],
            'live_node_config' => [
                'node1' => [
                    'ip' => '192.168.10.10',
                    'user' => 'www',
                    'pwd' => 'www123456'
                ],
                'node2' => [
                    'ip' => '192.168.10.12',
                    'user' => 'www',
                    'pwd' => 'www123456'
                ],
                'node3' => [
                    'ip' => '192.168.10.13',
                    'user' => 'www',
                    'pwd' => 'www123456'
                ]
            ],
        ];
        $jsonData = [
            'email' => '756684177@qq.com',
            'sign' => 'd25341478381063d1c76e81b3a52e0592a7c997f',
            'install_config' => json_encode($data)
        ];

        $res = Db::table('resty_auto_install')->insertGetId($jsonData);
        halt($res);
    }

    /**
     * 表单提交数据自动插入
     * @return mixed
     */
    public function fromAutoInstallConfInsert()
    {
        $data = [
            'sign' => 'd25341478381063d1c76e81b3a52e0592a7c997f',
            'server_config' => [
                'ip_group' => '120.26.78.239,118.178.56.70,120.26.93.84,118.178.123.62',//服务器IP地址
                'user_group' => 'root,root,root,root',//服务器账号
                'pwd_group' => 'RootOracle11w,RootOracle11w,RootOracle11w,RootOracle11w'//账号账号密码
            ],
            'path_config' => [
                'script_path' => '/home/www/script/auto-install',         // 脚本路径，安装包路径
                'remote_script_path' => '/root',  // 远程脚本路径远程脚本路径
                'remote_install_package_path' => '/root', // 远程安装包路径
                'id_rsa_path' => 'RootOracle11w123,RootOracle11w456,RootOracle11w789', // 免登陆证书路径
                'logs_path' => '/home/www/bin/logs', // 脚本输出日志路径
            ],
            'version_config' => [
                'openresty_version' => '1.11.2.5',
                'rtmp_version' => '1.2.0',
                'php_version' => '5.5.9'
            ],
            'package_config' => [
                'common' => 'libreadline-dev,libncurses5-dev,libpcre3-dev,libssl-dev,perl,make,build-essential,libxml2,libxml2-dev,libxslt-dev,unzip,jq',
                'php5' => 'php5-fpm,php5-gd,php5-cli,php5-curl,php5-mcrypt,php5-mysql,php5-readline,php5-redis'
            ],
            'oss_config' => [
                'host' => 'oss-cn-shanghai.aliyuncs.com',
                'access_key' => 'LTAIV09s4vFZyYmd',
                'key_secret' => 'qcIEmOR3X0rZcwymRqPu7WfFJGB1Ww',
                'upload_path' => 'oss://tinywan-oss/data/',
                'download_url' => 'https://docs-aliyun.cn-hangzhou.oss.aliyun-inc.com/internal/oss/0.0.4/assets/sdk/OSS_Python_API_20160419.zip'
            ],
            'record_config' => [
                'callback_url' => 'https://www.tinywan.com/api/open_api/createStreamVideo',
                'screenshot_time' => '10',
                'cut_mp4' => '1',
                'cut_jpg' => '1',
                'cut_ts' => '0',
                'clear_file_time' => '10080' //分钟
            ],
            'redis_config' => [
                'host' => '139.224.239.21',
                'port' => '61227',
                'auth' => 'stream-system-auto-install-redis-password',
                'db' => '1'
            ],
            'push_config' => [
                'ip' => '192.168.10.2',
                'user' => 'www',
                'pwd' => 'www123456'
            ],
            'live_node_proxy_config' => [
                'ip' => '192.168.10.100',
                'user' => 'www',
                'pwd' => 'www123456'
            ],
            'live_node_config' => [
                'node1' => [
                    'ip' => '192.168.10.10',
                    'user' => 'www',
                    'pwd' => 'www123456'
                ],
                'node2' => [
                    'ip' => '192.168.10.12',
                    'user' => 'www',
                    'pwd' => 'www123456'
                ],
                'node3' => [
                    'ip' => '192.168.10.13',
                    'user' => 'www',
                    'pwd' => 'www123456'
                ]
            ],
        ];
        $jsonData = [
            'email' => '756684177@qq.com',
            'sign' => 'd25341478381063d1c76e81b3a52e0592a7c997f',
            'install_config' => json_encode($data)
        ];

        $res = Db::table('resty_auto_install')->insertGetId($jsonData);
        halt($res);
    }

    /**
     * 自动安装配置文件
     * @return mixed
     */
    public function autoInstallConf()
    {
        $sign = input('param.sign');

        if (empty($sign) || ($sign != 'd25341478381063d1c76e81b3a52e0592a7c997f')) {
            $resJson = [
                'code' => 500,
                'msg' => 'fail',
                'data' => null
            ];
        } else {
            $findRes = Db::table('resty_auto_install')->where('id', 23)->find();
            $resJson = [
                'code' => 200,
                'msg' => 'success',
                'data' => json_decode($findRes['install_config'])
            ];
        }
        return json($resJson);
    }

    /**
     * 点播详情
     */
    public function room(){
        return $this->fetch();
    }
}

