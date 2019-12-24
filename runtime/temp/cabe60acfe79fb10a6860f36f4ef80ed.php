<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:80:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/comment/index.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/admin/view/public/base.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/admin/view/public/head.html";i:1577199998;s:66:"/Users/mac/data/tp/luckyblog/application/admin/view/public/js.html";i:1577193368;s:70:"/Users/mac/data/tp/luckyblog/application/admin/view/public/footer.html";i:1577193368;}*/ ?>

<!-- 引入头部 -->
<!--
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/7/30-15:47
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: head.html
 *-->


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="LuckyAmin">
    <title>亿莲博客-后台管理</title>
    <link rel="stylesheet" href="/luckyblog/plug/layui/css/layui.css">
    <link rel="stylesheet" href="/luckyblog/admin/css/admin.css?v=312">
    <link rel="stylesheet" href="/luckyblog/admin/css/sub-page.css">
    <script src="/luckyblog/admin/js/jquery.min.js"></script>
    <link href="/luckyblog/admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link rel="stylesheet" href="/luckyblog/admin/css/animate.min.css" media="all"/>

    <script src="/luckyblog/plug/layui/layui.js"></script>
    <!--bootstrap-->
   <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>-->

    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script >
        var local_url="/luckyblog/admin/js/";
    </script >

</head>

<body>



   <!--样式区-->




<!-- 主体部分开始 -->
<div class="layui-fluid">

    <div class="layui-row layui-col-space10">

        <div class="layui-col-md12">

            <div class="layui-card">
                <div class="layui-card-body layui-row ">
                    <form action="" class="layui-form" method="get" >
                        <div class="layui-form-item">

                            

<?php echo widget('forms/search',array('title','文章搜索','请输入标题')); ?>



                            <div class="layui-inline" style="padding-left: 20px;">
                                <button class="layui-btn icon-btn" lay-filter="search" lay-submit="">
                                    <i class="layui-icon"></i>搜索
                                </button>
                                <button class="layui-btn icon-btn layui-btn-normal"  onclick="javascript:window.location.reload();" >
                                    <i class="layui-icon layui-icon-refresh"></i> 重置
                                </button>
                            </div>

                        </div>

                    </form >
                </div>

            </div>



            <div class="layui-card">
                <div class="layui-card-header" style="line-height: 55px;">
                    <div class="layui-btn-container do_btn">
                        
<!--按钮区-->
<?php echo widget('forms/Delbtn',array('删除')); ?>

<?php echo widget('forms/reload'); ?>

<button class="layui-btn layui-btn-sm layui-btn-warm"   data-type="check"> <i class="layui-icon layui-icon-spread-left"></i>批量审核</button>


                    </div>
                </div>
                <div class="layui-card-body">

                     <!--表格区-->

<?php echo widget('forms/table'); ?>



                </div>
            </div>


        </div>
    </div>
</div>

<!-- 主体部分结束 -->

<!--
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/6/27-15:15
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: js.html
 *-->

<!--js逻辑-->
<script src="/luckyblog/admin/js/jquery.min.js"></script>
<script src="/luckyblog/admin/nprogress/nprogress.js"></script>

<script src="/luckyblog/admin/js/base.js"></script>

<script type="text/javascript">
    NProgress.start();
    window.onload = function () {
        NProgress.done();
    };

    /**
     *菜单提示
     */
   function tis(obj) {
        var row=$(obj).attr("data-title"); //获取显示内容
        //小tips
        layer.tips(row,obj,{
            tips:[1,"black"],
            time:1000
        })

    }

</script>


 <!--js处理区-->


<!--模板-->
<script type="text/html" id="operationTpl">
    <?php echo widget('forms/Delbtn',array('删除评论',2)); ?>
</script>


<script type="text/html" id="status">
    <input type="checkbox" name="status"  lay-data="{{d.status}}" value="{{d.id}}"  lay-filter="sexDemo" lay-skin="switch"  lay-text="已审核|未审核"  {{ d.status == 1 ? 'checked' : '' }}>
</script>


