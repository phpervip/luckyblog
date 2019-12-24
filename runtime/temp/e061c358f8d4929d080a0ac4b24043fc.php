<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:83:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/users/edit_users.html";i:1577193368;s:73:"/Users/mac/data/tp/luckyblog/application/admin/view/public/open_head.html";i:1577193368;}*/ ?>
<!--
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/7/24-16:40
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: edit_users.html
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

<div class="ok-body" >

    <div class="layui-fluid" >

        <form class="layui-form" style="margin-top: 30px;">

            <?php echo token(); ?>
            <input type="hidden" name="id" value="<?php echo $info['id']; ?>" >

            <div class="layui-form-item " >
                <label class="layui-form-label" >qq号：</label >
                <div class="layui-input-inline input-custom-width "  >
                    <input type="text"  value="<?php echo $info['qq']; ?>"  autocomplete="off"   class="layui-input" >
                </div >

                <label class="layui-form-label" >用户昵称：</label >
                <div class="layui-input-inline input-custom-width "  >
                    <input type="text"  value="<?php echo $info['username']; ?>" name="username"  readonly autocomplete="off"   class="layui-input" >
                </div >
            </div >

            <div class="layui-form-item">
                <label class="layui-form-label">状态：</label>
                <div class="layui-input-inline">
                    <input type="radio" name="status" value="1" title="正常" <?php if($info['status'] == '1'): ?> checked <?php endif; ?>>
                    <input type="radio" name="status" value="2" title="拉黑" <?php if($info['status'] == '2'): ?> checked <?php endif; ?>>
                </div>
                <div class="layui-form-mid layui-word-aux layui-text text-success">提示：拉黑就不可以在博客前端评论文章。</div>
            </div>

            <div class="layui-form-item " >
                <label class="layui-form-label" >点赞数：</label >
                <div class="layui-input-inline input-custom-width "  >
                    <input type="number" min="0"  value="<?php echo $info['zan']; ?>" name="zan"  autocomplete="off"   class="layui-input" >
                </div >

                <label class="layui-form-label" >积分：</label >
                <div class="layui-input-inline input-custom-width "  >
                    <input type="number" min="0"  value="<?php echo $info['fen']; ?>" name="fen"  autocomplete="off"   class="layui-input" >
                </div >
            </div >

            <div class="layui-form-item " >
                <label class="layui-form-label" >添加时间：</label >
                <div class="layui-input-inline input-custom-width "  >
                    <input type="text" value="<?php echo $info['time_formt']; ?>"  autocomplete="off"  class="layui-input" >
                </div >

                <label class="layui-form-label" >IP：</label >
                <div class="layui-input-inline input-custom-width "  >
                    <input type="text" value="<?php echo $info['ip']; ?>"  autocomplete="off"  class="layui-input" >
                </div >
            </div >


            <?php echo widget('forms/submit',array('add','立即保存',2)); ?>


        </form>

    </div >


</div >



<script >


    layui.use(['element', 'form', 'jquery', 'upload','lucky'], function () {
        var element = layui.element;
        var form = layui.form;
        var $ = layui.jquery;
        var upload = layui.upload;
        var lucky=layui.lucky;

        /**
         * 提交表单数据
         */
        form.on('submit(add)', function (data) {
            lucky.FormSubmit("<?php echo url('users/EditUsers'); ?>", data.field, "table_id", 1);
            return false;
        });




    })
</script >


</body>
</html>