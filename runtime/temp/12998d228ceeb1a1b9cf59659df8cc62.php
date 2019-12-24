<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/index/index.html";i:1577193368;}*/ ?>
<!--
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/6/26-16:08
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: index.html
 *-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/luckyblog/admin/css/luckyadmin-v1.css" />
    <script src="/luckyblog/admin/js/jquery-2.0.3.min.js"></script>
<!--    <link rel="stylesheet" href="/luckyblog/admin/css/font-awesome.css" />-->
</head>

<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin okadmin">
    <!--头部导航-->
    <div class="layui-header okadmin-header">
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item">
                <a class="ok-menu ok-show-menu" href="javascript:;" title="菜单切换">
                    <i class="layui-icon layui-icon-shrink-right" id="ok_app_menu"></i>
                </a>
            </li>
            <li class="layui-nav-item">
                <a class="ok-refresh" href="javascript:;" title="刷新">
                    <i class="layui-icon layui-icon-refresh-3"></i>
                </a>
            </li>

            <li class="weather ok-nav-item">
                <div id="tp-weather-widget"></div>
            </li>

        </ul>
        <ul class="layui-nav layui-layout-right">

             <li class=" no-line layui-nav-item layui-hide-xs">
                <a href="javascript:" class="flex-vc">
                    <marquee width="200">通知：此博客系统开源免费，但请勿进行出售或者上传到任何素材网站，否则将追究相应的责任！</marquee>
                </a>

            </li>
             <li class="no-line layui-nav-item layui-hide-xs">
                <a  class="flex-vc pr10 pl10" href="/" target="__blank">
                    <i class="layui-icon layui-icon-home "></i><cite> 网站首页</cite>
                </a>
            </li>

            <li class="no-line layui-nav-item layui-hide-xs">
                <a id="huancun" class="flex-vc pr10 pl10" href="javascript:;">
                    <i class="layui-icon layui-icon-refresh icon-head-i"></i><cite>清除缓存</cite>
                </a>
            </li>

            <li class="no-line layui-nav-item layui-hide-xs">
                <a id="notice" class="flex-vc pr10 pl10" href="javascript:;">
                    <i class="ok-iconbell icon-head-i"></i><cite>系统公告</cite>
                </a>
            </li>

            <li class="no-line layui-nav-item layui-hide-xs">
                <a id="lock" class="flex-vc pr10 pl10" href="javascript:;">
                    <i class="ok-iconlock_outline icon-head-i"></i><cite>锁屏</cite>
                </a>
            </li>




            <li class="layui-nav-item layui-hide-xs">
                <a id="fullScreen" class=" pr10 pl10" href="javascript:;">
                    <i class="layui-icon layui-icon-screen-full"></i>
                </a>
            </li>

            <li class="no-line layui-nav-item">
                <a href="javascript:;">
                    <img src="<?php if(empty($admin_info['avatar']) || (($admin_info['avatar'] instanceof \think\Collection || $admin_info['avatar'] instanceof \think\Paginator ) && $admin_info['avatar']->isEmpty())): ?> /luckyblog/admin/images/user.jpg <?php else: ?> <?php echo $admin_info['avatar']; endif; ?> " class="layui-nav-img">
                   <?php echo $admin_info['nickname']; ?>
                </a>
                <dl id="userInfo" class="layui-nav-child">

                    <dd>
                        <a lay-id="u-2" href="javascript:;" data-url="<?php echo url('setting/myinfo'); ?>">基本资料</a>
                    </dd>
                    <dd>
                        <a lay-id="u-3" href="javascript:;" data-url="<?php echo url('setting/safe'); ?>">安全设置</a>
                    </dd>
                    <dd>
                        <hr/>
                    </dd>
                    <dd>
                        <a href="javascript:void(0)" id="logout">退出登录</a>
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
    <!--遮罩层-->
    <div class="ok-make"></div>
    <!--左侧导航区域-->
    <div class="layui-side layui-side-menu okadmin-bg-20222A ok-left">
        <div class="layui-side-scroll okadmin-side">
            <div class="okadmin-logo">后台管理</div>
            <div class="user-photo">
                <a class="img" title="我的头像">
                    <img src="<?php if(empty($admin_info['avatar']) || (($admin_info['avatar'] instanceof \think\Collection || $admin_info['avatar'] instanceof \think\Paginator ) && $admin_info['avatar']->isEmpty())): ?> /luckyblog/admin/images/user.jpg <?php else: ?> <?php echo $admin_info['avatar']; endif; ?>" class="userAvatar">
                </a>
                <p>你好！<span class="userName"><?php echo $admin_info['nickname']; ?></span>, 欢迎登录</p>
            </div>
            <!--左侧导航菜单-->
            <ul id="navBar" class="layui-nav okadmin-nav okadmin-bg-20222A layui-nav-tree">
                <li class="layui-nav-item layui-this">
                    <a href="javascript:;" lay-id="1" data-url="">
                        <i is-close=false class="ok-icon ok-iconairplay"></i> 后台首页
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- 内容主体区域 -->
    <div class="content-body">
        <div class="layui-tab ok-tab" lay-filter="ok-tab" lay-allowClose="true" lay-unauto>

            <div data-id="left" id="okLeftMove" class="layui-icon okadmin-tabs-control layui-icon-prev okNavMove"></div>
            <div data-id="right" id="okRightMove" class="layui-icon okadmin-tabs-control layui-icon-next okNavMove"></div>

            <div class="layui-icon okadmin-tabs-control ok-right-nav-menu" style="right: 0;">
                <ul class="okadmin-nav">
                    <li class="no-line okadmin-nav-item">
                        <div class="okadmin-link layui-icon-down" href="javascript:;"></div>
                        <dl id="tabAction" class="okadmin-nav-child layui-anim-upbit layui-anim">
                            <dd>
                                <a data-num="1" href="javascript:;">关闭当前标签页</a>
                            </dd>
                            <dd>
                                <a data-num="2" href="javascript:;">关闭其他标签页</a>
                            </dd>
                            <dd>
                                <a data-num="3" href="javascript:;">关闭所有标签页</a>
                            </dd>
                        </dl>
                    </li>
                </ul>
            </div>

            <ul class="layui-tab-title ok-tab-title not-scroll">
                <li class="layui-this" lay-id="1" tab="index">
                    <i class="layui-icon layui-icon-home"></i>
                    <cite is-close=false>后台首页</cite>
                </li>
            </ul>

            <div class="layui-tab-content ok-tab-content" >
                <div class="layui-tab-item layui-show">
                    <iframe src="<?php echo url('index/home'); ?>" frameborder="0" scrolling="yes" width="100%" height="100%"></iframe>
                </div>
            </div>


        </div>
    </div>


    <!--底部信息-->
    <div class="layui-footer okadmin-text-center" style="background-color: white;">
       <button class="layui-btn layui-btn-warm layui-btn-xs communication">联系作者</button>
        Copyright ©2019-©2020 luckyadmin v2.1  All Rights Reserved
       <button class="layui-btn layui-btn-danger layui-btn-xs donate" >捐赠作者</button>

    </div>


