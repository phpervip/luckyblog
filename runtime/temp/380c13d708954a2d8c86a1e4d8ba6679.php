<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/widget/addbtn.html";i:1577193368;}*/ ?>


<?php if($t == 1): ?>
    <button class="layui-btn layui-btn-sm" data-type="<?php echo $type; ?>" ><i class="layui-icon" >&#xe61f;</i ><?php echo $title; ?></button >

    <?php else: ?>

    <a href="javascript:;"  class="layui-btn layui-btn-xs "  onmouseover="tis(this)"  data-title="<?php echo $title; ?>" lay-event="<?php echo $type; ?>"><i class="layui-icon layui-icon-add-circle-fine"></i></a>

<?php endif; ?>