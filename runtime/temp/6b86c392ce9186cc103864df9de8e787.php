<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:89:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/navigate/edit_navigate.html";i:1577193368;s:73:"/Users/mac/data/tp/luckyblog/application/admin/view/public/open_head.html";i:1577193368;}*/ ?>
<!--
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/7/9-17:30
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: edit_navigate.html
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

<div class="ok-body">

    <div class="layui-fluid">
        <div class="layui-card">
            <!-- <div class="layui-card-header"></div>-->

            <div class="layui-card-body" style="padding: 15px;">
                <form class="layui-form" action="" lay-filter="component-form-group">

                    <div class="layui-form-item">
                        <label class="layui-form-label">上级栏目：</label>
                        <div class="layui-input-block">

                            <select name="pid" lay-search="">
                                <option value="0" <?php if($pid == '0'): ?> selected <?php endif; ?>>顶级栏目</option>
                                <?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $t['id']; ?>" <?php if($pid == $t['id']): ?> selected <?php endif; ?>><?php echo $t['title_show']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">选择模型：</label>
                        <div class="layui-input-block">

                            <?php echo widget('forms/singleSelect',array('model_id|1|模型|name|id',$model,$info['model_id'])); ?>

                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">

                    <?php echo token(); ?>

                    <div class="layui-form-item" ><label class="layui-form-label">栏目名称：</label><div class="layui-input-block input-custom-width"  style=""><input type='text' name='title' id='' lay-verify='required' lay-verType='tips' lay-reqText='请输入名称' autocomplete='off'  class='layui-input name'  placeholder='请输入名称' value='<?php echo $info['title']?>' /></div></div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">图标类型：</label>
                        <div class="layui-input-block input-custom-width">
                            <input type="radio" name="fontFamily" value="layui-icon" title="layui图标" lay-filter="radio" >
                            <input type="radio" name="fontFamily" value="fa" title="font-awsome图标" lay-filter="radio"  checked>
                        </div>
                        <div class="layui-form-mid layui-word-aux"></div>
                    </div>

                    <div class="layui-form-item" ><label class="layui-form-label">地址：</label><div class="layui-input-block input-custom-width"  style=""><input type='text' name='href' id='' lay-verify='' lay-verType='tips' lay-reqText='请求地址' autocomplete='off'  class='layui-input '  placeholder='请求地址' value='<?php echo $info['href']?>' /></div></div>

                    <div class="layui-form-item layui-tubiao"  <?php if($info['fontFamily'] == 'fa'): ?> style="display:none;"  <?php endif; ?> >
                    <label class="layui-form-label">选择图标：</label>
                    <div class="layui-input-block input-custom-width">
                        <input type="text" name="layui-icon"  value="<?php echo $info['icon']; ?>"  id="iconFonts" placeholder="" lay-verify="" lay-verType="tips" lay-reqText=""  autocomplete="off"  class="layui-input">
                    </div>
                        <div class="layui-form-mid layui-word-aux layui-text " >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php if($info['fontFamily'] == 'layui-icon'): ?>
                           <i class="layui-icon <?php echo $info['icon']; ?>"></i>
                            <?php endif; ?>
                    </div>
                    </div>

                    <div class="layui-form-item font-tubiao"   <?php if($info['fontFamily'] == 'layui-icon'): ?> style="display:none;"   <?php endif; ?> >
                       <label class="layui-form-label">选择图标：</label>
                        <div class="layui-input-block input-custom-width">
                            <input type="text" name="fa"  value="<?php echo $info['icon']; ?>"  id="font-tubiao" placeholder="" lay-verify="" lay-verType="tips" lay-reqText=""  autocomplete="off"  class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux layui-text " >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php if($info['fontFamily'] == 'fa'): ?>
                            <i class="fa <?php echo $info['icon']; ?>"></i>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">是否显示：</label>
                        <div class="layui-input-inline input-custom-width">
                            <input type="radio" name="status" value="1" title="显示" lay-filter="" <?php if($info['status'] == '1'): ?> checked   <?php endif; ?>>
                            <input type="radio" name="status" value="2" title="隐藏" lay-filter=""  <?php if($info['status'] == '2'): ?> checked   <?php endif; ?> >
                        </div>
                        <div class="layui-form-mid layui-word-aux"></div>
                    </div>

                     <div class="layui-form-item" ><label class="layui-form-label">菜单排序：</label><div class="layui-input-inline input-custom-width" style=""><input type='number' name='listorder' id='' lay-verify='' lay-verType='tips' lay-reqText='排序' autocomplete='off'  class='layui-input '  placeholder='排序' value='<?php echo $info['listorder']?>' /></div><div class="layui-form-mid layui-word-aux layui-text text-success">数字越大越靠前</div></div>


                        <?php echo widget('forms/submit',array('add','保存提交')); ?>


                </form>
            </div>
        </div>
    </div>


</div>



<script>
    layui.use(['element', 'form', 'jquery','IconFonts','iconPicker','lucky'], function () {
        var element = layui.element;
        var table = layui.table;
        var form = layui.form;
        var $ = layui.jquery;
        var IconFonts = layui.IconFonts;
        var iconPicker=layui.iconPicker;
        var lucky=layui.lucky;
        //图标选择器
        iconPicker.render({
            // 选择器，推荐使用input
            elem: '#iconFonts',
            // 数据类型：fontClass/layui_icon，
            type: 'fontClass',
            // 是否开启搜索：true/false
            search: true,
            // 是否开启分页
            page: true,
            // 每页显示数量，默认12
            limit: 12,
            // 点击回调
            click: function (data) {
                //console.log(data);
            }
        });

        IconFonts.render({
            // 选择器，推荐使用input
            elem: '#font-tubiao',
            // 数据类型：fontClass/layui_icon，
            type: 'fontClass',
            // 是否开启搜索：true/false
            search: true,
            // 是否开启分页
            page: true,
            // 每页显示数量，默认12
            limit: 12,
            // 点击回调
            click: function (data) {
                //console.log(data);
            }
        });

        /**
         *
         */
        form.on("radio(radio)",function (data) {
            //console.log(data);
            if (data.value=="fa"){
                $(".layui-tubiao").hide(0);
                $(".font-tubiao").show(0);
            } else {
                $(".layui-tubiao").show(0);
                $(".font-tubiao").hide(0);
            }
        });


        /**
         * 数据提交
         */
        form.on('submit(add)', function (data) {
            lucky.FormSubmit("<?php echo url('navigate/AddNavigate'); ?>",data.field,"tableFilter",1);
            return false;
        });
    })
</script>


</body>
</html>
