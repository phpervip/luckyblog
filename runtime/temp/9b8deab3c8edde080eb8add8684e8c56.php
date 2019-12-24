<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:79:"/Users/mac/data/tp/luckyblog/public/../application/index/view/article/show.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/index/view/public/base.html";i:1577193368;s:70:"/Users/mac/data/tp/luckyblog/application/index/view/public/header.html";i:1577193368;s:69:"/Users/mac/data/tp/luckyblog/application/index/view/public/share.html";i:1577193368;s:67:"/Users/mac/data/tp/luckyblog/application/index/view/public/zan.html";i:1577199287;s:69:"/Users/mac/data/tp/luckyblog/application/index/view/public/right.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/index/view/public/card.html";i:1577199717;s:70:"/Users/mac/data/tp/luckyblog/application/index/view/public/footer.html";i:1577193368;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo (isset($setting['site_name']) && ($setting['site_name'] !== '')?$setting['site_name']:"小贺博客"); ?>-<?php echo (get_nav_name($nav_id) ?: "网站首页"); ?></title>
    <meta name="keywords" content="<?php echo (strip_tags($setting['meta']) ?: 'Luckyadmin,Thinkphp5,layui,个人博客'); ?>" />
    <meta name="description" content="<?php echo (strip_tags($setting['meta_describe']) ?: 'Luckyadmin,Thinkphp5,layui,个人博客,网站开发'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- other Phone -->
    <meta name="theme-color" content="#008B8B" />
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#008B8B">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-capable" content="#008B8B">
    <meta name="apple-mobile-web-app-status-bar-style" content="#008B8B">
   <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link href="/luckyblog/home/css/base.css" rel="stylesheet">
    <link href="/luckyblog/home/css/other.css" rel="stylesheet">
    <link href="/luckyblog/home/css/index.css" rel="stylesheet">
    <link href="/luckyblog/home/css/m.css" rel="stylesheet">
    <script src="/luckyblog/home/js/jquery.min.js" type="text/javascript"></script>
    <script src="/luckyblog/home/js/jquery.easyfader.min.js"></script>
    <script src="/luckyblog/home/js/scrollReveal.js"></script>
    <script src="/luckyblog/home/js/common.js"></script>
    <!--[if lt IE 9]>
    <script src="/luckyblog/home//js/modernizr.js"></script>
    <![endif]-->

<!--    <script  src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script >
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >-->

    <script src="/luckyblog/plug/layui/layui.js"></script>
   <link rel="stylesheet" href="/luckyblog/plug/layui/css/layui.css">

    <script  src="/luckyblog/home/js/jquery.lazyload.min.js"></script >

    