</div>


<script >
    var NAV_URL="<?php echo url('admin/adminmenu/MenuListJson'); ?>";
    var Login_out="<?php echo url('admin/login/LoginOut'); ?>";
    var lOGIN="<?php echo url('admin/login/index'); ?>";
    var zfb="/luckyblog/admin/images/zfb.jpeg";
    var wxs="/luckyblog/admin/images/wx.png";
    var lock_url="<?php echo url('admin/index/lock_pass'); ?>";
    var href_jump="<?php echo url('admin/index/lock'); ?>";
    var cache_url="<?php echo url('admin/index/cache_clear'); ?>";
</script >

<!--js逻辑-->
<script src="/luckyblog/plug/layui/layui.js"></script>

<script src="/luckyblog/admin/js/luckyadmin.js"></script>

<script >
    /**
     * 左侧导航tips提示
     */
    $(document).on('mouseenter', '.show_tips a', function() {
        var tip_index = layer.tips($(this).find('cite').text(), this, {
            time: 0
        });
        $(this).data('tip-index', tip_index);
    })
    $(document).on('mouseleave', '.show_tips a', function() {
        var tip_index = $(this).data('tip-index');
        if (tip_index !== undefined) {
            layer.close(tip_index);
        }
    });
</script >

<!--天气预报插件-->
<script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
<script>tpwidget("init",{"flavor":"slim","location":"WX4FBXXFKE4F","geolocation":"enabled","language":"zh-chs","unit":"c","theme":"chameleon","container":"tp-weather-widget","bubble":"disabled","alarmType":"badge","color":"#FFFFFF","uid":"U9EC08A15F","hash":"039da28f5581f4bcb5c799fb4cdfb673"});tpwidget("show");</script>

</body>

</html>