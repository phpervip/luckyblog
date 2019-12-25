<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:87:"/Users/mac/data/tp/luckyblog/public/../application/admin/view/article/edit_article.html";i:1577193368;s:73:"/Users/mac/data/tp/luckyblog/application/admin/view/public/open_head.html";i:1577193368;}*/ ?>
<!--
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/7/23-16:24
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: edit_article.html
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

            <div class="layui-form-item " style=""  >
                <label class="layui-form-label" >所属栏目：</label >
                <div class="layui-input-inline input-custom-width">
                    <select name="navigate_id" lay-search=""  lay-verify="required" lay-verType="tips" lay-reqText="请选择栏目" >
                        <option value="">请选择栏目</option>
                        <?php if(is_array($navigate) || $navigate instanceof \think\Collection || $navigate instanceof \think\Paginator): $i = 0; $__LIST__ = $navigate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $v['id']; ?>" <?php if($info['navigate_id'] == $v['id']): ?> selected <?php endif; if($v['pid'] == '0'): ?> disabled <?php endif; ?>>├─ <?php echo $v['title']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div >
            </div >

            <div class="layui-form-item" ><label class="layui-form-label">文章标题：</label><div class="layui-input-block input-custom-width"  style="width: 350px;"><input type='text' name='title' id='' lay-verify='required' lay-verType='tips' lay-reqText='请输入文章标题' autocomplete='off'  class='layui-input name'  placeholder='请输入文章标题' value='<?php echo $info['title']?>' /></div></div>

            <?php echo token(); ?>

            <input type="hidden" name="id" value="<?php echo $info['id']; ?>" >


            <?php echo widget('forms/Upthumb',array('image_url|缩略图|文章缩略图||选择图片',$info['image_url'],700,600,1)); ?>

            <div class="layui-form-item">
                <label class="layui-form-label">是否推荐：</label>
                <div class="layui-input-inline input-custom-width">
                    <input type="radio" name="is_recommend" value="1" title="是" <?php if($info['is_recommend'] == '1'): ?> checked <?php endif; ?>>
                    <input type="radio" name="is_recommend" value="0" title="否"  <?php if($info['is_recommend'] == '0'): ?> checked <?php endif; ?>>
                </div>
                <div class="layui-form-mid layui-word-aux">用于前台推荐调用</div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label">是否置顶：</label>
                <div class="layui-input-inline input-custom-width">
                    <input type="radio" name="is_top" value="1" title="是"   <?php if($info['is_top'] == '1'): ?> checked <?php endif; ?> >
                    <input type="radio" name="is_top" value="0" title="否"  <?php if($info['is_top'] == '0'): ?> checked <?php endif; ?>>
                </div>
                <div class="layui-form-mid layui-word-aux">用于前台置顶调用</div>
            </div>


            <div class="layui-form-item" ><label class="layui-form-label">关键词：</label><div class="layui-input-inline input-custom-width" style="width: 350px;"><input type='text' name='keywords' id='' lay-verify='required' lay-verType='tips' lay-reqText='关键词' autocomplete='off'  class='layui-input name'  placeholder='关键词' value='<?php echo $info['keywords']?>' /></div><div class="layui-form-mid layui-word-aux layui-text text-success">关键词以英文逗号隔开</div></div>

            <div class='layui-form-item'><div class='layui-form-label'>摘要：</div> <div class='layui-input-block input-custom-width'><textarea name='description'  class='layui-textarea ' lay-verType='tips' lay-reqText='请输入摘要'  autocomplete='off' lay-verify='' style='width: 450px;' placeholder='请输入摘要'><?php echo $info['description']?></textarea></div></div>

            <div class="layui-form-item" ><label class="layui-form-label">点击量：</label><div class="layui-input-inline input-custom-width" style="width: 350px;"><input type='number' name='hits' id='' lay-verify='required' lay-verType='tips' lay-reqText='文章点击量' autocomplete='off'  class='layui-input '  placeholder='文章点击量' value='<?php echo $info['hits']?>' /></div><div class="layui-form-mid layui-word-aux layui-text text-success">文章的点击数量</div></div>

            <div class="layui-form-item "  >
                <label class="layui-form-label" >文章类型：</label >
                <div class="layui-input-inline input-custom-width "  >
                    <select name="source" >
                        <option value="原创" <?php if($info['source'] == '原创'): ?> selected <?php endif; ?>>原创</option >
                        <option value="转载"  <?php if($info['source'] == '转载'): ?> selected <?php endif; ?>>转载</option >
                    </select >
                </div >
                <label class="layui-form-label" >作者：</label >
                <div class="layui-input-inline input-custom-width "  >
                    <input type="text" name="author" value="<?php echo $info['author']; ?>" placeholder="文章作者" lay-verify="required" lay-verType="tips" lay-reqText="文章作者" autocomplete="off"  class="layui-input " >
                </div >

            </div >

            <?php echo widget('forms/Ueditor',array('content|文章内容|文章内容|420',$info['content'])); ?>


            <div class="layui-form-item">

                <label class="layui-form-label">文章地址：</label>
                <div class="layui-input-inline input-custom-width">
                    <input type="text" class="layui-input" value="<?php echo $info['url']; ?>" >
                </div>

                <label class="layui-form-label">添加时间：</label>
                <div class="layui-input-inline input-custom-width">
                    <input type="text" class="layui-input" value="<?php echo $info['time_formt']; ?>">
                </div>
                <div class="layui-form-mid layui-word-aux">文章远程图片本地化</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">是否显示：</label>
                <div class="layui-input-inline input-custom-width ">

                    <select name="status" >
                        <option value="1" <?php if($info['status'] == '1'): ?> selected <?php endif; ?>>显示</option>
                        <option value="2" <?php if($info['status'] == '2'): ?> selected <?php endif; ?>>不显示</option>
                        <option value="3" <?php if($info['status'] == '3'): ?> selected <?php endif; ?>>草稿文章</option>
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux">是否在首页展示文章</div>

                <label class="layui-form-label">内容首图：</label>
                <div class="layui-input-inline input-custom-width">
                    <input type="radio" name="pic" value="1" title="是"  >
                    <input type="radio" name="pic" value="0" title="否" checked>
                </div>
                <div class="layui-form-mid layui-word-aux">提取内容第一张图片为缩略图</div>
            </div>

            <div class="layui-form-item">

                <label class="layui-form-label">保存为草稿：</label>
                <div class="layui-input-inline input-custom-width">
                    <input type="radio" name="cao" value="1" title="是" >
                    <input type="radio" name="cao" value="0" title="否"  checked>
                </div>
                <div class="layui-form-mid layui-word-aux">文章保存为草稿不发布</div>

                <label class="layui-form-label">图片本地化：</label>
                <div class="layui-input-inline input-custom-width">
                    <input type="radio" name="img" value="1" title="是" >
                    <input type="radio" name="img" value="0" title="否"  checked>
                </div>
                <div class="layui-form-mid layui-word-aux">文章远程图片本地化</div>
            </div>

            <?php echo widget('forms/submit',array('add','立即保存',2)); ?>

        </form>

    </div >


</div >


<script >
    layui.use(['element', 'form', 'jquery', 'upload','lucky'], function () {
        var element = layui.element;
        var table = layui.table;
        var form = layui.form;
        var $ = layui.jquery;
        var upload = layui.upload;
        var lucky=layui.lucky;

        /**
         * 提交表单数据
         */
        form.on('submit(add)', function (data) {
            lucky.FormSubmit("<?php echo url('article/AddArticle'); ?>", data.field, "table_id", 1);
            return false;
        });

    })
</script >


</body>
</html>