<link type="text/css" rel="stylesheet" href="/luckyblog/home/css/chanyan.css">
<style>
    .gbox { padding: 20px; overflow: hidden; }
    .gbox p { margin-bottom: 10px }
    p.fbtime { color: #000; }
    .fbtime span { float: right; color: #999; font-size: 12px; }
    p.fbinfo { margin: 10px 0; }
    .fb ul {
        margin: 1px 0px;
        border-bottom: #ececec 1px solid;
    }
    .hf ul { padding: 5px 10px; background: #f9f9f9; }
    .hf { margin: 0 10px; padding-bottom: 10px; border-bottom: #dedddd 1px dashed; }
    textarea#lytext { width: 100%; }
    .zzhf{word-wrap : break-word;}
    .amg{width: 60px;height: 60px;border-radius: 50%; float: left;}
</style>


</head>
<body>



<style type="text/css">
    body {
        cursor: url(/luckyblog/home/images/1.png),default
    }
    a:hover {
        cursor: url(/luckyblog/home/images/2.png),pointer
    }
</style>



<header>
    <!--menu begin-->
    <div class="menu">
        <nav class="nav" id="topnav">
            <h1 class="logo" ><?php echo (isset($setting['site_name']) && ($setting['site_name'] !== '')?$setting['site_name']:"小贺博客"); ?></h1>
            <li>
                <a href="/" <?php if(empty($nav_id) || $nav_id==0): ?> id="topnav_current" <?php endif; ?>>网站首页</a>
            </li>

           <?php if(is_array($navigate_data) || $navigate_data instanceof \think\Collection || $navigate_data instanceof \think\Paginator): $i = 0; $__LIST__ = $navigate_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

            <li>
                <a  <?php if($vo['model_id'] == '7' || $vo['model_id'] == '6'): ?>  href="<?php echo $vo['href']; ?>"  target="_blank"  <?php else: ?>  href="javascript:" <?php endif; if($vo['id'] == $nav_id): ?> id="topnav_current" <?php endif; ?> ><?php echo $vo['title']; ?></a>

                <?php if(isset($vo['children'])): ?>
                <ul class="sub-nav">
                    <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <li>
                        <a  href="<?php echo $v['href']; ?>" <?php if($v['model_id'] == '7'): ?>  href="<?php echo $vo['href']; ?>"  target="_blank"  <?php else: ?> href="javascript:"  <?php endif; if($v['id'] == $nav_id): ?> id="topnav_current" <?php endif; ?>><?php echo $v['title']; ?></a>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>

                </ul>
                <?php endif; ?>
            </li>

            <?php endforeach; endif; else: echo "" ;endif; ?>




            <!--search begin-->
            <div id="search_bar" class="search_bar">
                <form id="searchform" action="<?php echo url('index/index/search'); ?>" method="get" name="searchform">
                    <input class="input" placeholder="输入关键词回车..." type="text" name="keywords" required="required" id="keyboard">
                    <p class="search_ico"> <span></span></p>
                </form>
                <i class="fa"></i>
            </div>
            <!--search end-->

        </nav>
    </div>

    <!--menu end-->
    <!--mnav begin-->
    <div id="mnav">
        <h2><?php echo (isset($setting['site_name']) && ($setting['site_name'] !== '')?$setting['site_name']:"小贺博客"); ?>
            <span class="navicon"></span>
        </h2>
        <dl class="list_dl">
            <dt class="list_dt"> <a  <?php if(empty($nav_id) || $nav_id==0): ?> class="current" <?php endif; ?>  href="/">网站首页</a> </dt>

            <?php if(is_array($navigate_data) || $navigate_data instanceof \think\Collection || $navigate_data instanceof \think\Paginator): $i = 0; $__LIST__ = $navigate_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

            <dt class="list_dt"> <a  <?php if($vo['model_id'] == '7' || $vo['model_id'] == '6'): ?>  href="<?php echo $vo['href']; ?>"  target="_blank"  <?php else: ?>  href="javascript:" <?php endif; if($vo['id'] == $nav_id): ?>  class="current" <?php endif; ?>><?php echo $vo['title']; ?></a>
            </dt>
            <?php if(isset($vo['children'])): ?>
            <!-- 这里是二级栏目的循环，不需要的可以删除，代码开始 -->
            <dd class="list_dd">
                <ul>
                    <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <li>
                        <a href="<?php echo $v['href']; ?>" <?php if($v['model_id'] == '7'): ?>  href="<?php echo $vo['href']; ?>"  target="_blank"  <?php else: ?>  href="javascript:" <?php endif; if($v['id'] == $nav_id): ?> class="current" <?php endif; ?>><?php echo $v['title']; ?></a>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </dd>
            <?php endif; ?>
            <!-- 这里是二级栏目的循环，不需要的可以删除，代码结束 -->
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </dl>
    </div>
    <!--mnav end-->
</header>



<article>
    <h1 class="t_nav">
         <?php echo brand_nav($data['navigate_id']); ?>
        <a href="/" class="n1">网站首页</a><a href="javascript:" class="n2"><?php echo get_nav_name($data['navigate_id']); ?></a></h1>
    <div class="infosbox">
        <div class="newsview">
            <h3 class="news_title"><?php echo $data['title']; ?></h3>
            <div class="bloginfo">
                <ul>
                    <li class="author">
                        <a href="javascript:void"><?php echo $data['author']; ?></a>
                    </li>
                    <li class="lmname">
                        <a href="javascript:void"><?php echo get_nav_name($data['navigate_id']); ?></a>
                    </li>
                    <li class="timer"><?php echo friend_time($data['create_time']); ?></li>
                    <li class="view"><?php echo $data['hits']; ?> 次阅读</li>
                    <li class="like"><?php echo $data['zan']; ?></li>
                    <li> <span class="layui-badge layui-bg-warm" style="float: right;"><?php echo $data['source']; ?></span></li>
                </ul>
            </div>
            <!--文章标签-->
            <?php if(!(empty($data['tags']) || (($data['tags'] instanceof \think\Collection || $data['tags'] instanceof \think\Paginator ) && $data['tags']->isEmpty()))):  $tag_arr=@explode(',',$data['tags']);?>
            <div class="tags">
                <?php if(is_array($tag_arr) || $tag_arr instanceof \think\Collection || $tag_arr instanceof \think\Paginator): $i = 0; $__LIST__ = $tag_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?>
                <a href="javascript:" ><?php echo $t; ?></a> &nbsp;
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <?php endif; ?>
            <!--文章标签结束-->

            <div class="news_about">
                <!-- 内容简介开始-->
                <?php echo $data['description']; ?>
                <!-- 内容简介结束-->
            </div>

            <div class="news_con">
                <!-- 内容开始-->

                 <?php echo $data['content']; ?>

                <!-- 内容结束-->

                <!--文章分享-->
                <!--
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/8/15-11:12
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: share.html
 *-->

<div class="share_1" style="margin-top: 20px;">
    <span>分享：</span>
    <a title="分享到新浪微博" class="weibo" onclick="window.open(&quot;http://service.weibo.com/share/share.php?url=<?php echo $now_url; ?>&amp;title=<?php echo $data['description']; ?>&amp;pic=<?php echo $domain; ?><?php echo $data['image_url']; ?>&amp;searchPic=true&quot;)" target="_blank"><svg class="icon" viewBox="0 0 1024 1024"><path d="M 783.055 155.691 c -30.146 -6.856 -70.576 -5.449 -121.289 4.131 c -0.703 0 -1.406 0.352 -2.109 1.055 l -1.055 2.109 l -1.055 1.055 c -7.559 2.021 -13.711 6.328 -18.545 12.832 c -4.834 6.503 -7.207 13.535 -7.207 21.006 c 0 10.283 3.427 18.809 10.283 25.664 c 6.856 6.856 15.117 10.283 24.698 10.283 h 3.076 c 0.703 0 2.198 -0.352 4.658 -1.055 c 2.373 -0.703 5.01 -1.23 7.734 -1.582 c 2.724 -0.352 5.625 -1.055 8.789 -2.109 c 3.076 -1.055 5.888 -2.021 8.262 -3.076 c 2.373 -1.055 7.031 -1.582 13.887 -1.582 c 6.856 0 15.293 0.528 25.224 1.582 c 9.932 1.055 20.918 3.604 32.871 7.646 c 12.041 4.131 23.994 9.229 35.947 15.381 c 11.953 6.153 23.994 14.766 35.947 25.664 c 12.041 10.898 22.5 23.555 31.377 37.969 c 17.842 40.342 21.27 79.365 10.283 117.07 c 0 0.703 -0.176 1.406 -0.528 2.109 c -0.352 0.703 -0.879 2.373 -1.582 5.098 c -0.703 2.724 -1.406 5.273 -2.109 7.646 c -0.703 2.373 -1.406 5.45 -2.109 9.229 c -0.703 3.779 -1.055 7.031 -1.055 9.756 c 0 6.153 1.67 11.25 5.098 15.381 c 3.428 4.131 7.734 7.031 12.833 8.701 c 5.185 1.67 11.162 2.549 18.018 2.549 c 19.161 0 30.498 -11.602 33.926 -34.893 c 8.262 -26.719 12.832 -52.208 13.887 -76.465 c 1.055 -24.258 -0.703 -45.703 -5.098 -64.161 c -4.482 -18.457 -11.162 -35.771 -20.039 -51.856 c -8.877 -16.084 -19.161 -29.795 -30.849 -41.045 c -11.69 -11.338 -24.697 -21.533 -39.112 -30.849 c -14.414 -9.229 -28.301 -16.612 -41.661 -22.06 c -13.184 -5.362 -27.07 -9.756 -41.396 -13.184 v 0 Z M 800.545 445.115 c 4.131 0 7.911 -1.055 11.338 -3.076 s 6.153 -4.658 8.261 -7.646 c 2.021 -3.076 3.428 -6.328 4.131 -9.756 c 0.703 -0.703 1.055 -1.67 1.055 -3.076 c 8.262 -78.047 -19.161 -122.52 -82.266 -133.418 c -18.545 -3.428 -35.684 -3.779 -51.416 -1.055 c -4.834 0 -8.877 1.231 -12.305 3.604 c -3.428 2.373 -6.328 5.449 -8.789 9.229 c -2.373 3.779 -3.604 7.734 -3.604 11.778 c 0 6.856 2.373 12.656 7.208 17.403 c 4.834 4.747 10.635 7.207 17.49 7.207 c 53.438 -12.305 82.266 4.747 86.308 51.328 c 1.406 11.602 0.703 22.588 -2.109 32.872 c 0 6.856 2.373 12.656 7.207 17.403 c 4.746 4.747 10.635 7.119 17.49 7.208 v 0 Z M 435.623 659.656 c -4.834 3.428 -9.756 4.922 -14.942 4.658 c -5.098 -0.352 -8.701 -2.549 -10.81 -6.68 l -2.109 -4.131 c -0.703 -1.406 -1.055 -2.724 -1.055 -4.131 v -4.131 c 0 -2.021 0.352 -3.779 1.055 -5.098 l 2.109 -4.131 c 0.703 -1.406 1.67 -2.373 3.076 -3.076 l 3.076 -4.131 c 5.45 -4.131 10.81 -5.801 15.908 -5.098 s 8.701 3.428 10.81 8.174 c 2.021 2.724 2.901 5.801 2.549 9.229 c -0.352 3.427 -1.406 6.68 -3.076 9.756 c -1.67 3.164 -3.867 6.065 -6.592 8.789 v 0 Z M 348.172 733.572 c -4.131 0.703 -8.086 0.879 -11.778 0.528 c -3.779 -0.352 -7.207 -1.055 -10.283 -2.109 c -3.076 -1.055 -6.153 -2.285 -9.229 -3.604 c -3.076 -1.318 -5.625 -3.252 -7.734 -5.625 c -2.109 -2.461 -3.955 -4.834 -5.625 -7.207 c -1.67 -2.373 -3.076 -5.098 -4.131 -8.174 c -1.055 -3.076 -1.583 -6.328 -1.583 -9.756 c 0 -7.559 2.021 -14.854 6.153 -22.06 c 4.131 -7.208 9.756 -13.359 16.963 -18.458 c 7.207 -5.185 15.205 -8.086 24.17 -8.701 c 6.153 -0.703 12.129 -0.528 18.018 0.527 s 10.81 2.724 14.942 5.098 c 4.131 2.373 7.734 5.098 10.81 8.174 c 3.076 3.076 5.362 6.68 6.68 10.81 c 1.318 4.131 2.021 8.526 2.109 13.359 c 0 7.559 -2.197 14.678 -6.68 21.533 c -4.482 6.856 -10.459 12.656 -18.018 17.403 c -7.558 4.747 -15.82 7.471 -24.785 8.262 v 0 Z M 385.174 539.51 c -19.864 2.021 -37.705 6.68 -53.438 13.887 s -28.125 15.381 -37.002 24.609 c -8.877 9.229 -16.435 19.16 -22.675 29.795 c -6.153 10.635 -10.459 21.006 -12.832 31.289 c -2.373 10.283 -3.955 19.688 -4.658 28.213 c -0.703 8.526 -1.055 15.205 -1.055 20.039 l 1.055 8.174 v 4.131 c 0 2.021 0.703 6.153 2.109 12.305 s 3.252 11.778 5.625 16.963 c 2.373 5.185 6.328 10.81 11.777 16.963 c 5.449 6.152 11.953 11.25 19.511 15.381 c 45.263 21.885 87.364 28.565 126.474 20.039 c 39.023 -8.526 70.576 -28.213 94.57 -59.063 c 9.58 -11.602 15.908 -26.016 18.984 -43.154 c 3.076 -17.138 2.373 -34.365 -2.109 -51.856 c -4.482 -17.402 -12.129 -33.31 -23.115 -47.724 c -10.987 -14.414 -27.246 -25.489 -48.779 -33.398 c -21.445 -7.823 -46.318 -10.019 -74.443 -6.592 v 0 Z M 415.057 823.924 c -74.004 3.428 -136.934 -10.987 -188.614 -43.154 c -51.768 -32.168 -77.607 -72.862 -77.607 -122.168 c 0 -48.604 25.664 -90.527 77.08 -125.771 c 51.416 -35.244 114.434 -54.58 189.141 -58.008 c 74.708 -3.427 137.724 8.877 189.141 36.914 c 51.416 28.037 77.08 66.357 77.08 114.961 c 0 49.307 -26.192 93.604 -78.662 132.891 c -52.383 39.463 -114.961 60.82 -187.559 64.336 v 0 Z M 728.563 504.705 c -10.283 -2.021 -16.963 -5.098 -20.039 -9.229 s -3.604 -7.823 -1.582 -11.338 l 3.076 -5.097 c 0.703 -0.703 1.406 -1.67 2.109 -3.076 s 2.109 -4.307 4.131 -8.701 c 2.021 -4.482 3.604 -8.877 4.658 -13.359 c 1.055 -4.482 1.933 -9.932 2.549 -16.435 c 0.703 -6.504 0.44 -12.656 -0.528 -18.458 c -0.967 -5.8 -3.076 -12.129 -6.153 -18.984 c -3.076 -6.856 -7.383 -13.008 -12.832 -18.457 c -9.58 -9.58 -22.148 -15.732 -37.529 -18.457 c -15.381 -2.724 -30.849 -2.901 -46.231 -0.528 c -15.381 2.373 -29.971 5.45 -43.682 9.229 c -13.711 3.779 -25.049 7.383 -33.925 10.81 l -13.359 6.153 c -6.856 2.021 -12.481 3.427 -16.963 4.131 c -4.482 0.703 -7.911 0.528 -10.283 -0.528 c -2.373 -1.055 -4.307 -2.021 -5.625 -3.076 c -1.318 -1.055 -1.846 -3.428 -1.582 -7.207 c 0.352 -3.779 0.703 -7.031 1.055 -9.756 c 0.352 -2.724 1.23 -7.031 2.549 -12.832 c 1.406 -5.801 2.373 -10.459 3.076 -13.887 c 0 -8.174 -0.527 -15.908 -1.582 -23.115 c -1.055 -7.207 -3.252 -15.205 -6.68 -24.083 c -3.427 -8.877 -8.349 -16.084 -14.942 -21.533 c -6.504 -5.45 -14.766 -9.932 -24.698 -13.359 c -9.932 -3.428 -22.763 -4.482 -38.584 -3.076 c -15.732 1.318 -33.575 5.45 -53.438 12.305 c -23.994 8.174 -48.34 20.391 -73.037 36.387 c -24.697 16.084 -46.055 32.872 -64.248 50.273 c -18.193 17.49 -34.805 34.365 -49.834 50.801 c -15.117 16.435 -26.719 29.795 -34.981 40.078 l -11.338 16.435 c -22.588 29.443 -39.375 58.887 -50.362 88.242 c -10.898 29.356 -16.084 51.592 -15.381 66.622 v 21.533 c 4.131 32.872 14.238 62.315 30.322 88.33 c 16.084 26.016 35.244 47.021 57.568 63.106 c 22.324 16.084 48.516 29.795 78.662 41.045 c 30.146 11.338 59.151 19.512 86.924 24.609 c 27.773 5.098 57.041 8.701 87.891 10.81 c 50.713 4.131 103.359 0.176 157.763 -11.778 c 54.492 -11.953 105.205 -32.695 152.138 -62.138 c 46.933 -29.443 80.068 -64.688 99.229 -105.732 c 11.69 -23.994 17.666 -46.582 18.018 -67.763 c 0.352 -21.182 -3.252 -38.497 -10.81 -51.856 c -7.559 -13.359 -17.315 -25.137 -29.356 -35.42 c -11.953 -10.283 -23.291 -17.842 -33.926 -22.588 c -10.635 -4.834 -20.039 -7.911 -28.301 -9.229 v 0.175 Z" p-id="3459"></path></svg></a>
    <a title="分享到QQ好友" class="qq" onclick="window.open(&quot;http://connect.qq.com/widget/shareqq/index.html?url=<?php echo $now_url; ?>&amp;title=<?php echo $data['description']; ?>&amp;pics=<?php echo $domain; ?><?php echo $data['image_url']; ?>&quot;)" target="_blank"><svg class="icon" viewBox="0 0 1024 1024"><path d="M 138.899 578.78 c -31.677 78.904 -36.919 154.139 -11.406 168.117 c 17.65 9.7 45.132 -12.493 71 -52.863 c 10.263 44.214 35.56 83.884 71.736 115.954 c -37.88 14.765 -62.697 38.883 -62.697 66.146 c 0 44.914 67.022 81.176 149.682 81.176 c 74.578 0 136.357 -29.447 147.757 -68.244 h 17.74 c 11.622 38.797 73.267 68.244 147.933 68.244 c 82.751 0 149.682 -36.263 149.682 -81.176 c 0 -27.263 -24.772 -51.205 -62.741 -66.146 c 36.046 -32.07 61.517 -71.74 71.696 -115.954 c 25.862 40.37 53.215 62.564 70.954 52.863 c 25.643 -13.978 20.531 -89.213 -11.45 -168.117 c -24.987 -61.778 -58.848 -107.39 -84.67 -117.613 c 0.35 -3.756 0.655 -7.909 0.655 -11.884 c 0 -23.943 -6.378 -46.05 -17.254 -64.05 c 0.218 -1.441 0.218 -2.796 0.218 -4.237 c 0 -11.053 -2.491 -21.321 -6.772 -30.191 C 774.453 189.984 674.97 62.106 513.887 62.106 c -161.042 0 -260.655 127.879 -267.164 288.7 c -4.193 9 -6.772 19.313 -6.772 30.322 c 0 1.443 0 2.796 0.175 4.239 c -10.658 17.869 -17.039 39.974 -17.039 64.005 c 0 4.02 0.217 8.04 0.481 11.971 c -25.732 10.135 -59.723 55.659 -84.669 117.437 Z"></path></svg></a>
    <a title="分享到QQ空间" class="qqzone" onclick="window.open(&quot;https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo $now_url; ?>&amp;title=<?php echo $data['description']; ?>&amp;summary=来自<?php echo $setting['site_name']; ?>&amp;pics=<?php echo $domain; ?><?php echo $data['image_url']; ?>&quot;)" target="_blank"><svg class="icon" viewBox="0 0 1024 1024"><path d="M 969.36 423.824 c 0 -10.208 0 -7.408 -10.208 -7.408 l -102.048 0 L 683.648 416.416 l -40.848 -72.72 L 530.56 128 c -10.224 0 -10.224 0 -20.432 0 l -102.016 215.68 l -40.832 72.72 L 193.776 416.4 L 48 416.4 l 0 4.64 l 57.584 40.848 l 161.472 142.944 l -36.64 326.72 c 0 10.208 2.096 10.208 22.496 10.208 l 266.384 -163.36 l 265.824 163.36 c 10.24 0 10.48 0 20.688 -10.208 l -50.896 -326.72 l 153.12 -131.36 L 969.36 423.824 Z M 295.856 736.88 L 591.776 495.68 l -275.52 -47.232 l 418.368 0 L 479.536 679.456 l 265.312 57.424 L 295.856 736.88 Z" p-id="2569"></path></svg></a>
</div>
<br >
<blockquote class="layui-elem-quote" style="font-size: 13px;">
    <b>转载：</b>
    感谢您对【<?php echo $setting['site_name']; ?>】网站平台的认可,非常欢迎各位朋友分享到个人站长或者朋友圈，但转载请说明文章出处【来源 <?php echo $setting['site_name']; ?>：
    <a href="<?php echo $now_url; ?>" target="_blank"><?php echo $now_url; ?></a>】。
</blockquote>

            </div>

        </div>

        <!--文章点赞打赏-->
        

<div class="share">
    <p class="diggit">
        <a href="javascript:;" onclick="article_like('<?php echo $data['id']; ?>',1)"> 很赞哦！ </a>(<b id="up"><?php echo $data['zan']; ?></b>)</p>
    <p class="dasbox" style="float:right;margin-right:30%">
        <a href="javascript:void(0)" onClick="dashangToggle()" class="dashang" title="打赏，支持一下">打赏本站</a>
    </p>
    <div class="hide_box"></div>
    <div class="shang_box">
        <a class="shang_close" href="javascript:void(0)" onclick="dashangToggle()" title="关闭">关闭</a>
        <div class="shang_tit">
            <p>感谢您的支持，我会继续努力的!</p>
        </div>
        <div class="shang_payimg"> <img src="/luckyblog/home/images/apay.jpeg" alt="扫码支持" title="扫一扫"> </div>
        <div class="pay_explain">扫码打赏</div>
        <div class="shang_payselect">
            <div class="pay_item checked" data-id="alipay"> <span class="radiobox"></span> <span class="pay_logo"><img src="/luckyblog/home/images/alipay.jpg" alt="支付宝"></span> </div>
            <div class="pay_item" data-id="weipay"> <span class="radiobox"></span> <span class="pay_logo"><img src="/luckyblog/home/images/wechat.jpg" alt="微信"></span> </div>
        </div>
        <script type="text/javascript">
            $(function() {
                $(".pay_item").click(function() {
                    $(this).addClass('checked').siblings('.pay_item').removeClass('checked');
                    var dataid = $(this).attr('data-id');
                    if (dataid == "alipay") {
                        $(".shang_payimg img").attr("src", "/luckyhhy/home/images/apay.jpeg");
                    }else {
                        $(".shang_payimg img").attr("src", "/luckyhhy/home/images/wxpay.png");
                    }
                });
            });

            function dashangToggle() {
                $(".hide_box").fadeToggle();
                $(".shang_box").fadeToggle();
            }
        </script>
    </div>
</div>


        <div class="nextinfo">
            <p>上一篇：

                <a href="<?php echo $data['prev']['url']; ?>"><?php echo $data['prev']['title']; ?></a>
            </p>
            <p>下一篇：
                <a href="<?php echo $data['next']['url']; ?>"><?php echo $data['next']['title']; ?></a>
            </p>
        </div>

        <div class="otherlink">
            <h2>相关文章</h2>
            <ul>
                <?php $__LIST__ = db('article')->where('status = 1 ')->field('*')->limit('6')->order('id desc')->select();foreach ($__LIST__ as $key => $da) {?>
                <li><i><?php echo $key+1; ?></i><a href="<?php echo $da['url']; ?>" title="<?php echo $da['title']; ?>"><?php echo title_str_cut($da['title'],"80"); ?></a></li>
                <?php } ?>
            </ul>
        </div>


        <div class="news_pl">
            <h2>文章评论</h2>
            <!--发表留言-->
            <a  name="tosaypl"></a >
            <div class="comment comment-main" >
                <fieldset class="layui-elem-field">
                    <legend>请君开口</legend>
                    <div class="layui-field-box">
                        <form class="commentform" id="comment-form-article">
                            <div id="user-name-content" class="user-name-content">欢迎您：<span class="iconfont"></span> <b id="user-name" style="color:#fa889b;"></b></div>
                            <div style="display: flex">
                                <img id="avatar" src="/luckyblog/home/images/avatar.jpg" height="42" width="42" class="avatar-42">
                                <div style="width: 100%; margin-left: 5px;">
                                    <div class="form-group" id="user-info" style="overflow: hidden;">
                                        <input type="hidden" id="article_id" name="article_id" value="<?php echo $data['id']; ?>" >
                                        <input type="hidden" id="pid" name="pid" value="0" >
                                        <input type="hidden" id="image"  >
                                        <input type="text"  id="qqq"  name="qq" placeholder="QQ（可获取头像和昵称）">
                                        <input type="text"  id="username" placeholder="自动获取" autocomplete="off" readonly="">
                                    </div>
                                    <div class="comment-textarea" style="margin-top: 5px">
                                        <textarea id="comment-textarea" name="content" placeholder="既然来了就说点啥呗" class="" style="height: 50px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <ul class="comment-submit">
                                <button id="submitCommentBtn-article" type="button" class="commentbutton">提交</button>
                            </ul>
                        </form>
                    </div>
                </fieldset>
            </div>

            <script >


            </script >

            <ul>
                <div class="gbko">
                    <div class="changyan">
                    <!--PC版-->
                    <div id="SOHUCS">
                        <div id="SOHU_MAIN">
                        <div node-type="module-cmt-list" class="module-cmt-list section-list-w">
                            <!-- 评论列表  S -->
                            <!-- 最新评论 -->
                           <div class="list-block-gw list-newest-w">
                               <div node-type="cmt-list-title" class="block-title-gw">
                                   <ul class="clear-g">
                                       <li>
                                           <div class="title-name-gw title-name-bg">
                                               <div class="title-name-gw-tag"></div>最新评论（<?php echo $count; ?>）</div>
                                       </li>
                                   </ul>
                               </div>

                               <div node-type="cmt-list" >

                                   <?php if(is_array($comment) || $comment instanceof \think\Collection || $comment instanceof \think\Paginator): $i = 0; $__LIST__ = $comment;if( count($__LIST__)==0 ) : echo "暂时没有评论" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>

                                   <div class="clear-g block-cont-gw">
                                       <div class="cont-head-gw">
                                           <div class="head-img-gw">
                                               <a node-type="photo">
                                                   <div class="img-corner"></div>
                                                   <img src="<?php echo $v['image']; ?>" width="42" height="42">
                                               </a>
                                           </div>
                                       </div>
                                       <div class="cont-msg-gw">
                                           <div class="msg-wrap-gw">
                                               <div class="wrap-user-gw global-clear-spacing">
                                                   <span class="user-time-gw"><?php echo friend_time($v['create_time']); ?></span>
                                                   <span node-type="nickname" class="user-name-gw"><a><?php echo $v['users_name']; ?></a></span>
                                                   <span class="user-address-gw"> <a href="http://www.ip138.com/ips138.asp?ip=<?php echo $v['ip']; ?>&action=2" >[<?php echo $v['ip']; ?>]</a ></span>
                                               </div>

                                                <?php  $ping=comment_article($v['id']);if(!empty($ping)): ?>
                                               <div class="wrap-issue-gw">
                                                   <div class="docs-card">@<?php echo get_users_ById($ping['id']); ?> 的回复：<?php echo $ping['content']; ?></div>
                                                   <p class="issue-wrap-gw"><span class="wrap-word-gw" style="color: #0f89a9"><?php echo $v['content']; ?></span></p>
                                               </div>
                                               <?php else: ?>
                                               <div class="wrap-issue-gw">
                                                   <p class="issue-wrap-gw"><span class="wrap-word-gw" ><?php echo $v['content']; ?></span></p>
                                               </div>

                                               <?php endif; ?>


                                               <div node-type="btns-bar" class="clear-g wrap-action-gw">
                                                   <div node-type="action-click-gw" class="action-click-gw global-clear-spacing">
                                                       <i class="gap-gw"></i>
                                                       <span node-type="support" class="click-ding-gw">
                                                           <a href="JavaScript:" onclick="article_ping(this)" data-id="<?php echo $v['id']; ?>">
                                                               <i class="icon-gw icon-ding-bg"></i>
                                                               <em id="article_zan_<?php echo $v['id']; ?>" class="icon-name-bg"><?php echo $v['zan']; ?></em>
                                                           </a>
                                                       </span> <i class="gap-gw"></i>

                                                       <a onclick="replay_comment(this)" data-name="<?php echo $v['users_name']; ?>" data-id="<?php echo $v['id']; ?>" href="#tosaypl">回复</a>
                                                       <i class="gap-gw"></i>
                                                   </div>
                                               </div>
                                           </div>

                                       </div>
                                   </div>

                                   <?php endforeach; endif; else: echo "暂时没有评论" ;endif; ?>



                               </div>
                           </div>

                        </div>
                        </div>
                    </div>
                </div>
                </div>



                <!--分页-->
                <div style="margin: 30px 0;height:30px;text-align: center;line-height: 30px;" >
                    <?php echo $page; ?>
                </div>

            </ul>
        </div>
    </div>


    <!--
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/8/14-10:19
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: right.html
 *-->

<!--右侧-->
<div class="sidebar">

    <div class="zhuanti">
        <h2 class="hometitle">特别推荐</h2>
        <ul>

            <?php $__LIST__ = db('article')->where('status = 1  and is_recommend=1')->field('*')->limit('3')->order('id desc')->select();foreach ($__LIST__ as $key => $v) {?>
            <li> <i><img src="<?php echo $v['image_url']; ?>"></i>
                <p><?php echo title_str_cut($v['title'],"70"); ?> <span><a href="<?php echo $v['url']; ?>" target="_blank">阅读</a></span> </p>
            </li>
            <?php } ?>

        </ul>
    </div>


    <?php if(($nav_id!=0)): ?>
    <div class="tuijian">
        <h2 class="hometitle">相关文章</h2>
       <?php if(is_array($right_article) || $right_article instanceof \think\Collection || $right_article instanceof \think\Paginator): $i = 0; $__LIST__ = $right_article;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($key == '0'): ?>
        <ul class="tjpic">
            <i><img src="<?php echo $v['image_url']; ?>" alt="<?php echo $v['title']; ?>"></i>
            <p>
                <a href="<?php echo $v['url']; ?>" target="_blank"><?php echo title_str_cut($v['title'],"60"); ?></a>
            </p>
        </ul>
        <?php else: ?>

        <ul class="sidenews">
            <li> <i><img src="<?php echo $v['image_url']; ?>" alt="<?php echo $v['title']; ?>"></i>
                <p>
                    <a href="<?php echo $v['url']; ?>" target="_blank"><?php echo title_str_cut($v['title'],"75"); ?></a>
                </p>
                <span><?php echo friend_time($v['create_time']); ?></span>
            </li>
        </ul>
        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <?php endif; ?>

    <div class="guanzhu">
    <h2 class="hometitle">亿莲名片</h2>
    <ul>
        <li class="tencent"><a href="javascript:" target="_self"><span>QQ群号</span>292626152</a></li>
        <li class="qq"><a href="https://wpa.qq.com/msgrd?v=3&amp;uin=2998658517&amp;site=qq&amp;menu=yes" target="_self"><span>QQ号</span>2998658517</a></li>
        <li class="email"><a href="https://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&amp;email=jackhhy520@qq.com" target="_self"><span>邮箱帐号</span>2998658517@qq.com</a></li>
        <li class="wxgzh"><span>微信公众号</span>fxcxy</li>
        <li class="wx"><img src="/luckyblog/home//images/gzh.png" alt='公众号二维码'></li>
    </ul>
</div>



</div>
</div>

    <script >
        $(".news_con img").click(function () {
            layer.photos({
                photos: {
                    title: "图片详细",
                    data: [{
                        src: $(this).attr("src")
                    }]
                },
                shade: .01,
                closeBtn: 1,
                anim: 5
            })
        });
    </script >


</article>

    


<!--右侧区-->




<!--js区-->


<!--
 * @Created by Vscode: 
 * @Description: https://gitee.com/luckygyl/luckyAdmin
 * @Author: jackhhy520@qq.com
 * @Date: 2019-08-22 15:16:31
 * @LastEditTime: 2019-08-22 15:16:31
 * @LastEditors: jackhhy
 -->


<footer>
    <p><!--您的IP【<a href="http://www.ip138.com/ips138.asp?ip=<?php echo $IP; ?>&action=2" target="_blank"><?php echo $IP; ?></a >】-->&nbsp;
        今日访问量：【<?php echo $on_line_ip; ?>】
        <?php echo $setting['foot']; ?>
       &nbsp; <?php echo $setting['icp']; ?>
        <a href="<?php echo $domain; ?>/feedback/42.html" >留言板</a>
    </p>
</footer>
<a href="javascript:void" class="cd-top">Top</a>


<script >
    $("img").lazyload({
        placeholder: "/luckyblog/home/images/play.jpg",
        effect: "fadeIn",
        threshold: 200,
        skip_invisible: false
    });
</script >
<script src="/luckyblog/home/js/base.js"></script>


<script src="/luckyblog/home/js/footer.js"></script>

<script src="/luckyblog/home/js/snow.js"></script>
  
<!-- <script src="/luckyblog/home/js/bid.js"></script>-->
  

<script src="/luckyblog/home/js/canves.js" count="200" zindex="-2" opacity="0.8" color="47,135,193" type="text/javascript"></script>
<!-- 百度统计代码 -->
<script>
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?7c66ea3d5cb639556086c7d7d6c678f4";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>
    



</body>
</html>

