<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:80:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/article/index.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/admin/view/public/base.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/admin/view/public/head.html";i:1577199998;s:66:"/Users/mac/data/tp/luckyblog/application/admin/view/public/js.html";i:1577193368;s:70:"/Users/mac/data/tp/luckyblog/application/admin/view/public/footer.html";i:1577193368;}*/ ?>

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

                            

<?php echo widget('forms/search',array('title','文章搜索','请输入文章标题')); ?>

<div class="layui-inline">
    <label class="layui-form-label">文章栏目·：</label>
    <div class="layui-input-inline">

        <?php echo widget('forms/singleSelect',array('navigate_id|2|栏目|title|id',$navigate,'')); ?>

    </div>
</div>



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
<?php echo widget('forms/Addbtn',array('新增文章',1,'add')); ?>
<?php echo widget('forms/reload'); ?>
<button class="layui-btn layui-btn-sm layui-btn-warm"   data-type="move"> <i class="layui-icon layui-icon-spread-left"></i>移动文章</button>
<button class="layui-btn layui-btn-normal layui-btn-sm"  onmouseover="tis(this)" lay-submit="" lay-filter="export" data-title="导出表格全部数据">
    <i class="fa fa-tags"></i> 导出数据
</button>

<button class="layui-btn layui-btn-sm layui-btn-danger"   data-type="out"> <i class="layui-icon layui-icon-spread-left"></i>导出测试</button>


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


<style type="text/css">
    .layui-table-cell{
        text-align:center;
        height: auto;
        white-space: normal;
    }
    .layui-table img{
        max-width:300px;
        max-height: 50px;
    }
</style>

<!--模板-->
<script type="text/html" id="operationTpl">
    <?php echo widget('forms/Editbtn',array('编辑文章')); ?>
    <a href="javascript:;"   class="layui-btn layui-btn-warm layui-btn-xs "  onmouseover="tis(this)"  data-title="下架文章" lay-event="down"><i class="layui-icon layui-icon-download-circle"></i></a>
    <?php echo widget('forms/Delbtn',array('删除文章',2)); ?>
</script>


<script type="text/html" id="is_top">
    <input type="checkbox" name="is_top"  lay-data="{{d.is_top}}" value="{{d.id}}"  lay-filter="sexDemo" lay-skin="switch"  lay-text="是|否"  {{ d.is_top == 1 ? 'checked' : '' }}>
</script>

<script type="text/html" id="recomend">
    <input type="checkbox" name="is_recommend"  lay-data="{{d.is_recommend}}" value="{{d.id}}"  lay-filter="recomend" lay-skin="switch"  lay-text="是|否"  {{ d.is_recommend == 1 ? 'checked' : '' }}>
</script>



