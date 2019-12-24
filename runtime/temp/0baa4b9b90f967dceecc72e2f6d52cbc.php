<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/widget/delbtn.html";i:1577193368;}*/ ?>

<?php if($t == 1): ?>

<button class="layui-btn layui-btn-sm layui-btn-danger" data-type="<?php echo $type; ?>" ><i class="layui-icon layui-icon-delete" ></i ><?php echo $title; ?>
</button >

<?php else: ?>

<a href="javascript:;"   class="layui-btn layui-btn-danger layui-btn-xs "  onmouseover="tis(this)"  data-title="<?php echo $title; ?>" lay-event="<?php echo $type; ?>"><i class="layui-icon " >&#xe640;</i></a>

<?php endif; ?>