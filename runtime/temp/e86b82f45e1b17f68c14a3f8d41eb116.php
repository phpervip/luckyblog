<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:78:"/Users/mac/data/tp/luckyblog/public/../application/index/view/album/lists.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/index/view/public/base.html";i:1577193368;s:70:"/Users/mac/data/tp/luckyblog/application/index/view/public/header.html";i:1577193368;s:70:"/Users/mac/data/tp/luckyblog/application/index/view/public/footer.html";i:1577193368;}*/ ?>
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

    
    <!--样式区-->
    
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
<!--<div class="pagebg"> <img src="https://www.mochoublog.com/d/file/p/2018/pagebgpic/study.jpg"> </div>-->
<div class="container">
    <h1 class="t_nav">
        <?php echo brand_nav($nav_id); ?>
        <a href="/" class="n1">网站首页</a><a href="javascript:" class="n2"><?php echo get_nav_name($nav_id); ?></a>
    </h1>
    <div class="fly-main" style="overflow: hidden;">
        <ul class="fly-case-list">
            <?php if(is_array($datas) || $datas instanceof \think\Collection || $datas instanceof \think\Paginator): $i = 0; $__LIST__ = $datas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <li data-id="123">
                <a class="fly-case-img" href="javascript:" data-open="<?php echo $v['is_open']; ?>" data-id="<?php echo $v['id']; ?>"  onclick="view_album(this)" >
                    <img data-original="<?php echo $v['img']; ?>" alt="<?php echo $v['name']; ?>">
                    <cite class="layui-btn layui-btn-primary layui-btn-small">查相册</cite>
                </a>
                <h2><a href="javascript:" data-open="<?php echo $v['is_open']; ?>" data-id="<?php echo $v['id']; ?>"  onclick="view_album(this)" ><?php echo $v['name']; ?></a></h2>
                <p class="fly-case-desc">
                    <?php echo $v['describe']; ?>
                </p>

                <div class="fly-case-info">
                    <a href="javascript:" class="fly-case-user">
                        <img data-original="/luckyblog/home/images/avatar.jpg"></a>
                    <p class="layui-elip" style="font-size: 12px;"><?php echo friend_time($v['create_time']); ?></p>
                    <p>
                        <a class="fly-case-nums fly-case-active " href="javascript:;" style=" padding:0 5px; color: #01AAED;">
                            <font class="zan_<?php echo $v['id']; ?>"><?php echo $v['hits']; ?></font></a>个赞
                        <a class="fly-case-nums fly-case-active" href="javascript:;"  style=" padding:0 5px; color: #01AAED;"><?php echo $v['nums']; ?></a>张图
                    </p>
                    <button class="layui-btn layui-btn-primary fly-case-active album_zan" data-id="<?php echo $v['id']; ?>">点赞</button>
                </div>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>

        </ul>

    </div>

    <!--分页-->
    <div style="margin: 30px 0;height:30px;text-align: center;line-height: 30px;">
        <?php echo $page; ?>
    </div>


</div>

<div class="clearfix"></div>

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

