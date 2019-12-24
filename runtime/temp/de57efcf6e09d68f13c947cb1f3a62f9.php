<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:78:"/Users/mac/data/tp/luckyblog/public/../application/index/view/index/index.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/index/view/public/base.html";i:1577193368;s:70:"/Users/mac/data/tp/luckyblog/application/index/view/public/header.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/index/view/public/card.html";i:1577199717;s:70:"/Users/mac/data/tp/luckyblog/application/index/view/public/footer.html";i:1577193368;}*/ ?>
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
    <!--banner begin-->
    <div class="picsbox">
        <div class="banner">
            <div id="banner" class="fader">
                <?php if(is_array($bo) || $bo instanceof \think\Collection || $bo instanceof \think\Paginator): $i = 0; $__LIST__ = $bo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <li class="slide">
                    <a href="<?php echo $v['url']; ?>" target="_blank"><img src="<?php echo $v['image']; ?>" alt="<?php echo $v['title']; ?>" title="<?php echo $v['title']; ?>"><span class="imginfo"><?php echo $v['title']; ?></span></a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>

                <div class="fader_controls">
                    <div class="page prev" data-target="prev">&lsaquo;</div>
                    <div class="page next" data-target="next">&rsaquo;</div>
                    <ul class="pager_list">
                    </ul>
                </div>
            </div>
        </div>
        <!--banner end-->

        <div class="toppic">

            <?php if(is_array($top_article) || $top_article instanceof \think\Collection || $top_article instanceof \think\Paginator): $i = 0; $__LIST__ = $top_article;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <li>
                <a href="<?php echo $v['url']; ?>" target="_blank" title="<?php echo $v['title']; ?>"> <i>
                    <img data-original="<?php echo $v['image_url']; ?>" alt="<?php echo $v['title']; ?>">
                </i>
                    <h2><?php echo title_str_cut($v['title'],"80"); ?></h2>
                    <span><?php echo $v['n_title']; ?></span> </a>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>

        </div>

    </div>
    <div class="blank"></div>




    <!--blogsbox begin-->
    <div class="blogsbox">
        
        <?php if(!(empty($advice_pic) || (($advice_pic instanceof \think\Collection || $advice_pic instanceof \think\Paginator ) && $advice_pic->isEmpty()))): ?>
        <div class="pics">
       <ul>
        <?php $__LIST__ = db('advice')->where('status = 1  and type=1')->field('*')->limit('3')->order('create_time desc')->select();foreach ($__LIST__ as $key => $v) {?>
          <li><a href="<?php echo $v['url']; ?>" target="_blank"><img src="<?php echo $v['image']; ?>" alt="<?php echo $v['name']; ?>" ></a ><span><?php echo $v['name']; ?></span></li>
        <?php } ?>
      </ul>
        </div>
        <?php endif; if(!(empty($advice_zi) || (($advice_zi instanceof \think\Collection || $advice_zi instanceof \think\Paginator ) && $advice_zi->isEmpty()))): ?>
      	<ul id="blogtab">  
        <li class="current">站长广告位</li>

        <?php $__LIST__ = db('advice')->where('status = 1  and type=2')->field('*')->limit('8')->order('id desc')->select();foreach ($__LIST__ as $key => $v) {?>
        <li><a href="<?php echo $v['url']; ?>" target="_blank"  title="<?php echo $v['name']; ?>"><?php echo $v['content']; ?></a ></li>
        <?php } ?>
        </ul>
        <?php endif; ?>


        <!--文章内容-->
        <?php if(is_array($article_data) || $article_data instanceof \think\Collection || $article_data instanceof \think\Paginator): $i = 0; $__LIST__ = $article_data;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <div class="blogs" data-scroll-reveal="enter bottom over 1s">
            <h3 class="blogtitle">
                <a href="<?php echo $v['url']; ?>" target="_blank">
                   <?php if($v['is_top'] == '1'): ?> <font style="font-weight: bold;font-size: 1.07em;color: #3690cf;">【顶】</font> <?php endif; ?>
                    <font style="font-weight: bold;font-size: 1.07em"><?php echo $v['title']; ?></font>
            </a>
                <?php if($v['source'] == '原创'): ?>
                <span class="layui-badge layui-bg-blue" style="float: right;"><?php echo $v['source']; ?></span>
                <?php else: ?>
                <span class="layui-badge layui-bg-orange" style="float: right;"><?php echo $v['source']; ?></span>
                <?php endif; ?>
            </h3>

            <span class="blogpic"><a href="<?php echo $v['url']; ?>" title="<?php echo $v['title']; ?>">
                <img data-original="<?php echo $v['image_url']; ?>" alt="<?php echo $v['title']; ?>" title="<?php echo $v['title']; ?>"></a>
            </span>

            <p class="blogtext">
              <?php echo $v['description']; ?>
            </p>
            <div class="bloginfo">
                <ul>
                    <li class="author">
                        <a href="javascript:void"><?php echo $v['author']; ?></a>
                    </li>
                    <li class="lmname">
                        <a href="javascript:"><?php echo $v['n_title']; ?></a>
                    </li>
                    <li class="timer"><?php echo friend_time($v['create_time']); ?></li>
                    <li class="view"><span><?php echo $v['hits']; ?></span>次阅读</li>
                    <li class="like"><?php echo $v['zan']; ?></li>

                </ul>
            </div>
        </div>
        <?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
        <!--文章内容结束-->

        <!--分页-->
        <div style="margin: 30px 0;height:30px;text-align: center;line-height: 30px;">
            <?php echo $page; ?>
        </div>


    </div>
    <!--blogsbox end-->
    <!--内容区-->
    



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

        <div class="tuijian">
            <h2 class="hometitle">点击排行</h2>

            <?php $__LIST__ = db('article')->where('status = 1 ')->field('*')->limit('5')->order('hits DESC,create_time DESC')->select();foreach ($__LIST__ as $key => $v) {if($key == '0'): ?>
            <ul class="tjpic">
                <i><img data-original="<?php echo $v['image_url']; ?>" alt="<?php echo $v['title']; ?>"></i>
                <p>
                    <a href="<?php echo $v['url']; ?>" target="_blank"><?php echo title_str_cut($v['title'],"60"); ?></a>
                </p>
            </ul>
            <?php else: ?>

            <ul class="sidenews">
                <li> <i><img data-original="<?php echo $v['image_url']; ?>" alt="<?php echo $v['title']; ?>"></i>
                    <p>
                        <a href="<?php echo $v['url']; ?>" target="_blank"><?php echo title_str_cut($v['title'],"75"); ?></a>
                    </p>
                    <span><?php echo friend_time($v['create_time']); ?></span>
                </li>
            </ul>
            <?php endif; } ?>




        </div>

        <div class="cloud" >
            <h2 class="hometitle">标签云</h2>
            <ul >
                <?php if(is_array($tags) || $tags instanceof \think\Collection || $tags instanceof \think\Paginator): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?>
                <a href="/tags.html?tag=<?php echo $t; ?>" target="_blank" ><?php echo $t; ?></a>
                <?php endforeach; endif; else: echo "" ;endif; ?>

            </ul>
        </div>
        <div class="links">
            <h2 class="hometitle">友情链接</h2>
            <ul>
                <?php $__LIST__ = db('friendlink')->where('status=1 and type=1')->field('*')->limit('15')->order('create_time DESC')->select();foreach ($__LIST__ as $key => $v) {?>
                <li>
                    <a href="<?php echo $v['href']; ?>?from=www.jackhhy.cn" target="_blank"><?php echo $v['name']; ?></a>
                </li>
                <?php } ?>
            </ul>
        </div>


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
</article>
<div class="clearfix"></div>

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

