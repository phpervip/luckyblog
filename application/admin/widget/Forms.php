<?php
/**
 * Created by PhpStorm.
 * 版权所有: 2019~2022 [ hhygyl ]
 * Date: 2019/7/30-16:51
 * Link: http://luckyadmin.luckyhhy.cn
 * FileName: FormsWidget.php
 * Keys: ctrl+alt+L/ctrl+s(代码格式化) ctrl+J(代码提示) ctrl+R(替换)ALT+INSERT(生成代码(如GET,SET方法,构造函数等) , 光标在类中才生效)
 * CTRL+ALT+O (优化导入的类和包 需要配置) SHIFT+F2(高亮错误或警告快速定位错误)
 * CTRL+SHIFT+Z(代码向前) CTRL+SHIFT+/ (块状注释) ctrl+shift+enter(智能完善代码 如if())
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

namespace app\admin\widget;
use think\Controller;

class Forms  extends Controller
{


    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }



    /**
     * @param $data
     * @param $parame
     * @param $check_id
     * @return bool|mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: Radio
     * @describe:radio
     */
    public function Radio($data,$parame,$check_id){
        if(!is_array($data)){
            return false;
        }
        $parm=@explode("|",$parame);
        $this->assign([
            'radio'=>$data,
            'check_ID'=>$check_id,
            'name'=>$parm[0],
            'label'=>$parm[1],
            'word'=>isset($parm[2])?$parm[2]:"",
        ]);

        return $this->fetch("widget/radio");
    }

    /**
     * @param $name
     * @param $laber
     * @param $pla
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: Search
     * @describe:搜索框
     */
    public function Search($name,$laber,$pla){
        $this->assign([
           'name'=>$name,
           'laber'=>$laber,
           'pla'=>$pla
        ]);

        return $this->fetch("widget/search");
    }


    /**
     * @param $filter
     * @param $id
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: table
     * @describe:表格
     */
    public function table($filter="tableFilter",$id="tableFilter"){
        $this->assign([
            'tableFilter'=>empty($filter)?"tableFilter":$filter,
            'id'=>empty($id)?"tableFilter":$id,
        ]);
        return $this->fetch("widget/table");

    }

    /**
     * @param $title
     * @param int $t
     * @param string $type
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: Addbtn
     * @describe:添加按钮
     */
    public function Addbtn($title="添加",$t=1,$type="add"){
        $this->assign([
            'title'=>$title,
            't'=>$t,
            'type'=>$type
        ]);
        return $this->fetch("widget/addbtn");
    }


    /**
     * @param string $type
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: reload
     * @describe:刷新
     */
    public function reload($type='reload'){
        $this->assign([
            'type'=>$type
        ]);
        return $this->fetch("widget/reload");
    }


    /**
     * @param string $title
     * @param int $t
     * @param string $type
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: Delbtn
     * @describe:删除
     */
    public function Delbtn($title="删除",$t=1,$type="del"){
        $this->assign([
            'title'=>$title,
            't'=>$t,
            'type'=>$type
        ]);
        return $this->fetch("widget/delbtn");
    }



    /**
     * @param string $title
     * @param string $type
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: Editbtn
     * @describe:编辑按钮
     */
    public function Editbtn($title="编辑",$type="edit"){
        $this->assign([
            'title'=>$title,
            'type'=>$type
        ]);
        return $this->fetch("widget/editbtn");
    }


    /**
     * @param $idStr
     * @param $textStr
     * @param $selectId
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: switchCheck
     * @describe:SWITCH组件开关
     */
    function switchCheck($idStr, $textStr, $selectId)
    {
        //渲染界面
        $this->assign('idStr',$idStr);
        $this->assign('textStr',$textStr);
        $this->assign("selectId",$selectId);
        return $this->fetch("widget/switch_checked");
    }

    /**
     * @param $param
     * @param $list
     * @param $selectId
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: singleSelect
     * @describe:下拉单选
     */
    function singleSelect($param, $list, $selectId)
    {
        $arr = explode('|', $param);

        //参数
        $idStr = $arr[0];
        $isV = $arr[1];
        $msg = $arr[2];
        $show_name = $arr[3];
        $show_value = $arr[4];

        $this->assign('idStr',$idStr);
        $this->assign('isV',$isV);
        $this->assign('msg',$msg);
        $this->assign('show_name',$show_name);
        $this->assign('show_value',$show_value);
        $this->assign('dataList',$list);
        $this->assign("selectId",$selectId);
        return $this->fetch("widget/single_select");
    }


    /**
     * @param $filter
     * @param $btnname
     * @param $cz
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: submit
     * @describe:提交按钮
     */
    public function submit($filter,$btnname,$cz=1){

        $this->assign('filter',$filter);
        $this->assign('cz',$cz);
        $this->assign("btnname",$btnname);
        return $this->fetch("widget/submit");
    }

    /**
     * @param $param
     * @param int $width
     * @param int $height
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: Upthumb
     * @describe:上传缩略图
     */
    public function Upthumb($param,$value,$width=250,$height=400,$xuan=2){
        $arr = explode('|', $param);
        //参数
        $name = $arr[0];
        $value = $value;
        $label = $arr[1];
        $placeholder = empty($arr[2])? '': $arr[2];
        $verify = empty($arr[3])? '': $arr[3];
        $btn= empty($arr[4])? '上传图片': $arr[4];

       // dump($arr);
        $this->assign('name',$name);
        $this->assign('value',$value);
        $this->assign('label',$label);
        $this->assign('placeholder',$placeholder);
        $this->assign('verify',$verify);
        $this->assign('btn',$btn);
        $this->assign('width',$width);
        $this->assign('heig',$height);
        $this->assign('xuan',$xuan);

       return $this->fetch('widget/upthumb');
    }


    /**
     * @param $name
     * @param $imgUrl
     * @param string $size
     * @param string $nameStr
     * @param string $sizeStr
     * @param string $cropSize
     * @param string $cropRate
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: uploadImg
     * @describe:上传图片裁剪
     */
    function uploadImg($name, $imgUrl, $size='100x100', $nameStr='', $sizeStr='', $cropSize='300x300', $cropRate='')
    {
        $size 	= $size ? $size : '100x100'; //默认尺寸 100x100
        $nameStr = $nameStr ? $nameStr : "图片";
        $isCrop = $cropSize ? 1 : 2;
        $cropSize = $cropSize ? $cropSize : '300x300'; //默认裁剪尺寸 300x300
        $cropRate = $cropRate ? $cropRate : 1/1;

        //长宽
        $itemArr = explode('x', $size);
        //裁剪尺寸
        $cropArr = explode('x', $cropSize);

        $this->assign('name', $name);
        $this->assign('imgUrl', $imgUrl);
        $this->assign('img', $imgUrl);
        $this->assign('imgW', $itemArr[0]);
        $this->assign('imgH', $itemArr[1]);
        $this->assign('nameStr',$nameStr);
        $this->assign('sizeStr',$sizeStr);
        $this->assign('cropW',$cropArr[0]);
        $this->assign('cropH',$cropArr[1]);
        $this->assign('cropRate',$cropRate);
        $this->assign('isCrop',$isCrop);
        return $this->fetch("widget/upload_singleImg");
    }



    /**
     * @param $name
     * @param $imageList
     * @param $imgMsg
     * @param $size
     * @param int $maxNum
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: uploadMultImg
     * @describe:多图上传
     */
    function uploadMultImg($name, $imageList, $imgMsg, $size, $maxNum=9)
    {
        //字段名称
        $name = isset($name) ? trim($name) : 'file';
        //长宽
        $size 	= isset($size) ? trim($size) : '100x100'; //图片尺寸  100 x 100
        $sizeArr = explode('x', $size);
        //最大上传张数
        $maxNum = $maxNum ? $maxNum : 5;//默认上传5张

        $this->assign('name', $name);
        $this->assign('maxNum',$maxNum);
        $this->assign('imgMsg',$imgMsg);
        $this->assign('imgW', $sizeArr[0]);
        $this->assign('imgH', $sizeArr[1]);
        $this->assign('imageList',$imageList);
        return $this->fetch("widget/upload_multipleImg");
    }



    /**
     * @param $param
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: Ueditor
     * @describe:百度编辑器
     */
    public function Ueditor($param,$value=''){
        $arr = explode('|', $param);
        //参数
        $name = $arr[0];
        $laber = $arr[1];
        $placeholder = empty($arr[2])? $laber: $arr[2];
        $ud_height = empty($arr[3])? '420': $arr[3];
        $this->assign('name', $name);
        $this->assign('laber',$laber);
        $this->assign('placeholder',$placeholder);
        $this->assign('ud_height', $ud_height);
        $this->assign('value', $value);
        return $this->fetch("widget/ueditor");
    }



    /**
     * @param $param
     * @param $value
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: Layedit
     * @describe:layui edit
     */
    public function Layedit($param,$value,$hg=200){
        $arr = explode('|', $param);

        $name=empty($arr[0])?'content':$arr[0];
        $laber=empty($arr[1])?'内容':$arr[1];
        $placeholder = empty($arr[2])? $laber: $arr[2];
        $id= empty($arr[3])? rand(1,8): $arr[3];
        $verify=isset($arr[4])?$arr[4] :'';
        $lay_height=$hg;

        $this->assign('name', $name);
        $this->assign('laber',$laber);
        $this->assign('placeholder',$placeholder);
        $this->assign('id', $id);
        $this->assign('verify', $verify);
        $this->assign('lay_height', $lay_height);
        $this->assign('value',$value);
        return $this->fetch("widget/layedit");
    }



    /**
     * @param $name
     * @param $imageurl
     * @param $verify
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: Webuploader
     * @describe:webupload 图片上传
     */
    public function Webuploader($name,$imageurl,$verify){
        $this->assign('name', empty($name) ? 'imgs':$name); //图片存储的表单name值
        $this->assign('imageurl',empty($imageurl)? 'images':$imageurl);
        $this->assign('verify',$verify);
        return $this->fetch("widget/webuploader");
    }






}