<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/login/index.html";i:1577200683;}*/ ?>
<!--
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/6/26-14:40
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: index.html
 *-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>亿莲博客后台管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/luckyblog/plug/layui/css/layui.css">
    <link rel="stylesheet" href="/luckyblog/admin/css/luckyadmin-v1.css"/>
    <link rel="stylesheet" href="/luckyblog/admin/css/login.css"/>
</head>
<body>
<div id="app">
    <form class="layui-form">
        <div class="login_face"><img src="/luckyblog/admin/images/avatar.jpg" class="userAvatar"></div>
        <div class="layui-form-item input-item">
            <label for="userName">用户名</label>
            <input type="text" lay-verify="required" name="username" placeholder="请输入用户名" autocomplete="off" id="userName"
                   class="layui-input" lay-verType="tips" lay-reqText="请输入用户名" value="luckyblog">
        </div>
        <div class="layui-form-item input-item">
            <label for="password">密码</label>
            <input type="password" lay-verify="required" name="password" placeholder="请输入密码" autocomplete="off"
                   id="password" class="layui-input" lay-verType="tips" lay-reqText="请输入密码" value="jackhhy">
            <?php echo token(); ?>
        </div>
        <div class="layui-form-item input-item" id="imgCode">
            <label for="code">验证码</label>

            <input type="text" lay-verify="required"  name="code" placeholder="请输入验证码" autocomplete="off" id="code"
                   class="layui-input" lay-verType="tips" lay-reqText="验证码必填">
            <div class="img ok-none-select captcha">
                <img src="<?php echo captcha_src(); ?>" alt="captche" style="width: 100px;height: 35px;" title='点击切换'
                     onclick="this.src='/captcha?id='+Math.random()">
            </div>
        </div>
        <div class="layui-form-item">
            <button class="layui-btn layui-block" lay-filter="login" lay-submit="">登录</button>
        </div>
    </form>
</div>

<!--js逻辑-->
<script src="/luckyblog/plug/layui/layui.js"></script>

<script>
    layui.use(['form', 'jquery'], function () {
        var form = layui.form;
        var $ = layui.jquery;
        form.on('submit(login)', function (data) {
            var load=layer.load(2);
            $.ajax({
                url:"<?php echo url('login/index'); ?>",
                dataType:"json",
                type:'post',
                //data:$("#form").serialize(),
                data:data.field,
                success:function(data){
                    if(data.code==1)
                    {
                        layer.msg(data.msg, {icon: 1, time: 1500, anim: 4,shade:0.5}, function () {
                            layer.close(load);
                            window.location.href="<?php echo url('admin/index/index'); ?>";
                        });
                    }
                    else
                    {
                        layer.msg(data.msg, {icon: 5, time: 1000, anim: 4,shade:0.5}, function () {
                            layer.close(load);
                            //$('.captcha img').attr('src', '/captcha?id=' + Math.random());
                        });
                    }
                }
            });

            return false;
        });

        //表单输入效果
        $("#app .input-item .layui-input").click(function (e) {
            e.stopPropagation();
            $(this).addClass("layui-input-focus").find(".layui-input").focus();
        });

        $("#app .layui-form-item .layui-input").focus(function () {
            $(this).parent().addClass("layui-input-focus");
        });

        $("#app .layui-form-item .layui-input").blur(function () {
            $(this).parent().removeClass("layui-input-focus");
            if ($(this).val() != '') {
                $(this).parent().addClass("layui-input-active");
            } else {
                $(this).parent().removeClass("layui-input-active");
            }
        });

    });
</script>
</body>
</html>
