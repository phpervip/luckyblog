
    //鼠标点击事件
    document.onmousedown = function mdClick(event) {
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if (e.button == 2 || e.button == 3) {
            return false;
        }
    };

    //禁用浏览器 默认右键菜单
    document.oncontextmenu = new Function("return false;");

    //监听键盘事件
    document.onkeydown = document.onkeyup = document.onkeypress = function(event) {
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if (e && e.keyCode == 123) {
            e.returnValue = false;
            return (false);
        }
    }


