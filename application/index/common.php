<?php

    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/6/26-14:14
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: common.php
     * Keys: ctrl+alt+L/ctrl+s(代码格式化) ctrl+J(代码提示) ctrl+R(替换)ALT+INSERT(生成代码(如GET,SET方法,构造函数等) , 光标在类中才生效)
     * CTRL+ALT+O (优化导入的类和包 需要配置) SHIFT+F2(高亮错误或警告快速定位错误)
     * CTRL+SHIFT+Z(代码向前) CTRL+SHIFT+/ (块状注释) ctrl+shift+enter(智能完善代码 如if())
     *
     **************************************************************
     *                                                            *
     *   .=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-.       *
     *    |                     ______                     |      *
     *    |                  .-"      "-.                  |      *
     *    |                 /            \                 |      *
     *    |     _          |              |          _     |      *
     *    |    ( \         |,  .-.  .-.  ,|         / )    |      *
     *    |     > "=._     | )(__/  \__)( |     _.=" <     |      *
     *    |    (_/"=._"=._ |/     /\     \| _.="_.="\_)    |      *
     *    |           "=._"(_     ^^     _)"_.="           |      *
     *    |               "=\__|IIIIII|__/="               |      *
     *    |              _.="| \IIIIII/ |"=._              |      *
     *    |    _     _.="_.="\          /"=._"=._     _    |      *
     *    |   ( \_.="_.="     `--------`     "=._"=._/ )   |      *
     *    |    > _.="                            "=._ <    |      *
     *    |   (_/                                    \_)   |      *
     *    |                                                |      *
     *    '-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-='      *
     *                                                            *
     *                    JUST FIND YOUR BUG !                    *
     **************************************************************
     */

    use service\RequestService;
    use service\StringService;
    use service\TreeService;


    /**
     * @param $navigate_id
     * @return mixed|string
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: get_nav_name
     * @describe:获取导航栏目名称
     */
function get_nav_name($navigate_id){
    if($navigate_id==0 ||empty($navigate_id)) return "网站首页";
    return db("navigate")->where("id",$navigate_id)->value("title");
}


    /**
     * @param $navigate_id
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: brand_nav
     * @describe:文章详细页面包屑
     */
function brand_nav($navigate_id){
    if($navigate_id==0 ||empty($navigate_id)) return "";
    $res=db("navigate")->find($navigate_id);
    $str="<span>您现在的位置是：<a href=\"/\">首页</a> &gt;";
    if($res['pid']==0){
       $str.='<a href="javascript:">'.$res['title'].'</a>';
    }else{
        $pname=db("navigate")->where("id",$res['pid'])->value("title");
        $str.='<a href="javascript:" title="'.$pname.'">'.$pname.'</a>&gt; <a href="javascript:" title="'.$res['title'].'">'.$res['title'].'</a>';
    }
    $str.='</span>';
    return $str;
}

    /**
     * @param $title
     * @param $leng
     * @return mixed|string
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: title_str_cut
     * @describe:标题字符串截取
     */
function title_str_cut($title,$leng){
    if(strlen($title) < $leng) return $title;
    return StringService::str_cut($title,$leng);
}


    /**
     * @param $arr
     * @return array|bool
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: list_to_tree
     * @describe:
     */
function list_to_tree($arr){
    if(!is_array($arr)) return false;
    return TreeService::DeepTree($arr);
}


    /**
     * @param $id
     * @return mixed|string
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: comment
     * @describe:是否回复留言
     */
function comment($id){
    $data=db("feedback")->where(['status'=>1,'pid'=>$id])->value("content");
    if(empty($data)){
        return "";
    }
    return $data;
}


    /**
     * @param $id
     * @return array|false|PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: comment_article
     * @describe: 评论回复
     */
function comment_article($id){
    $data=db("comment")->where(['status'=>1,'pid'=>$id])->find();
        if(empty($data)){
            return "";
        }
    return $data;
}


    /**
     * @param $id
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: get_users_ById
     * @describe:根据用户id获取用户名
     */
function get_users_ById($id){
    $data=db("users")->where("id",$id)->value("username");
    return $data;
}


    /**
     * @param $str
     * @param $key
     * @return mixed|string
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: title_replace
     * @describe:文章搜索标题替换
     */
function title_replace($str,$key){
    if(empty($str)) return "";
    return str_replace($key,"<font color='red'>$key</font>",$str);
}

