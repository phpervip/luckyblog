$(function () {
    layui.use(["layer", "form", "element", "util","jquery"], function() {
       var form = layui.form;
        var layer = layui.layer;
        var element = layui.element;
        var util = layui.util;
        var $ = layui.$;

        var NickName=sessionStorage.getItem("jack-username"); //用户名
        var QQ=sessionStorage.getItem("jack-qq"); //qq
        var Img=sessionStorage.getItem("jack-image"); //头像
        if (NickName==null ||NickName==""){
        }else {
            $("#avatar").attr("src",Img);
            $("#qq").val(QQ);
            $("#username").val(NickName);
        }

        //qq输入框失去焦点
        $("#qq").blur(function(){
            var qq=$("#qq").val();
            if(qq.length > 0){
                if(!isNaN(qq)){
                    $.post("/api/api/getQQNickName",{qq:qq},function (res) {
                        if (res.code==1){
                            $("#username").val(res.name);
                            $("#image").val(res.image);
                            $("#avatar").attr("src","https://q1.qlogo.cn/g?b=qq&nk="+qq+"&s=100");
                        }  else {
                            layer.msg(res.msg);
                        }
                    });
                }else{
                    layer.msg("QQ格式不正确");
                }
            }
        });


        /*提交留言*/
        $("#submitCommentBtn").click(function () {
            if($("#username").val()==""){
                layer.msg("请输入昵称")
                return;
            }else if($("#comment-textarea").val()==""){
                layer.msg("说点什么吧")
                return;
            }
            $.post("/index/feedback/feedsave",$("#comment-form").serialize(),function (data) {
                if(data.code==1){
                    if(NickName!=$("#username").val()||QQ!=$("#qq").val()){
                        sessionStorage.setItem("jack-username",$("#username").val()); //用户名
                        sessionStorage.setItem("jack-qq",$("#qq").val()); //qq
                        sessionStorage.setItem("jack-image",$("#image").val()); //头像
                    }
                    layer.msg("留言成功，请等待管理员审核！" ,{time:1000},function () {
                        $("#comment-textarea").val("");
                    });
                }else {
                    layer.msg(data.msg);
                    return;
                }
            })
        });




        /**
         * 视频点赞
         */
        $(".video_zan").click(function () {
              var id=parseInt($(this).attr("data-id"));
              v_p_zan("/index/duanjie/zan",id);
        });

        /**
         * 图片点赞
         */
        $(".pic_zan").click(function () {
            var id=parseInt($(this).attr("data-id"));
            v_p_zan("/index/jokeimg/zan",id);
        });

        /**
         * 相冊点赞
         */
        $(".album_zan").click(function () {
            var id=parseInt($(this).attr("data-id"));
            v_p_zan("/index/album/zan",id);
        });


        /**
         * 视频图片点赞
         * @param url
         * @param data
         */
        function v_p_zan(url,id) {
            $.ajax({
                url:url,
                type:'post',
                data:{id:id},
                error: function(error) {
                    layer.msg("服务器错误或超时");
                    return false;
                },
                beforeSend:function(){
                    layer.load(2);
                },
                success:function(data)
                {
                    if (data.code==1) {
                        layer.msg(data.msg,{icon: 1, time: 1000,shade:0.3, anim: 4},function () {
                            var ok=$(".zan_"+id);
                            var num=parseInt(ok.text());
                            var nums=num+1;
                            ok.text(nums);
                        });
                    }else{
                        layer.msg(data.msg,{icon:15,time:1000,shade:0.3,anim:4});
                    }
                },
                complete:function(){
                    layer.closeAll('loading');
                }
            });
        }


        /**
         * 鼠标移上显示原图
         * @type {null}
         */
        var img_show = null; // tips提示
        $('.img_album').hover(function(){
            var img = "<img class='img_msg' src='"+$(this).attr('data-url')+"' style='width:100%;' />";
            img_show = layer.tips(img, this,{
                tips:[2, 'rgba(41,41,41,.0)']
                ,area: ['12%']
            });
        },function(){
            layer.close(img_show);
        });


    });


});


/**
 * 查看相册检验
 */
function view_album(obj) {
    var open=parseInt($(obj).attr("data-open"));
    var id=parseInt($(obj).attr("data-id"));
    if (open==0){ //不需要密码
        view_album_image(id);
    } else { //需要密码
        layer.prompt({
            btn: ['确定'],
            title: '请输入相册解密密码！',
            closeBtn: 1,
            formType: 1,
            shade: 0.5,
        }, function (value, index) {
            $.post("/index/album/album_pass",{pass:value,id:id},function (res) {
                if (res.code==1){
                    layer.close(index);
                    view_album_image(id);
                }else {
                    layer.msg(res.msg, {anim: 6});
                    return false;
                }
            });
        });
    }
}


/**
 * 查看相册图片
 * @param id
 */
function  view_album_image(id) {
    layer.open({
        type: 2,
        title:"查看相册图片",
        skin: 'layui-layer-rim', //加上边框
        maxmin: true,
        shadeClose:true,
        area: ['85%', '95%'], //宽高
        content: "/index/album/view_image/id/"+id
    });
}

/**
 * 查看视频
 * @param obj
 */
function openvideo(obj) {
    var urls=$(obj).attr("data-url");
    var  title=$(obj).attr("data-title");
    layer.open({
        type: 2,
        title:title,
        skin: 'layui-layer-rim', //加上边框
        maxmin: true,
        shadeClose:true,
        area: ['50%', '60%'], //宽高
        content: urls
    });
}


