<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/widget/upthumb.html";i:1577193368;}*/ ?>
<div class="layui-form-item">
    <label class="layui-form-label"><?php echo $label; ?>：</label>
    <div class="layui-input-inline">
        <input name="<?php echo $name; ?>" lay-verify="<?php echo $verify; ?>" lay-verType="tips" lay-reqText="<?php echo $placeholder; ?>" id="LAY_avatarSrc" placeholder="<?php echo $placeholder; ?>" value="<?php echo $value; ?>"  readonly class="layui-input">
    </div>
    <div class="layui-input-inline layui-btn-container" style="width: auto;">
        <button type="button" class="layui-btn layui-btn-primary" id="LAY_avatarUpload">
            <i class="layui-icon">&#xe67c;</i><?php echo $btn; ?>
        </button>

        <?php if($xuan == 1): ?>
        <a class="layui-btn layui-btn-warm" id="avartatPreview">素材库选择</a >
        <?php endif; ?>

    </div>
</div>

<div class="layui-form-item layui-hide">
    <label class="layui-form-label">图片显示：</label>
    <div class="layui-input-inline">
        <div class="layui-upload">
            <div class="layui-upload-list">
                <img class="layui-upload-img" src="<?php if($value != null): ?><?php echo $value; else: ?>/luckyblog/admin/images/default_upload.png<?php endif; ?>" id="demo1" width="150" height="110">
            </div>
        </div>
    </div>
</div>



<script >
    layui.use(['element', 'jquery','upload'], function () {
        var element = layui.element;
        var $ = layui.jquery;
        var upload=layui.upload;

        var $wit=<?php echo $width; ?>;
        var $heig=<?php echo $heig; ?>;

        //图片上传
        upload.render({
            elem:'#LAY_avatarUpload'
            ,url: "<?php echo url('admin/common/UpThumbImg'); ?>" //头像上传地址
            ,accept: 'images' //
            ,acceptMime: 'image/*'
            ,size: 1024*9
            ,data:{width:$wit,height:$heig}
            ,before:function (res) {
                loading = layer.load(2, {
                    shade: [0.2, '#000'] //0.2透明度的白色背景
                });
            }
            ,done: function(data){
                layer.close(loading);
                if (data.code==1){
                    layer.msg(data.msg, {icon: 1, time: 1000},function () {
                        $("#demo1").attr("src",data.path);
                        $("#LAY_avatarSrc").val(data.path);
                    });
                } else {
                    layer.msg(data.msg, {icon: 5, time: 1000});
                }
            }
            ,error:function (red) {
                layer.close(loading);
                layer.msg("网络错误", {icon: 5, time: 1500});
            }
        });



        // 弹窗选择
        $('#avartatPreview').click(function () {
            layer.open({
                title:"选择素材",
                type: 2,
                area: ["50%", "80%"],
                offset:'auto',
                maxmin : true,
                skin:'layui-layer-molv',
                shade: 0.5,
                content: "<?php echo url('article/get_images'); ?>",
                success:function(){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3,time:1000
                        });
                    },500)
                },
            });
            return false;
        });


        /**
         * 鼠标显示
         */
        $('#LAY_avatarSrc').hover(function(){
            var img = "<img class='img_msg' src='"+$(this).val()+"' style='width:100%;max-height: 600px;' />";
            img_show = layer.tips(img, this,{
                tips:[2, 'rgba(41,41,41,.0)']
                ,area: ['12%']
            });
        },function(){
            layer.close(img_show);
        });


    });

</script >