<script>

    layui.use(['element', 'table', 'form', 'jquery','lucky','soulTable'], function () {
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;
        var $ = layui.jquery;
        var lucky=layui.lucky;
        var  soulTable = layui.soulTable;

        form.render();

        // layer.load(2);
        table.render({
            elem: '#tableFilter',
            url:"<?php echo url('comment/index'); ?>",
            //toolbar: '#toolbarDemo',
            even: true, //开启隔行背景
            id:'table_id',
            page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip','last'] //自定义分页布局
                //,curr: 5 //设定初始在第 5 页
                ,groups: 5 //只显示 1 个连续页码
                ,first: false //不显示首页
                ,last: false //不显示尾页
                ,limit:15
                ,limits:[15,30,40,60,80,100]
            },
            height: $(document).height() - $('#tableFilter').offset().top - 20,
            text: {
                none: '暂无相关数据'
            },
            cols: [[
                {type: 'checkbox'},
                // {field: 'id',  title: 'ID',width:60},
                {field: 'title_show',filter: true,style:'cursor: pointer;',title: '用户名',minWidth: 120},
                {field: 'article_title',style:'cursor: pointer;',title: '文章名称',width: 220},
                {field: 'content',style:'cursor: pointer;',title: '评论内容',minWidth: 300},
                {field: 'zan',style:'cursor: pointer;',title: '点赞数量',width: 120,sort:true},
                {field: 'status',style:'cursor: pointer;',title: '状态',width: 120,templet:"#status"},
                {field: 'ip',style:'cursor: pointer;',title: 'IP',width: 140},
                {field: 'browse',style:'cursor: pointer;',title: '浏览器',width: 150},
                {field: 'time_formt', title: '评论时间',align: 'center',width:180},
                {templet: '#operationTpl', width: 100, align: 'center', title: '操作'}
            ]],
            filter: {
                items:['column','data','condition','editCondition','excel'] //用于控制表头下拉显示，可以控制顺序、显示
                ,bottom: true // 是否显示底部筛选区域，默认为true
            },
            done: function (res) {
               soulTable.render(this);
                layer.closeAll('loading');
                hoverOpenImg();
            }
        });


        /**
         * 鼠标悬浮显示大图
         *
         */
        function hoverOpenImg(){
            var img_show = null; // tips提示
            $('td img').hover(function(){
                var img = "<img class='img_msg' src='"+$(this).attr('src')+"' style='width:100%;max-height: 600px;' />";
                img_show = layer.tips(img, this,{
                    tips:[2, 'rgba(41,41,41,.0)']
                    ,area: ['12%']
                });
            },function(){
                layer.close(img_show);
            });
        }


        /**
         * 监听是否显示操作
         */
        form.on('switch(sexDemo)', function(obj){
            var _id=parseInt(obj.value);
            var pan=obj.elem.checked;
            var status;
            if (pan===false){
                status=2;
            }else {
                status=1;
            }
            lucky.Change_status("table_id","comment",_id,"status",status, obj.othis);
        });

        /**
         * 表格搜索
         */
        form.on('submit(search)', function (obj) {
            lucky.CreateSearch("table_id",obj.field); //查询
            return false;
        });



        /**
         * 监听单行工具操作
         */
        table.on('tool(tableFilter)', function (obj) {
            var data = obj.data;
            // console.log(JSON.stringify(data));
            var _id=parseInt(data.id);
            var layEvent = obj.event;

            if(layEvent==="del"){
                lucky.Delete_data(_id,"<?php echo url('comment/delete'); ?>","table_id");
            }
            else {
                layer.msg("功能待开发",{time:1500});return false;
            }

        });


        var active = {
            del: function(){ //获取选中数据
                var checkStatus = table.checkStatus('table_id'),data = checkStatus.data;
                var num=0;
                var id=[];
                for (var i in data) {
                    num++;
                    id.push(data[i].id);
                }
                if (num<1) {
                    layer.msg("请选择一项",{time:1500});return false;
                }
                lucky.Delete_data(id,"<?php echo url('comment/delete'); ?>","table_id");
            },
            reload: function(){
                lucky.CreateReload("table_id");
            },
            check:function () {
                var checkStatus = table.checkStatus('table_id'),data = checkStatus.data;
                var num=0;
                var id=[];
                for (var i in data) {
                    num++;
                    id.push(data[i].id);
                }
                if (num<1) {
                    layer.msg("请选择一项",{time:1500});return false;
                }
                var ids = id.join(',');

                layer.confirm("确定批量审核通过？", function(index){
                    layer.close(index);
                    $.ajax({
                        beforeSend:function(){
                            layer.load(2);
                        },
                        url: "<?php echo url('comment/check_ok'); ?>",
                        type: "POST",
                        async: true,
                        dataType: "json",
                        data:{
                            ids: ids,
                        },
                        error: function(error) {
                            layer.msg("服务器错误或超时");
                            return false;
                        },
                        success: function(data) {
                            if (data.code==1) {
                                layer.msg(data.msg,{icon:1,time:1500,shade:0.3,anim:4});
                                setTimeout(function(){
                                    lucky.CreateReload("table_id");
                                    //重载表格数据
                                },500);
                            }else{
                                layer.msg(data.msg,{icon:15,time:1500,shade:0.3},function () {
                                    lucky.CreateReload("table_id");
                                });
                            }
                        },
                        complete:function(){
                            layer.closeAll('loading');
                        }
                    });
                });

            }

        };

        $('.do_btn .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });



    });

</script >






<!-- 引入脚部 -->

</body>
</html>