/**
 * 查看图片
 * @param obj
 */
function openimage(obj) {
    var urls=$(obj).attr("data-url");
    var  title=$(obj).attr("data-title");
    layer.open({
        type: 1,
        title:title,
        shadeClose:true,
        skin: 'layui-layer-rim', //加上边框
        maxmin: true,
        content: "<img src='"+urls+"'  width='100%'  height='auto' />"
    });
}


/**
 * 文章喜欢
 * @param url
 * @param cid
 * @param d
 * @returns {boolean}
 */
function article_like(cid){
    var saveid = GetCookie('article_like');
    if (saveid == cid) {
        layer.msg("你已经点过赞咯！",{icon:15,time:1000,shade:0.3,anim:4});
    } else{
        $.ajax({
            type: 'POST',
            url: "/index/article/like",
            data: {id:parseInt(cid)},
            dataType: "json",
            success: function (data) {
                if(data.code == 1){
                  /*  layer.msg(data.msg,{icon: 1, time: 1000,shade:0.3, anim: 4},function () {*/
                        var ok=$("#up");
                        var num=parseInt(ok.text());
                        var nums=num+1;
                        ok.text(nums);
                  /*  });*/
                }else{
                    layer.msg(data.msg,{icon:15,time:1000,shade:0.3,anim:4});
                }
            }
        });
        SetCookie('article_like', cid, 1);
        return true;
    }
}

/**
 * 评论点赞
 * @param obj
 */
function article_ping(obj){
    var id=parseInt($(obj).attr("data-id"));
    var saveid = GetCookie('comment_like');
    if (saveid == id) {
        layer.msg("你已经点过赞咯！",{icon:15,time:1000,shade:0.3,anim:4});
    } else{
        $.ajax({
            type: 'POST',
            url: "/index/article/comment_zan",
            data: {id:id},
            dataType: "json",
            success: function (data) {
                if(data.code == 1){
                    /*  layer.msg(data.msg,{icon: 1, time: 1000,shade:0.3, anim: 4},function () {*/
                    var ok=$("#article_zan_"+id);
                    var num=parseInt(ok.text());
                    var nums=num+1;
                    ok.text(nums);
                    /*  });*/
                }else{
                    layer.msg(data.msg,{icon:15,time:1000,shade:0.3,anim:4});
                }
            }
        });
        SetCookie('comment_like', id, 1);
        return true;
    }
}


/**
 * 文章评论开始
 */
$("#qqq").blur(function(){
    var qqq=$("#qqq").val();
    if(qqq.length > 0){
        if(!isNaN(qqq)){
            $.post("/api/api/getQQNickName",{qq:qqq},function (res) {
                if (res.code==1){
                    $("#username").val(res.name);
                    $("#image").val(res.image);
                    $("#avatar").attr("src","https://q1.qlogo.cn/g?b=qq&nk="+qqq+"&s=100");
                }  else {
                    layer.msg(res.msg);
                }
            });
        }else{
            layer.msg("QQ格式不正确");
        }
    }
});

var QQQ=GetCookie("qq-nickname"); //qq
var Username=GetCookie("qq-username"); //用户名
var Image_c=GetCookie("qq-image"); //头像
if (Username==null ||Username==""){
}else {
    $("#avatar").attr("src",Image_c);
    $("#qqq").val(QQQ);
    $("#username").val(Username);
}
/*提交评论*/
$("#submitCommentBtn-article").click(function () {
    if($("#username").val()==""){
        layer.msg("请输入昵称",{time:1000});
        return;
    }else if($("#comment-textarea").val()==""){
        layer.msg("说点什么吧",{time:1000})
        return;
    }
    $.post("/index/article/comment",$("#comment-form-article").serialize(),function (data) {
        if(data.code==1){
            var pid=parseInt($("#pid").val());
            if(pid==0 && QQQ!=$("#qqq").val()){
                SetCookie('qq-nickname', $("#qqq").val(), 1);
                SetCookie("qq-username",$("#username").val()); //用户名
                SetCookie("qq-image",$("#image").val()); //头像
            }
            layer.msg("评论成功，请等待管理员审核！",{icon:1,time:1000,shade:0.3,anim:4},function () {
                $("#comment-textarea").val("");
            });
        }else {
            layer.msg(data.msg,{icon:15,time:1000,shade:0.3,anim:4});
            return;
        }
    })
});


/**
 * 回复评论
 * @param obj
 */
function replay_comment(obj){
    var pid=parseInt($(obj).attr("data-id"));
    $("#pid").val(pid);
    var name=$(obj).attr("data-name");
    document.getElementById("comment-textarea").placeholder="回复@"+name;
}

/**
 * 文章评论结束
 */




/**
 *
 * @param c_name
 * @returns {string|null}
 * @constructor 获取cookie
 */
function GetCookie(c_name){
    if (document.cookie.length > 0){
        c_start = document.cookie.indexOf(c_name + "=")
        if (c_start != -1){
            c_start = c_start + c_name.length + 1;
            c_end   = document.cookie.indexOf(";",c_start);
            if (c_end == -1){
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return null
}

/**
 *
 * @param c_name
 * @param value
 * @param expiredays
 * @constructor
 */
function SetCookie(c_name, value, expiredays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expiredays);
    document.cookie = c_name + "=" +escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString());
}

