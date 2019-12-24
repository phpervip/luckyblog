<?php
/**
 *+----------------------------------------------------------------------
 *| Keywords: ctrl+alt+L(代码格式化) ctrl+R(替换) ALT+INSERT(生成代码(如GET,SET方法,构造函数等) , 光标在类中才生效) CTRL+ALT+O (优化导入的类和包 需要配置) SHIFT+F2(高亮错误或警告快速定位错误)  CTRL+SHIFT+/ (块状注释) ctrl+shift+enter(智能完善代码 如if())
 *+----------------------------------------------------------------------
 *| LuckyAdmin-v2.0框架 [ LuckyAdmin ]
 *+----------------------------------------------------------------------
 *| 版权所有 2019~2022 [ hhygyl ]
 *+----------------------------------------------------------------------
 *| 官方网站: http://luckyadmin.luckyhhy.cn/
 *+----------------------------------------------------------------------
 *| Author: 杰瑞克 <hhygyl520@qq.com>
 *+----------------------------------------------------------------------
 *| DateTime: 2019/7/29-16:14
 *+----------------------------------------------------------------------
 *| FileName: config.ini.php
 * +----------------------------------------------------------------------
 */

//定义域名常量

define('SITE_URL','http://luckyadmin.luckyhhy.cn/'); //官网

//定义版本
define('VERSION', 'v2.1.0');

define('POST_MAX',rtrim(ini_get('upload_max_filesize'),'M'));

define("SYSTEM_NAME","LuckyAdmin"); //定义框架系统名


//配置文件
return [
    // 站点名称
    'site_name'     => 'LuckyAdmin-Thinkphp5.0_V2.1',
    // 简称
    'nick_name'     => 'LuckyAdmin',

    // 上传参数配置
    'upload'        => [
        //上传图片参数配置
        'image_config'  => [
            // 图片后缀限制
            'upload_image_ext'  => 'jpg|png|gif|bmp|jpeg',
            // 最大上传文件大小(默认：10MB)
            'upload_image_size' => 1024*10,
            // 最大上传数量限制(默认：30张)
            'upload_image_max'  => 50,
        ],
        //上传视频参数配置
        'video_config'  => [
            // 视频后缀限制
            'upload_video_ext'  => 'mp4|avi|mov|rmvb|flv',
            // 最大上传文件大小(默认：100MB)
            'upload_video_size' => 1024*100,
            // 最大上传数量限制(默认：4个)
            'upload_video_max'  => 4,
        ],
    ],

];