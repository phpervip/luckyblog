<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:77:"/Users/mac/data/tp/luckyblog/public/../application/index/view/page/index.html";i:1577199033;s:68:"/Users/mac/data/tp/luckyblog/application/index/view/public/base.html";i:1577193368;s:70:"/Users/mac/data/tp/luckyblog/application/index/view/public/header.html";i:1577193368;s:70:"/Users/mac/data/tp/luckyblog/application/index/view/public/footer.html";i:1577193368;}*/ ?>
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

    
<style type="text/css">@media only screen and (max-width: 1280px) {
    .bz_about  {
        margin: 0px 0;
        width: 95%;
        padding: 5px!important;
        color: #555;
        border-left: 4px solid #0cc;
    }
}

.gd_title {
    margin: 20px 0;
    font-size: 18px;
    background: url(../images/hline.png) no-repeat bottom right;
    width: 120px;
    background-size: 40px;
    border-bottom: #000 1px dashed;
    padding-left: 10px;
    padding-bottom: 5px;
    display: inline-block;
}
.gyw_intro {
    font-size: 14px;
}
.bz_about  {
    margin: 10px 0;
    width: 95%;
    padding: 10px 30px 10px 30px;
    color: #555;
    border-left: 4px solid #0cc;
}
.ly_button {
    float: right;
    width: 100px;
    background: #000;
    text-align: center;
    border-radius: 3px;
    line-height: 30px;
}
.ly_button a {
    color: #fff;
    text-decoration:none;
}
.bz_about .wb_url {
    margin: 0 20px;
}
.bz_about .wb_url a {
    color: #1ca368;
    text-decoration:none;
}
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
    <div class="container">
        <h1 class="t_nav">
            <span>Just Do it!</span>
            <a href="/" class="n1">网站首页</a><a href="javascript:" class="n2"><?php echo get_nav_name($nav_id); ?></a></h1>
        <div class="news_infos">
            <ul>
                <div>
                    <h2 class="gd_title">关于博客</h2>
                    <div class="gyw_intro">
                        <div class="bz_about">
                            ❀域名：<a href="<?php echo $domain; ?>" ><?php echo $domain; ?></a >。<br>
                            ❀服务器：<a href="https://www.aliyun.com/" target="_blank" >阿里云服务器</a >。<br>
                            ❀备案号：<a href="http://www.beian.miit.gov.cn" target="_blank">浙ICP备17019214号</a>。<br>
                            ❀开发语言：PHP-7.1。<br>
                            ❀框架：Thinkphp-5.0。<br>
                        </div>
                    </div>
                    <h2 class="gd_title">关于我</h2>
                    <div class="gyw_intro">
                        <h5>个人信息 | Information：</h5>
                        <div class="bz_about">昵称：亿莲<br>职业：程序媛<br>定居：中国·浙江·杭州<br>职业：PHP开发工程师</div>
                        <h5>个人简介 | Resume：</h5>
                        <div class="bz_about">
                            1、大学专业：金融数学类。
                            <br>2、五年PHP后端开发者。
                        </div>
                        <h5>个人技术 | Technology：</h5>
                        <div class="bz_about">
                            1、熟悉HTML、CSS、Javascript、AJAX、JSON等Web页面技术。<br>
                            2、熟悉LAMP、LNMP网站架构搭建。<br>
                            3、熟悉主流的ThinkPHP,Laraval等PHP框架。<br>
                            4、熟悉TPshop,ShopNC的二次开发。<br>
                            5、熟悉常用的第三方平台的接口开发。<br>
                            6、熟悉微信小程序的开发。<br>
                            7、具有良好的编码习惯和逻辑思维能力，抗压能力强。<br>
                            8、其他技术正在学习中！比如：Python。
                        </div>
                        <h5 id="project">个人项目&nbsp;| Projects：</h5>
                        <div class="bz_about"><span>项目名称、开发框架。</span><br>
                            1、净宗学院 网站后台 (后端采用TP框架)<span class="wb_url"><a href="http://new.jingzong.org" target="_blank">前往</a></span><br>
                            2、今现在说法 网站后台(后端采用TP框架)<span class="wb_url"><a href="http://hk.ciguang.tv" target="_blank">前往</a></span><br>
                            3、慈光讲堂 app 后台及api 接口(后端采用TP框架)<br>
                            4、慈光宝库 小程序 (后端采用TP框架) <span class="wb_url"></span>
                        </div>
                        <h5>个人爱好 | Hobbys：</h5>
                        <div class="bz_about">
                            1、纯素食者。<br>
                            2、喜欢编程。<br>
                            3、喜欢念经。<br>
                            4、喜欢锻炼。<br>
                        </div>
                    </div>
                </div>
            </ul>

        </div>
    </div>


    <!--右侧-->
    <div class="sidebar">

        <div class="about">
            <p class="avatar"> <img src="/luckyblog/home/images/my.jpg" id="logo1" alt="亿莲"> </p>
            <p class="abname">yyii | 亿莲</p>
            <p class="abposition">程序媛</p>
            <p class="abtext" style="text-indent: 2em ">
                从2019年12月24日起，博客已运行<span id="runtime_span">0天1小时0分31秒</span>，
                博客主要记录一些程序人生。希望大家能够关注，一起分享知识和经验。</p>
            <script type="text/javascript">
                function show_runtime(){
                    window.setTimeout("show_runtime()",1000);X=new
            Date("12/24/2019 10:30:00");
                Y=new Date();T=(Y.getTime()-X.getTime());M=24*60*60*1000;
                a=T/M;A=Math.floor(a);b=(a-A)*24;B=Math.floor(b);c=(b-B)*60;C=Math.floor((b-B)*60);D=Math.floor((c-C)*60);
                runtime_span.innerHTML=A+"天"+B+"小时"+C+"分"+D+"秒"
                }
                show_runtime();
            </script>
        </div>
          <div class="guanzhu" id="follow-us">
              <h2 class="hometitle">QQ关注，PHP技术问答群</h2>
              <ul>
                  <li class="wx"><img src="/luckyblog/home/images/qq.jpg"></li>
              </ul>
          </div>
        <div class="guanzhu" >
            <h2 class="hometitle">微信关注，佛系程序员的修行之路</h2>
            <ul>
                <li class="wx"><img src="/luckyblog/home/images/weixin.png"></li>
            </ul>
        </div>
    </div>
    </div>

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

