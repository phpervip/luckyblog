/*
 * @Created by Vscode: 
 * @Description: http://luckyadmin.luckyhhy.cn
 * @Author: hhygyl
 * @Date: 2019-05-27 16:36:06
 * @LastEditTime: 2019-08-02 16:51:33
 * @LastEditors: jackhhy
 */

layui.use(['element', 'layer', 'okUtils', 'okTab'], function () {

  var element = layui.element,
    okUtils = layui.okUtils,
    $ = layui.jquery,
    layer = layui.layer,
    okTab = layui.okTab({
      url: NAV_URL,
     // data:nav_data,
      openTabNum: 30, //允许同时选项卡的个数
    });
  
  okTab.render(function () {
    //左侧导航渲染完成之后的操作
    
    
  });//渲染左侧导航
  
  // 添加新窗口
  $("body").on("click", "#navBar .layui-nav-item a,#userInfo a", function () {
    //如果不存在子级
    if ($(this).siblings().length == 0) {
      okTab.tabAdd($(this));
    }
    $(this).parent("li").siblings().removeClass("layui-nav-itemed");//关闭其他的二级标签
  });
  
  /**
   * 左边菜单显隐功能
   * @type {boolean}
   */
  $(".ok-menu").click(function () {
    $(".layui-layout-admin").toggleClass("ok-left-hide");
    $(this).find('i').toggleClass("ok-menu-hide");
  });
  
  //移动端的处理事件Start
  $("body").on("click", ".layui-layout-admin .ok-left a[data-url],.ok-make", function () {
    if ($(".layui-layout-admin").hasClass("ok-left-hide")) {
      $(".layui-layout-admin").removeClass("ok-left-hide");
      $(".ok-menu").find('i').removeClass("ok-menu-hide");
    }
  });
  //移动端的处理事件End
  
  //tab左右移动
  $("body").on("click", ".okNavMove", function () {
    var moveId = $(this).attr("data-id");
    var that = this;
    okTab.navMove(moveId, that);
    // console.log(width);
  });
  
  //刷新当前tab页
  $("body").on("click", ".ok-refresh", function () {
    okTab.refresh(this);
  });
  
  //关闭tab页
  $("body").on("click", "#tabAction a", function () {
    var num = $(this).attr('data-num');
    okTab.tabClose(num);
  });
  
  //全屏/退出全屏
  $("body").on("keydown", function (event) {
    event = event || window.event || arguments.callee.caller.arguments[0];
    if (event && event.keyCode == 27) { // 按 Esc
      console.log("Esc");
      $("#fullScreen").children("i").eq(0).removeClass("okicon-screen-restore");
    }
    if (event && event.keyCode == 122) { // 按 F11
      $("#fullScreen").children("i").eq(0).addClass("okicon-screen-restore");
    }
  });
  $("body").on("click", "#fullScreen", function () {
    if ($(this).children("i").hasClass("okicon-screen-restore")) {
      screenFun(2).then(() => {
        $(this).children("i").eq(0).removeClass("okicon-screen-restore");
      });
    } else {
      screenFun(1).then(() => {
        $(this).children("i").eq(0).addClass("okicon-screen-restore");
      });
    }
  });


  // 我的要求并不高，保留这一句版权信息可好？
// 保留了，你不会损失什么；而保留版权，是对作者最大的尊重。
  console.info('欢迎使用 LuckyAdmin!\n当前版本：V2.1 \n作者：hhygyl(https://blog.csdn.net/qq_24562495)\n系統采用TP5.0+Layui2.5.4\n演示地址：http://luckyadmin.hhygyl.cn');

  /**
   * 全屏和退出全屏的方法
   * @param num
   * num为1代表全屏
   * num为2代表退出全屏
   */
  function screenFun(num = 1) {
    num = num * 1;
    var docElm = document.documentElement;
    
    switch (num) {
      case 1:
        if (docElm.requestFullscreen) {
          docElm.requestFullscreen();
        } else if (docElm.mozRequestFullScreen) {
          docElm.mozRequestFullScreen();
        } else if (docElm.webkitRequestFullScreen) {
          docElm.webkitRequestFullScreen();
        } else if (docElm.msRequestFullscreen) {
          docElm.msRequestFullscreen();
        }
        break;
      case 2:
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
        break;
    }
    
    return new Promise((res, rej) => {
      res("返回值");
    });
  }



  $('#notice').mouseover(function () {
    layer.tips('公告跑到这里去啦', '#notice', {
      tips: [1, '#FF5722'],
      time: 2000
    });
  });
  
  /**
   * 系统公告
   */
  $(document).on("click", "#notice", noticeFun);
  !function () {
   /* let notice = sessionStorage.getItem("notice");
    if (notice != "true") {
      noticeFun();
    }*/
  }();
  
  function noticeFun() {
    var srcWidth = okUtils.getBodyWidth();
    layer.open({
      type: 0,
      title: "系统公告",
      btn: "我知道啦",
      btnAlign: 'c',
      content: "LuckyAdmin v2.1上线啦(^し^)<br />" +
        "在此郑重承诺该系统：<br /><span style='color:#5cb85c;font-weight: bold;'>采用TP5.0+Layui2.5.4版本开发！</span>" +
        "<br />"+
       "如有任何问题请联系<span> <a style='color:red' href='tencent://message/?uin=2237696522&amp;Site=&amp;Menu=yes'>2237696522</a></span>",
      yes: (index) => {
        if (srcWidth > 800) {
          layer.tips('公告跑到这里去啦', '#notice', {
            tips: [1, '#FF5722'],
            time: 2000
          });
        }
        sessionStorage.setItem("notice", "true");
        layer.close(index);
      },
      cancel: (index) => {
        if (srcWidth > 800) {
          layer.tips('公告跑到这里去啦', '#notice', {
            tips: [1, '#FF5722'],
            time: 2000
          });
        }
      }
    });
  }
  
  /**
   * 捐赠作者
   */
  $(".layui-footer button.donate").click(function () {
    layer.tab({
      area: ["330px", "350px"],
      tab: [{
        title: "支付宝",
        content: "<img src='"+zfb+"' width='200' height='300' style='margin-left: 60px'>"
      }, {
        title: "微信",
        content: "<img src='"+wxs+"' width='200' height='300' style='margin-left: 60px'>"
      }]
    });
  });


  /**
   * 联系作者
   */
  $("body").on("click", ".layui-footer button.communication,#noticeQQ", function () {
    window.location.href="tencent://message/?uin=2237696522&amp;Site=&amp;Menu=yes";
  });

  
  /**
   * 退出操作
   */
  $("#logout").click(function () {
    layer.confirm("确定要退出吗？", {skin: 'layui-layer-lan', icon: 3, title: '提示', anim: 6}, function () {
       $.post(Login_out,{name:""},function (res) {
          layer.msg("退出成功！",{icon:1,time:1500,shade:0.5},function () {
                window.location.href=lOGIN;
          })
       })
    });
  });

  // 锁屏控制
  $('#lock').mouseover(function () {
    layer.tips('请按Alt+L快速锁屏！', '#lock', {
      tips: [1, '#FF5722'],
      time: 2000
    });
  });


  $(document).keydown(function (e) {
    if (e.altKey && e.which == 76) {
       lock_pass();
    }
  });


  // 缓存
  $('#huancun').mouseover(function () {
    layer.tips('清除系统缓存', '#huancun', {
      tips: [1, '#FF5722'],
      time: 2000
    });
  });


  /**
   * 刷新缓存
   */
  $("#huancun").click(function () {
    layer.confirm("确定要清除系统缓存吗？", {skin: 'layui-layer-lan', icon: 3, title: '提示', anim: 6}, function () {
      $.post(cache_url,{name:"lucky_admin"},function (res) {
        if (res.code==1){
          layer.msg("清除成功！",{icon:1,time:1500,shade:0.5},function () {
            window.location.reload();
          });
        } else {
          layer.msg(res.msg,{icon:1,time:1500,shade:0.5});
        }

      })
    });
  });

  /**
   * 锁屏
   */
  function lock_pass(){
      layer.prompt({
        btn: ['确定'],
        title: '请输入锁屏密码！',
        closeBtn: 1,
        formType: 1,
        shade: 0.5,
      }, function (value, index) {
          $.post(lock_url,{pass:value},function (res) {
            if (res.code==1){
              layer.close(index);
              window.location.href=href_jump;
            }else {
              layer.msg(res.msg, {anim: 6});
              return false;
            }
          });
      });
  }
  /**
   * 锁定账户
   */
  $("#lock").click(function () {
    lock_pass();
  });




});
