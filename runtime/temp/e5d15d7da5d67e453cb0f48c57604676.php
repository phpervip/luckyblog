<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:81:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/navigate/index.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/admin/view/public/base.html";i:1577193368;s:68:"/Users/mac/data/tp/luckyblog/application/admin/view/public/head.html";i:1577199998;s:66:"/Users/mac/data/tp/luckyblog/application/admin/view/public/js.html";i:1577193368;s:70:"/Users/mac/data/tp/luckyblog/application/admin/view/public/footer.html";i:1577193368;}*/ ?>

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

                            

<?php echo widget('forms/search',array('title','栏目名称','请输入名称')); ?>



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
<?php echo widget('forms/Addbtn',array('新增栏目',1,'add_menu')); ?>
<?php echo widget('forms/reload'); ?>
<button class="layui-btn layui-btn-sm layui-btn-warm"   data-type="move"> <i class="layui-icon layui-icon-add-circle"></i>新增外部链接</button>

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

    {{# if (d.model_id != '7' ){ }}
    <?php echo widget('forms/Addbtn',array('新增子栏目',2,'add')); ?>
    {{# } }}

    {{# if (d.model_id != '7' ){ }}

    <?php echo widget('forms/Editbtn',array('编辑栏目')); ?>

    {{# }else{ }}

    <?php echo widget('forms/Editbtn',array('编辑','edit1')); ?>

    {{# } }}

    <?php echo widget('forms/Delbtn',array('删除栏目',2)); ?>


</script>

<script type="text/html" id="status">
    <input type="checkbox" name="status"  lay-data="{{d.status}}" value="{{d.id}}"  lay-filter="sexDemo" lay-skin="switch"  lay-text="是|否"  {{ d.status == 1 ? 'checked' : '' }}>
</script>


<script>

    layui.use(['element', 'table', 'form', 'jquery', 'laydate','lucky','tree'], function () {
        var element = layui.element;
        var form = layui.form;
        var table = layui.table;
        var $ = layui.jquery;
        var laydate = layui.laydate;
        var tree=layui.tree;
        var lucky=layui.lucky;

        form.render();


        String.prototype.format = function () {
            //字符串占位符
            //eg: var str1 = "hello {0}".format("world");
            if (arguments.length == 0) return this;
            var param = arguments[0];
            var s = this;
            if (typeof (param) == 'object') {
                for (var key in param) {
                    s = s.replace(new RegExp("\\{" + key + "\\}", "g"), param[key]);
                }
                return s;
            } else {
                for (var i = 0; i < arguments.length; i++) {
                    s = s.replace(new RegExp("\\{" + i + "\\}", "g"), arguments[i]);
                }
                return s;
            }
        };

        // layer.load(2);
        table.render({
            elem: '#tableFilter',
            url:"<?php echo url('navigate/index'); ?>",
            //toolbar: '#toolbarDemo',
            even: true, //开启隔行背景
            id:'table_id',
            page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                layout: ['limit', 'count', 'prev', 'page', 'next', 'skip','last'] //自定义分页布局
                //,curr: 5 //设定初始在第 5 页
                ,groups: 5 //只显示 1 个连续页码
                ,first: false //不显示首页
                ,last: false //不显示尾页
                ,limit:50
                ,limits:[50,60,70,80,90,100]
            },
            //height: 'full-100',
            text: {
                none: '暂无相关数据'
            },
            cols: [[
                {type: 'checkbox'},
                {field: 'id',  title: 'ID',width:60,sort:true},
                {field: 'title_show', minWidth: 200, title: '栏目名称'},
                {
                    field: 'icon', width: 150, align: 'center', templet: function (d) {
                        if (d.icon == "") {
                            return '';
                        } else {
                            var a= ('<i class="{0} {1} " ></i>').format(d.fontFamily,d.icon);
                            return a;
                        }
                    }, title: '栏目图标'
                },
                {field:'is_menu',title:'是否显示',templet: '#status',width:150 ,unresize: true,sort:true},
                {field: 'href',style:'cursor: pointer;',title: '栏目url',width:270,edit:"text"},
                {field: 'name',style:'cursor: pointer;',title: '栏目模型',width:110},
                {field: 'listorder',style:'cursor: pointer;',title: '排序',width:110,edit:'number',sort:true},

                {field: 'time_formt', title: '添加时间',align: 'center',width:200,sort:true},
                {fixed: 'right',templet: '#operationTpl', width: 230, align: 'center', title: '操作'}
            ]],

            done: function (res) {
                layer.closeAll('loading');
            }
        });

        /**
         * 表格搜索
         */
        form.on('submit(search)', function (obj) {
            lucky.CreateSearch("table_id",obj.field); //查询
            return false;
        });



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
            lucky.Change_status("table_id","navigate",_id,"status",status, obj.othis);
        });

        /**
         * 监听单元格编辑
         */
        table.on('edit(tableFilter)',function (obj) {
            var val=obj.value,_id=obj.data.id,field=obj.field;
            if (field=="href"){

            } else {
                var reg=/^[0-9]*$/;
                if (!reg.test(val)) {
                    layer.msg("排序必须是数字",{time:1000});
                    lucky.CreateReload("table_id");
                    return false;
                }
            }
            lucky.Change_status("table_id","navigate",_id,field,val);

        });


        /**
         * 监听单行工具操作
         */
        table.on('tool(tableFilter)', function (obj) {
            var data = obj.data;
            // console.log(JSON.stringify(data));
            var _id=parseInt(data.id);
            var layEvent = obj.event;
            if (layEvent==="add"){

                var url="/admin/navigate/AddNavigate/id/"+_id;
                lucky.CreateForm("添加子栏目",'50%','80%',url,"table_id");

            }else if(layEvent==="edit"){

                var urls="/admin/navigate/EditNavigate/id/"+_id;
                lucky.CreateForm("编辑栏目",'50%','80%',urls,"table_id");

            } else if(layEvent==="edit1"){

                var urls="/admin/navigate/EditLink/id/"+_id;
                lucky.CreateForm("编辑外部链接",'50%','80%',urls,"table_id");

            }
            else if(layEvent==="del"){
                lucky.Delete_data(_id,"<?php echo url('navigate/delete'); ?>","table_id");
            }

        });


        var active = {
            add_menu:function(){
                lucky.CreateForm("添加栏目",'50%','80%',"<?php echo url('navigate/AddNavigate'); ?>","table_id");
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
                lucky.Delete_data(id,"<?php echo url('navigate/delete'); ?>","table_id");
            },
            reload: function(){
                lucky.CreateReload("table_id");
            },
            move:function () {
                lucky.CreateForm("新增外部链接",'50%','80%',"<?php echo url('navigate/Addlink'); ?>","table_id");
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