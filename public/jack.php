<?php
    if(version_compare(PHP_VERSION,'5.5.9','<'))  die('require PHP > 5.5.9 !');
    //error_reporting(E_ALL ^ E_NOTICE);//显示除去 E_NOTICE 之外的所有错误信息
    error_reporting(E_ERROR | E_WARNING | E_PARSE);//报告运行时错误
    //检测是否已安装CrmEb系统

    // [ 应用入口文件 ]
    // 定义应用目录
    define('APP_PATH', __DIR__ . '/../application/');
    //静态文件目录
    define('PUBILC_PATH', '/');
    //上传文件目录
    define('UPLOAD_PATH', 'public/uploads');

    define('VIEW_PATH', 'public');

    define('BIND_MODULE','admin');

    // 加载框架引导文件
    require __DIR__ . '/../thinkphp/start.php';
