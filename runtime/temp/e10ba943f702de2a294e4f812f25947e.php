<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/index/home.html";i:1577193368;}*/ ?>
<html >
<head >
    <meta charset="utf-8" >
    <title ></title >
    <meta name="renderer" content="webkit" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" >
    <link rel="stylesheet" href="/luckyblog/plug/layui/css/layui.css" media="all">
    <script type="text/javascript" src="/luckyblog/admin/js/jquery.min.js"></script>
    <link rel="stylesheet" href="/luckyblog/admin/css/home_1.css" media="all">
    <link rel="stylesheet" href="/luckyblog/admin/css/layui-admin.css" media="all">
    <link id="layuicss-layer" rel="stylesheet" href="https://www.layui.com/admin/std/dist/layuiadmin/layui/css/modules/layer/default/layer.css?v=3.1.1" media="all" >
    <script type="text/javascript" src="/luckyblog/admin/js/echarts.min.js"></script>
</head >
<body >

<div class="layui-fluid" >


    <div class="layui-row layui-col-space15" >
        <div class="layui-col-sm6 layui-col-md3" >
            <div class="layui-card" >
                <div class="layui-card-header" >
                    文章总数量
                    <span class="layui-badge layui-bg-blue layuiadmin-badge" >篇</span >
                </div >
                <div class="layui-card-body layuiadmin-card-list" >
                    <p class="layuiadmin-big-font" ><?php echo $article_num; ?></p >
                </div >
            </div >
        </div >
        <div class="layui-col-sm6 layui-col-md3" >
            <div class="layui-card" >
                <div class="layui-card-header" >
                    用户总数
                    <span class="layui-badge layui-bg-cyan layuiadmin-badge" >个</span >
                </div >
                <div class="layui-card-body layuiadmin-card-list" >
                    <p class="layuiadmin-big-font" ><?php echo $users_num; ?></p >
                </div >
            </div >
        </div >
        <div class="layui-col-sm6 layui-col-md3" >
            <div class="layui-card" >
                <div class="layui-card-header" >
                    留言总数
                    <span class="layui-badge layui-bg-green layuiadmin-badge" >条</span >
                </div >
                <div class="layui-card-body layuiadmin-card-list" >

                    <p class="layuiadmin-big-font" ><?php echo $feedback_num; ?></p >

                </div >
            </div >
        </div >
        <div class="layui-col-sm6 layui-col-md3" >
            <div class="layui-card" >
                <div class="layui-card-header" >
                    名言名句
                    <span class="layui-badge layui-bg-orange layuiadmin-badge" >条</span >
                </div >
                <div class="layui-card-body layuiadmin-card-list" >
                    <p class="layuiadmin-big-font" ><?php echo $yuju_num; ?></p >
                </div >
            </div >
        </div >

    </div >


    <div class="layui-row layui-col-space15">



        <!--待办事项-->
        <div class="layui-col-sm6 layui-col-md4">
            <div class="layui-card">
                <div class="layui-card-header">待办事项</div>
                <div class="layui-card-body">

                    <div class="layui-carousel layadmin-carousel layadmin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 230px;">
                        <div carousel-item="">
                            <ul class="layui-row layui-col-space10 layui-this">
                                <li class="layui-col-xs6">
                                    <a  class="layadmin-backlog-body" lay-id="p-1" href="javascript:;" data-url="<?php echo url('setting/myinfo'); ?>">
                                        <h3>待审评论</h3>
                                        <p><cite><?php echo $shen_ping; ?></cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs6">
                                    <a  class="layadmin-backlog-body">
                                        <h3>待审留言</h3>
                                        <p><cite><?php echo $shen_feedback; ?></cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs6">
                                    <a  class="layadmin-backlog-body">
                                        <h3>采集数据（条）</h3>
                                        <p><cite><?php echo $duan_num; ?></cite></p>
                                    </a>
                                </li>
                                <li class="layui-col-xs6">
                                    <a  class="layadmin-backlog-body">
                                        <h3>待发布文章</h3>
                                        <p><cite><?php echo $shen_article; ?></cite></p>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--作者语录-->
        <div class="layui-col-sm6 layui-col-md4">

            <div class="layui-card">
                <div class="layui-card-header">
                    作者心语
                    <i class="layui-icon layui-icon-tips" lay-tips="要支持的噢" lay-offset="5"></i>
                </div>
                <div class="layui-card-body layui-text layadmin-text">
                    <p>感谢一路走来有你的陪伴，在未来的道路上，我会更加努力，争取把最好的东西呈献给最可爱的你们。</p>
                    <p>请尊重LuckyAdmin开发者的劳动成果，请别将该源码上传到任何的素材网站进行售卖！一经发现将追究责任！</p>
                    <p>—— LuckyAdmin（<a href="http://www.luckyhhy.cn/" target="_blank">luckyhhy.cn</a>）</p>
                </div>
            </div>


        </div>

        <!--版本信息-->
        <div class="layui-col-sm6 layui-col-md4">
            <div class="layui-card">
                <div class="layui-card-header">版本信息</div>
                <div class="layui-card-body layui-text">
                    <table class="layui-table">
                        <colgroup>
                            <col width="100">
                            <col>
                        </colgroup>
                        <tbody>
                        <tr>
                            <td>当前版本</td>
                            <td>
                                <?php echo $Lucky_Name; ?>_<?php echo $Version; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>基于框架</td>
                            <td>
                                <a href="https://www.layui.com/" target="_blank">layui-2.5.4</a > + <a href="http://www.thinkphp.cn/"  target="_blank">Thinkphp<?php echo THINK_VERSION; ?></a >
                            </td>
                        </tr>
                        <tr>
                            <td>运行环境</td>
                            <td>
                               <p><?php echo php_uname('s');  ?>&nbsp;<?php echo 'PHP'.phpversion();?>&nbsp;<?php echo function_exists('apache_get_version')?apache_get_version():$_SERVER["SERVER_SOFTWARE"];  ?>
                                Mysql: <?php echo function_exists('mysqli_get_server_info') ? mysqli_get_server_info(mysqli_connect(config("database.hostname"),config("database.username"),config("database.password"))) : '';?>
                               </p>
                            </td>
                        </tr>
                        <tr>
                            <td>Gitee地址</td>
                            <td><p><a href="http://www.luckyhhy.cn">
                                <img src="https://gitee.com/luckygyl/LuckyAdmin/badge/star.svg?theme=dark" alt="star"
                                ></a>
                                <a href="http://www.luckyhhy.cn">
                                    <img src="https://gitee.com/luckygyl/LuckyAdmin/badge/fork.svg?theme=dark" alt="fork">
                                </a></p></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>



    <div class="layui-row layui-col-space15">

        <!--用户留言-->
        <div class="layui-col-sm6 layui-col-md5" >
            <div class="layui-card" >
                <div class="layui-card-header" >最新用户留言</div >
                <div class="layui-card-body" >
                    <ul class="layuiadmin-card-status layuiadmin-home2-usernote" >

                        <?php $__LIST__ = db('feedback')->where('pid=0')->field('*')->limit('5')->order('create_time desc')->select();foreach ($__LIST__ as $key => $v) {?>
                        <li >
                            <h3 ><?php echo $v['username']; ?></h3 >
                            <p ><?php echo $v['content']; ?></p >
                            <span ><?php echo $v['time_formt']; ?></span >
                        </li >
                        <?php } ?>

                    </ul >
                </div >
            </div >
        </div >



        <!--本周活跃用户列表-->
        <div class="layui-col-sm6 layui-col-md7" >
            <div class="layui-card" >
                <div class="layui-card-header" >本周最新用户列表</div >
                <div class="layui-card-body" >
                    <table class="layui-table layuiadmin-page-table" lay-skin="line" >
                        <thead >
                        <tr >
                            <th >头像</th >
                            <th >QQ</th >
                            <th >用户名</th >
                            <th >登录时间</th >

                        </tr >
                        </thead >
                        <tbody >
                        <?php $__LIST__ = db('users')->where('status=1')->field('*')->limit('8')->order('create_time desc')->select();foreach ($__LIST__ as $key => $v) {?>
                        <tr >
                            <td >
                                <img src="<?php echo $v['image']; ?>" alt=""  class="layui-nav-img">
                            </td >
                            <td ><span class="first" ><?php echo $v['qq']; ?></span ></td >
                            <td >
                                <?php echo $v['username']; ?>
                            </td >
                            <td ><span ><?php echo $v['time_formt']; ?></span ></td >

                        </tr >
                        <?php } ?>

                        </tbody >
                    </table >
                </div >
            </div >
        </div >


    </div>




    <div class="layui-row layui-col-space15">

        <div class="layui-col-sm6 layui-col-md7" >
        <div class="layui-card">
            <div class="layui-card-header">
                最新网站访问量
            </div>
            <div class="layui-card-body">
                <div class="flot-chart" style="height:350px; ">
                    <div class="flot-chart-content" id="table7" style="height:350px;">
                        <script type="text/javascript">
                            // 基于准备好的dom，初始化echarts实例
                            var myChart = echarts.init(document.getElementById('table7'));
                            var colors = ['#39aef5','#ed5565'];
                            // 指定图表的配置项和数据
                            option = {
                                title : {
                                    //  text: '后勤与系统维护次数统计',
                                    subtext: '此表仅统计本年的数据！'
                                },
                                tooltip : {
                                    trigger: 'axis'
                                },
                                legend: {
                                    data:['每月访问量']
                                },
                                toolbox: {
                                    show : true,
                                    feature : {
                                        mark : {show: true},
                                        dataView : {show: true, readOnly: false},
                                        magicType : {show: true, type: ['line', 'bar']},
                                        restore : {show: true},
                                        saveAsImage : {show: true}
                                    }
                                },
                                calculable : true,
                                xAxis : [
                                    {
                                        type : 'category',
                                        data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                                    }
                                ],
                                yAxis : [
                                    {
                                        type : 'value',
                                        axisLabel : {
                                            formatter: '{value} 个'
                                        }
                                    }
                                ],
                                series : [
                                    {
                                        name:'每月访问量',
                                        type:'bar',
                                        data:<?php echo $tongji; ?>,
                                        markPoint : {
                                            data : [
                                                {type : 'max', name: '最高'},
                                                {type : 'min', name: '最低'}
                                            ]
                                        },
                                        markLine : {
                                            data : [
                                                {type : 'average', name: '平均'}
                                            ]
                                        }
                                    },

                                ]
                            };
                            // 使用刚指定的配置项和数据显示图表。
                            myChart.setOption(option);
                        </script>
                    </div>
                </div>

            </div>
        </div>
        </div>


        <div class="layui-col-sm6 layui-col-md5" >
            <div class="layui-card">
                <div class="layui-card-header">最新操作登录日志：
                </div>
                <div class="layui-card-body">
                    <table class="layui-table layuiadmin-page-table" lay-skin="line">
                        <thead>
                        <tr style="text-align: center;">
                            <th>管理员名称</th>
                            <th>描述</th>
                            <th>IP地址</th>
                            <th>操作时间</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if(is_array($log) || $log instanceof \think\Collection || $log instanceof \think\Paginator): $i = 0; $__LIST__ = $log;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>

                        <tr >
                            <td class="b_font">
                                <?php echo $v['admin_name']; ?>
                            </td>
                            <td class="b_font">
                                <?php if($v['type'] == '1'): ?>
                                登录操作
                                <?php else: ?>
                                <?php echo $v['describe']; endif; ?>

                            </td>
                            <td class="b_font">
                                <a href="http://www.ip138.com/ips138.asp?ip=<?php echo $v['ip']; ?>&action=2" target="_blank" title="点击查看IP所属地址" ><?php echo $v['ip']; ?></a >
                            </td>
                            <td class="b_font">
                                <?php echo $v['time_formt']; ?>
                            </td>

                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>


                        </tbody>
                    </table>

                </div>
            </div>

        </div>



    </div>










    </div>

</div >


<script src="/luckyblog/plug/layui/layui.js" ></script >




</body >
</html >