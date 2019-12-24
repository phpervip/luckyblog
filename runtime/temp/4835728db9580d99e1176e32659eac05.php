<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/widget/single_select.html";i:1577193368;}*/ ?>

<select name="<?php echo $idStr; ?>" id="<?php echo $idStr; ?>" <?php if($isV==1): ?>lay-verify="required"<?php endif; ?> lay-search="" lay-filter="<?php echo $idStr; ?>" lay-verType="tips" lay-reqText="请选择<?php echo $msg; ?>" >
    <option value="">【请选择<?php echo $msg; ?>】</option>
    <?php echo make_option($dataList,$selectId,$show_name,$show_value); ?>
</select>