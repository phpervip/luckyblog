<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/widget/submit.html";i:1577193368;}*/ ?>

<div class="layui-form-item layui-layout-admin " style="width: 100%">
    <div class="layui-input-block">
        <div class="layui-footer" style="left: 0px;text-align: center;">
            <button class="layui-btn" lay-submit="" lay-filter="<?php echo $filter; ?>"><?php echo $btnname; ?></button>
            <?php if($cz == 1): ?>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <?php endif; ?>
        </div>
    </div>
</div>

