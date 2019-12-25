<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/widget/ueditor.html";i:1577193368;}*/ ?>
<div class="layui-form-item ">
    <label class="layui-form-label"><?php echo $laber; ?>：</label>
    <div class="layui-input-block" style="max-width:85%;">
        <textarea name="<?php echo $name; ?>"  placeholder="<?php echo $placeholder; ?>"  id="<?php echo $name; ?>"  ><?php echo $value; ?></textarea>
    </div>
</div>

<!-- 配置文件 -->
<script type="text/javascript" src="/luckyblog/plug/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/luckyblog/plug/ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor("<?php echo $name; ?>", {
        autoHeightEnabled:false,
        initialFrameHeight:<?php echo $ud_height; ?>,
        zIndex : 0,
    });
</script>