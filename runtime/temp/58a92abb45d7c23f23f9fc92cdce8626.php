<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/article/get_images.html";i:1577193368;s:73:"/Users/mac/data/tp/luckyblog/application/admin/view/public/open_head.html";i:1577193368;}*/ ?>
<!--
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/7/25-14:19
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: get_images.html
 *-->


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $Lucky_Name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/luckyblog/plug/layui/css/layui.css">
    <script src="/luckyblog/admin/js/jquery.min.js"></script>
    <script src="/luckyblog/plug/layui/layui.js"></script>
    <link href="/luckyblog/admin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <script >
        var local_url="/luckyblog/admin/js/";
    </script >
    <script src="/luckyblog/admin/js/base.js"></script >
</head>
<body>

<link rel="stylesheet" href="/luckyblog/admin/css/admin.css?v=312">
<link rel="stylesheet" href="/luckyblog/admin/css/sub-page.css">
<link rel="stylesheet" href="/luckyblog/admin/css/fileCommon.css">

<style >

    @media screen and (max-width: 420px) {
        .btnDiv {
            padding-top: 30px;
            text-align: left;
        }
    }

    .showBB .bottomBar {
        display: block;
    }

</style >

<!-- 正文开始 -->
<div class="layui-fluid">
    <div class="layui-row layui-col-space10">
        <div class="layui-col-md12">

            <div class="layui-card">
                <div class="layui-card-body">

                    <div class="layui-form">

                    <div class="file-list">
                        <?php if(is_array($data['data']) || $data['data'] instanceof \think\Collection || $data['data'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <div class="file-list-item"  data-url="<?php echo $vo['file_path']; ?>" data-name="<?php echo $vo['filename']; ?>" data-ext="<?php echo $vo['ext']; ?>"   data-title="<?php echo $vo['filename']; ?>">
                            <div class="file-list-img media " data-id="<?php echo $vo['id']; ?>" >
                                <img class="lazy" alt="ss" data-original="<?php echo $vo['file_path']; ?>"  />
                            </div>
                            <div class="file-list-name"><?php echo $vo['filename']; ?></div>
                            <div class="file-list-ck layui-form">
                                <input type="radio" name="imgCk" value="<?php echo $vo['file_path']; ?>" lay-skin="primary" />
                            </div>
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>


                    <!--分页开始-->
                    <div class="layui-row" style="text-align: center;">
                        <?php echo $page; ?>
                    </div>
                    <!--分页结束-->


                    <div class="layui-form-item" >
                        <div class="layui-input-block">
                            <div class="layui-footer" style="left: 0px;text-align: right;">
                                <button class="layui-btn" lay-submit="" lay-filter="add">确认选择</button>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!-- 下拉菜单 -->
<div class="dropdown-menu dropdown-anchor-top-left" id="dropdownFile">
    <div class="dropdown-anchor"></div>
    <ul>
        <li><a id="open"><i class="layui-icon layui-icon-file"></i> 查看 </a></li>
    </ul>
</div>


<script type="text/javascript" src="/luckyblog/admin/js/clipboard.min.js"></script>

<script type="text/javascript" src=/luckyblog/admin/js/jquery.lazyload.min.js?v=1.9.1"></script>

<script type="text/javascript" charset="utf-8">
    $(function() {
        $("img.lazy").lazyload({effect: "fadeIn",threshold: 100});
    });
</script>

<script>

    layui.use(['jquery', 'layer', 'element', 'upload',  'util' ,'form'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var element = layui.element;
        var upload = layui.upload;
        var util = layui.util;
        var form = layui.form;

        form.render();

        var mUrl; //素材地址
        var show; //素材类型
        var names; //原始名称
        var _id; //素材id
        // 列表点击事件
        $('body').on('click', '.file-list-item > .file-list-img', function (e) {
            var name = $(this).parent().data('name');
            mUrl = $(this).parent().data('url');
            show=$(this).parent().data('ext');
            names=name;
            _id=parseInt( $(this).data('id'));

            var $target = $(this);
            $('#dropdownFile').css({
                'top': $target.offset().top + 90,
                'left': $target.offset().left + 25
            });
            $('#dropdownFile').addClass('dropdown-opened');
            if (e !== void 0) {
                e.preventDefault();
                e.stopPropagation();
            }
        });


        // 点击空白隐藏下拉框
        $('html').off('click.dropdown').on('click.dropdown', function () {
            $('#dropdownFile').removeClass('dropdown-opened');
        });


        // 打开
        $('#open').click(function () {
                layer.photos({
                    photos: {
                        title: "查看图片",
                        data: [{
                            src: mUrl
                        }]
                    },
                    shade: .01,
                    closeBtn: 1,
                    anim: 5
                });
        });


        form.on('submit(add)', function (data) {

            var val=$('input:radio[name=imgCk]:checked').val();
            console.log(val);
            if (val==undefined || val===""){
                layer.msg("请选择一张图片",{kin: 'layui-layer-lan', icon:5,time:1500,shade:0.7});
                return  false;
            }
            parent.$("#LAY_avatarSrc").val(val);
            parent.$("#demo1").attr("src",val);
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);

        });




    });
</script>

</body>
</html>