<script>
    layui.use(['element', 'table', 'form', 'jquery', 'laydate','lucky','soulTable'], function () {
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;
        var $ = layui.jquery;
        var laydate = layui.laydate;
        var lucky=layui.lucky;
        var  soulTable = layui.soulTable;

        form.render();

        //layer.load(2);
        var myTable=table.render({
            elem: '#tableFilter',
            url:"<?php echo url('article/index'); ?>",
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
            height: $(document).height() - $('#tableFilter').offset().top - 20
            ,
            text: {
                none: '暂无相关数据'
            },
            cols: [[
                {type: 'checkbox'},
                // {field: 'id',  title: 'ID',width:60},
                {field: 'image_url', title: '文章缩略图', style:'cursor: pointer;',width: 150, align: "center",templet:function (d) {
                        return '<div><img src="'+d.image_url+'"  layer-index="100" alt="无图" /></div>';
                    }},
                {field: 'title', minWidth: 200, title: '文章标题',templet:function (d) {
                        return '<a target="_blank" href="'+d.url+'"  title="点击查看原文信息" >'+d.title+'</a>';
                    }},
                {field: 'navigate_title',style:'cursor: pointer;',title: '所属栏目',filter: true,width: 120},
                //{field: 'description',style:'cursor: pointer;',title: '文章摘要',width: 200},
                {field: 'source',style:'cursor: pointer;',title: '文章类型',filter: true,width: 120},
                {field: 'is_recommend',style:'cursor: pointer;',title: '推荐',filter: true,width: 100,templet:"#recomend"},
                {field: 'author',style:'cursor: pointer;',title: '作者',width: 100},
                {field: 'status',style:'cursor: pointer;',title: '状态',filter: true,width: 85,templet:function (d) {
                        var s="";
                        if (d.status==1){
                            s='<font color="green">正常</font>';
                        } else if(d.status==2){
                            s='<font color="color">下架</font>';
                        }else {
                            s='<font color="orange">草稿</font>';
                        }
                        return s;
                    }},
                {field: 'hits',style:'cursor: pointer;',title: '点击量',width: 100,sort:true},
                {field: 'is_top',style:'cursor: pointer;',title: '置顶',width: 100,templet:"#is_top"},
                {field: 'comment_nums',style:'cursor: pointer;',title: '评论数',width: 100,sort:true},
                {field: 'time_formt', title: '发布时间',align: 'center',width:160},
                { width:138, align:'center',templet: '#operationTpl',title: '操作'}
            ]],
            filter: {
                items:['column','data','condition','editCondition','excel'] //用于控制表头下拉显示，可以控制顺序、显示
                ,bottom: true // 是否显示底部筛选区域，默认为true
            },

            done: function (res) {
                soulTable.render(this);
                //layer.closeAll('loading');
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
         * 表格搜索
         */
        form.on('submit(search)', function (obj) {
            lucky.CreateSearch("table_id",obj.field); //查询
            return false;
        });


        //导出数据
        form.on('submit(export)', function () {
            soulTable.export(myTable);
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
                lucky.Delete_data(_id,"<?php echo url('article/delete'); ?>","table_id");

            }else if(layEvent==="edit"){
                var urls="/admin/article/EditArticle/id/"+_id;
                lucky.CreateForm("编辑文章",'10%','10%',urls,"table_id",0,1);
            }else if(layEvent==="down"){
                layer.confirm("确定下架该文章？", function(index){
                    layer.close(index);
                    $.ajax({
                        beforeSend:function(){
                            layer.load(2);
                        },
                        url: "<?php echo url('article/down'); ?>",
                        type: "POST",
                        async: true,
                        dataType: "json",
                        data:{
                            id: _id,
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
            else {
                layer.msg("功能待开发",{time:1500});return false;
            }

        });


        /**
         * 是否置顶
         */
        form.on('switch(sexDemo)', function(obj){
            var _id=parseInt(obj.value);
            var pan=obj.elem.checked;
            var status;
            if (pan===false){
                status=0;
            }else {
                status=1;
            }
            lucky.Change_status("table_id","article",_id,"is_top",status, obj.othis);
        });


        /**
         * 是否推荐
         */
        form.on('switch(recomend)', function(obj){
            var _id=parseInt(obj.value);
            var pan=obj.elem.checked;
            var status;
            if (pan===false){
                status=0;
            }else {
                status=1;
            }
            lucky.Change_status("table_id","article",_id,"is_recommend",status, obj.othis);
        });

        var active = {
            add:function(){
                lucky.CreateForm("新增文章",'10%','10%',"<?php echo url('article/AddArticle'); ?>","table_id",0,1);
            },
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
                lucky.Delete_data(id,"<?php echo url('article/delete'); ?>","table_id");
            },
            reload: function(){
                lucky.CreateReload("table_id");
            },
            move:function () {
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

                layer.open({
                    title:"批量移动文章",
                    type: 1,
                    offset:'auto;',
                    area: ["250px", "50%"],
                    btn: ["确定","取消"],
                    skin:'layui-layer-molv',
                    shade: 0.5,
                    content: $('#model')//
                    ,yes: function(index){
                        $.ajax({
                            url:"<?php echo url('article/move_article'); ?>",
                            type:'post',
                            data:{ids:ids,navigate_id:parseInt($("#navigateid").val())},
                            error: function(error) {
                                layer.msg("服务器错误或超时");
                                return false;
                            },
                            beforeSend:function(){
                                layer.load(2);
                            },
                            success:function(data)
                            {
                                if (data.code==1) {
                                    layer.msg(data.msg,{icon: 1, time: 1500,shade:0.3, anim: 4},function () {
                                        layer.close(index);
                                    });
                                }else{
                                    layer.msg(data.msg,{icon:15,time:1500,shade:0.3,anim:4});
                                }
                            },
                            complete:function(){
                                layer.closeAll('loading');
                            }
                        });
                    }
                    ,btn2: function(index, layero){
                        layer.close(index);
                    },
                    success:function () {
                        form.render("select");
                    },
                    end:function () {
                        lucky.CreateReload("table_id");
                    }
                });
            },
            out:function () {
                window.location.href="<?php echo url('article/test'); ?>";

                  return false;
            }

        };

        $('.do_btn .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });



    });

</script >



<div class="layui-fluid" style="display: none;" id="model">
    <div class="layui-row layui-form" >
        <?php echo widget('forms/singleSelect',array('navigateid|1|栏目|title|id',$navigate,'')); ?>
    </div>
</div>




<!-- 引入脚部 -->

</body>
</html>