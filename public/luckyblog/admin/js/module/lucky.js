
layui.define(['jquery'], function(exports){
    "use strict";
    // 声明变量
    var $ = layui.$;
    var lucky = {
        /**
         * 表格搜索
         * @param tableid
         * @param data
         * @constructor
         */
        CreateSearch:function (tableid,data) {
            if (data==""||data==undefined){
                data=[];
            }
            var index=layer.msg("查询中，请稍后...",{icon:16,time:false,shade: 0.3,anim:4});
            setTimeout(function () {
                //执行重载
                layui.table.reload(tableid, {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where:data
                }, 'data');
                layer.close(index);
            },500);
        },

        /**
         * 关闭并刷新父页面
         * @param tableid
         */
        CloseLayerReload:function (tableid) {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
            parent.layui.table.reload(tableid,'data');
        },

        /**
         * 关闭父级页面
         */
        CloseLayer:function () {
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        },

        /**
         * //刷新父页面
         */
        CloseFa:function () {
            parent.location.reload();
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        },

        /**
         * 表格重载
         * @param tableid
         * @constructor
         */
        CreateReload:function (tableid) {
            //执行重载
            layui.table.reload(tableid,{where:{}},'data');
        },

        /**
         * 表单提交数据
         * @param url
         * @param data
         * @param tablid
         * @param is_close
         * @constructor
         */
        FormSubmit:function (url,data,tablid=0,is_close=0) {
            $.ajax({
                url:url,
                type:'post',
                data:data,
                error: function(error) {
                    layer.msg("服务器错误或超时");
                    return false;
                },
                beforeSend:function(){
                    layer.load(2);
                },
                success:function(data)
                {
                   // console.log(data);
                    if (data.code==1) {
                        if(is_close!=0 && tablid!=0){
                            layer.msg(data.msg,{icon: 1, time: 1500,shade:0.3, anim: 4});
                            setTimeout(function(){
                                lucky.CloseLayerReload(tablid); //重载父页面表格
                            },500);

                        }else if(is_close!=0){
                            layer.msg(data.msg,{icon: 1, time: 1500,shade:0.3, anim: 4});
                            setTimeout(function(){
                                lucky.CloseLayer();//不重载父页面表格
                            },500);

                        }else if (tablid!=0){
                            layer.msg(data.msg,{icon: 1, time: 1500,shade:0.3, anim: 4});
                            setTimeout(function(){
                                lucky.CreateReload(tablid); //重载当前页面的表格
                            },500);

                        } else {
                            layer.msg(data.msg,{icon: 1, time: 1500,shade:0.3, anim: 4},function () {
                                location.reload();
                            });
                        }
                    }else{
                        layer.msg(data.msg,{icon:15,time:1500,shade:0.3,anim:4});
                    }
                },
                complete:function(){
                    layer.closeAll('loading');
                }
            });
        },

        /**
         * 弹窗
         * @param title
         * @param w
         * @param h
         * @param url
         * @param tableid
         * @param close
         * @param fulls
         * @constructor
         */
        CreateForm:function (title,w,h,url,tableid=0,close=0,fulls=0) {
            title?title:'管理界面';
            w?w:'40%';
            h?h:'60%';
            var full= layer.open({
                title:title,
                type: 2,
                area: [w, h],
                // offset:'40px',
                offset:'auto',
                maxmin : true,
                skin:'layui-layer-molv',
                shade: 0.5,
                content: url,
                success:function(){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3,time:1000
                        });
                    },500)
                },
                end: function () {
                    if (tableid==0){
                        console.log(tableid);
                    }else if(close!=0){
                        location.reload();
                    }
                    else {
                        setTimeout(function(){
                            lucky.CreateReload(tableid);//重载表格
                        },500);
                    }
                }
            });
            if (fulls==0){
            }else {
                layer.full(full); //最大化
            }
        },

        /**
         * 恢复数据
         * @param ids
         * @param URL
         * @param tableid
         * @returns {boolean}
         */
        Recycle_data:function (ids,URL,tableid) {
            if($.isArray(ids))
            {
                ids = ids.join(',');
            }
            if (ids=="")
            {
                layer.msg("没选择任何数据",{time:1500});return false;
            }
            layer.confirm('确定恢复吗？', function(index){
                layer.close(index);
                $.ajax({
                    beforeSend:function(){
                        layer.load(2);
                    },
                    url: URL,
                    type: "POST",
                    async: true,
                    dataType: "json",
                    data:{
                        ids: ids,
                    },
                    error: function(error) {
                        layer.msg("服务器错误或超时");
                        return false;
                    },
                    success: function(data) {
                        if (data.code==1) {
                            layer.msg(data.msg,{icon:1,time:1500,shade:0.3,anim:4});
                            setTimeout(function(){
                                lucky.CreateReload(tableid); //重载表格数据
                            },500);
                        }else{
                            layer.msg(data.msg,{icon:15,time:1500,shade:0.3},function () {
                                lucky.CreateReload(tableid);
                            });
                        }
                    },
                    complete:function(){
                        layer.closeAll('loading');
                    }
                });
            });
        },

        /**
         * 删除操作
         * @param ids
         * @param URL
         * @param tableid
         * @param msg
         * @returns {boolean}
         * @constructor
         */
        Delete_data:function (ids,URL,tableid,msg='确定删除吗？') {
            if($.isArray(ids))
            {
                ids = ids.join(',');
            }
            if (ids=="")
            {
                layer.msg("没选择任何数据",{time:1500});return false;
            }
            layer.confirm(msg, function(index){
                layer.close(index);
                $.ajax({
                    beforeSend:function(){
                        layer.load(2);
                    },
                    url: URL,
                    type: "POST",
                    async: true,
                    dataType: "json",
                    data:{
                        ids: ids,
                    },
                    error: function(error) {
                        layer.msg("服务器错误或超时");
                        return false;
                    },
                    success: function(data) {
                        if (data.code==1) {
                            layer.msg(data.msg,{icon:1,time:1500,shade:0.3,anim:4});
                            setTimeout(function(){
                                lucky.CreateReload(tableid); //重载表格数据
                            },500);
                        }else{
                            layer.msg(data.msg,{icon:15,time:1500,shade:0.3},function () {
                                lucky.CreateReload(tableid);
                            });
                        }
                    },
                    complete:function(){
                        layer.closeAll('loading');
                    }
                });
            });
        },

        Change_status:function (table_id,tablename,id,field,status,this_) {
            $.ajax({
                url:"/admin/Common/ChangeStatus",
                type:'post',
                async: true,
                dataType: "json",
                data:{
                    id:id,
                    table:tablename,
                    field:field,
                    status:status
                },
                error: function(error) {
                    layer.msg("服务器错误或超时");
                    return false;
                },
                beforeSend:function(){
                    layer.load(2);
                },
                success:function(res)
                {
                    //CreateReload(table_id);
                    if (res.code==200) {
                        layer.tips(res.msg,this_, {
                            time: 1000
                        },function () {
                            lucky.CreateReload(table_id);
                        });
                    }else{
                        layer.tips(res.msg,this_, {
                            time: 1000
                        },function () {
                            lucky.CreateReload(table_id);
                        });
                    }
                },
                complete:function(){
                    layer.closeAll('loading');
                }
            });
        },

        /**
         * 创建树菜单
         * @returns {Array}
         * @constructor
         */
        CreateTree:function (rows) {
            var nodes = [];
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                if (!exists(rows, row.pid)) {
                    nodes.push({
                        id: row.id,
                        name: row.name,
                        value:row.value,
                        children:row.children
                    });
                }
            }
            var toDo = [];

            for (var i = 0; i < nodes.length; i++) {
                toDo.push(nodes[i]);
            }

            for (var i = 0; i < nodes.length; i++) {
                toDo.push(nodes[i]);
            }
            while (toDo.length) {
                var node = toDo.shift();   // the parent node
                // get the children nodes
                for (var i = 0; i < rows.length; i++) {
                    var row = rows[i];
                    if (row.pId == node.id) {
                        var child = {id: row.id, name: row.name, pId: node.id,value:row.value,children:row.children};
                        if (node.children) {
                            node.children.push(child);
                        } else {
                            node.children = [child];
                        }
                        toDo.push(child);
                    }
                }
            }
            return nodes;//layui nodes对象
        },
        /**
         *
         * @param rows
         * @param pId
         * @returns {boolean}
         * @constructor
         */
        Exists:function (rows, pId) {
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].id == pId) return true;
            }
            return false;
        }
    };

    /**
     * 输出模块(此模块接口是对象)
     */
    exports('lucky', lucky);

});