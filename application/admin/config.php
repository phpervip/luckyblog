<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/6/26-14:14
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: config.php
     * Keys: ctrl+alt+L/ctrl+s(代码格式化) ctrl+J(代码提示) ctrl+R(替换)ALT+INSERT(生成代码(如GET,SET方法,构造函数等) , 光标在类中才生效)
     * CTRL+ALT+O (优化导入的类和包 需要配置) SHIFT+F2(高亮错误或警告快速定位错误)
     * CTRL+SHIFT+Z(代码向前) CTRL+SHIFT+/ (块状注释) ctrl+shift+enter(智能完善代码 如if())
     *
     **************************************************************
     *                                                            *
     *   .=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-.       *
     *    |                     ______                     |      *
     *    |                  .-"      "-.                  |      *
     *    |                 /            \                 |      *
     *    |     _          |              |          _     |      *
     *    |    ( \         |,  .-.  .-.  ,|         / )    |      *
     *    |     > "=._     | )(__/  \__)( |     _.=" <     |      *
     *    |    (_/"=._"=._ |/     /\     \| _.="_.="\_)    |      *
     *    |           "=._"(_     ^^     _)"_.="           |      *
     *    |               "=\__|IIIIII|__/="               |      *
     *    |              _.="| \IIIIII/ |"=._              |      *
     *    |    _     _.="_.="\          /"=._"=._     _    |      *
     *    |   ( \_.="_.="     `--------`     "=._"=._/ )   |      *
     *    |    > _.="                            "=._ <    |      *
     *    |   (_/                                    \_)   |      *
     *    |                                                |      *
     *    '-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-='      *
     *                                                            *
     *                    JUST FIND YOUR BUG !                    *
     **************************************************************
     */


    return [
        'session'                => [
            // SESSION 前缀
            'prefix'         => 'admin',
            // 驱动方式 支持redis memcache memcached
            'type'           => '',
            // 是否自动开启 SESSION
            'auto_start'     => true,
            'expire'         => 3600*2
        ],

        //'empty_controller' =>'Index',

        // 视图输出字符串内容替换
        'view_replace_str'       => [
            '{__PUBLIC_PATH}' =>  PUBILC_PATH,                 //public 目录
            '{__VIEW_PATH}'   =>  VIEW_PATH,
            '{__STATIC_PATH}' =>  PUBILC_PATH.'static/',       //全局静态目录
            '{__ADMIN_PATH}'  =>  PUBILC_PATH.'luckyblog/admin/', //后台框架
            '{__MODULE_PATH}' =>  PUBILC_PATH.'luckyblog/module/',//后台模块
            '{__PLUG_PATH}' =>  PUBILC_PATH.'luckyblog/plug/',//后台插件
        ],
        'cookie'                 => [
            // cookie 名称前缀
            'prefix'    => 'LuckyAdmin',
            // cookie 保存时间
            'expire'    => 1800,
            // cookie 保存路径
            'path'      => '/',
            // cookie 有效域名
            'domain'    => '',
            //  cookie 启用安全传输
            'secure'    => false,
            // httponly设置
            'httponly'  => '',
            // 是否使用 setcookie
            'setcookie' => true,
        ],


        //分页配置
        'paginate'               => [
            'type'      => 'layui',
            'var_page'  => 'page',
            'list_rows' => 15,
        ],




    ];