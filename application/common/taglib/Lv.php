<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/8/9-16:12
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Qb.php
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


    namespace app\common\taglib;


    use think\template\TagLib;

    class Lv extends  TagLib
    {
        /**
         * 定义标签列表
         */
        protected $tags   =  [
            // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
            'inputform'=>array('attr'=>'label,value,name,id,place,verify,word,type,style,lang,class','close'=>0),
            'input'=>array('attr'=>'value,name,id,place,verify,type,style,class','close'=>0),
            'textarea'=>array('attr'=>'value,name,verify,style,class,place','close'=>0),
            'nav'       => array('attr' => 'name,table', 'close' => 1), //获取导航
            'link'		=> array('attr' => 'where,table,id,field,order,limit' , 'close' => 1),//友情链接
            'article'   =>array('attr' => 'table,where,order,limit,id,field,cate_id','close' => 1,'level'=>3),//
            'list'   =>array('attr' => 'table,where,order,limit,id,field','close' => 1,'level'=>3),//列表
            'hhy'   =>array('attr' => 'table,where,order,limit,id,field','close' => 1,'level'=>3),//列表
        ];


        /**
         * @param $tag
         * @param $content
         * @return string
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: tagnav
         * @describe:首页导航
         */
        public function tagNav($tag, $content){
            if(empty($tag['table'])){
                $table='navigate';
            }else{
                $table=$tag['table'];
            }
            $parse  = $parse   = '<?php ';
            $parse .= '$__NAV__ = db(\''.$table.'\')->alias("a")->join(\'model c\', \'a.model_id=c.id\')->where("a.status=1")->field("a.*,c.name,c.tablename")->order(\'a.listorder DESC,a.create_time asc\')->select();';
            $parse .= '$__NAV__ = list_to_tree($__NAV__);';
            $parse .= 'foreach ($__NAV__ as $key => $'.$tag['name'].') {';
            $parse .= '?>';
            $parse .= $content;
            $parse .= '<?php } ?>';
            return $parse;
        }


        /**
         * @param $tag
         * @param $content
         * @return string
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: tagarticle
         * @describe:相关文章
         */
        public function tagarticle($tag,$content){
            $name     = !empty($tag['table']) ? $tag['table'] : 'article';
            $field     = !empty($tag['field ']) ? $tag['field '] : '*';
            $map     = !empty($tag['where']) ? $tag['where'] : '';
            $limit        = empty($tag['limit']) ? 6 : $tag['limit'];
            $order        = empty($tag['order']) ? 'id desc' : $tag['order'];

            $str='';
            if(!empty($tag['cate_id'])){
                $str=" and navigate_id= <?php echo ".$tag['cate_id']."?>";
            }
            $where[] = "status = 1 ".$str;
            if ($map) {
                $where[] = $map;
            }
            $map = implode(" and ", $where);

            $parse  = $parse   = '<?php ';
            $parse .= '$__LIST__ = db(\''.$name.'\')->where(\''.$map.'\')->field(\''.$field.'\')->limit(\''.$limit.'\')->order(\''.$order.'\')->select();';
            $parse .= 'foreach ($__LIST__ as $key => $'.$tag['id'].') {';
            $parse .= '?>';
            $parse .= $content;
            $parse .= '<?php } ?>';
            return $parse;
        }


        /**
         * @param $tag
         * @param $content
         * @return string
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: taghhy
         * @describe:
         */
        public function taghhy($tag,$content){
            $name     = !empty($tag['table']) ? $tag['table'] : 'article';
            $field     = !empty($tag['field ']) ? $tag['field '] : '*';
            $map="";
            if(!empty($tag['where'])){
                $map=$tag['where'];
            }
            $limit        = empty($tag['limit']) ? 10 : $tag['limit'];
            $order        = empty($tag['order']) ? 'id desc' : $tag['order'];

            $where=[];
            if ($map) {
                $where[] = $map;
            }
            $map = implode(" and ", $where);

            $parse  = $parse   = '<?php ';
            $parse .= '$__LIST__ = db(\''.$name.'\')->where(\''.$map.'\')->field(\''.$field.'\')->limit(\''.$limit.'\')->order(\''.$order.'\')->select();';
            $parse .= 'foreach ($__LIST__ as $key => $'.$tag['id'].') {';
            $parse .= '?>';
            $parse .= $content;
            $parse .= '<?php } ?>';
            return $parse;
        }

        /**
         * @param $tag
         * @param $content
         * @return string
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: taglist
         * @describe:针对各种表格数据查询
         */
        public function taglist($tag,$content){
            $name     = !empty($tag['table']) ? $tag['table'] : 'article';
            $field     = !empty($tag['field ']) ? $tag['field '] : '*';
            $map="";
            if(!empty($tag['where'])){
                $map=$tag['where'];
            }
            $limit        = empty($tag['limit']) ? 10 : $tag['limit'];
            $order        = empty($tag['order']) ? 'id desc' : $tag['order'];

            $where[] = "status = 1 ";
            if ($map) {
                $where[] = $map;
            }
            $map = implode(" and ", $where);

            $parse  = $parse   = '<?php ';
            $parse .= '$__LIST__ = db(\''.$name.'\')->where(\''.$map.'\')->field(\''.$field.'\')->limit(\''.$limit.'\')->order(\''.$order.'\')->select();';
            $parse .= 'foreach ($__LIST__ as $key => $'.$tag['id'].') {';
            $parse .= '?>';
            $parse .= $content;
            $parse .= '<?php } ?>';
            return $parse;
        }

        /**
         * @param $tag
         * @param $content
         * @return string
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: taglink
         * @describe:友情链接
         */
        public function taglink($tag, $content){
            $name     = !empty($tag['table']) ? $tag['table'] : 'friendlink';
            $field     = empty($tag['field']) ? '*' : $tag['field'];
            $limit        = empty($tag['limit']) ? 20 : $tag['limit'];
            $order        = empty($tag['order']) ? "id desc" : $tag['order'];
            $map     = !empty($tag['where']) ? $tag['where'] : '';
            $where[] = "status=1";
            if ($map) {
                $where[] =  $map;
            }
            $map = implode(" and ", $where);

            $parse  = $parse   = '<?php ';
            $parse .= '$__LIST__ = db(\''.$name.'\')->where(\''.$map.'\')->field(\''.$field.'\')->limit(\''.$limit.'\')->order(\''.$order.'\')->select();';
            $parse .= 'foreach ($__LIST__ as $key => $'.$tag['id'].') {';
            $parse .= '?>';
            $parse .= $content;
            $parse .= '<?php } ?>';
            return $parse;
        }







        /**
         * @param $tag
         * @return string
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: tagTextarea
         * @describe: 文本域
         */
        public function tagTextarea($tag){
            $class="";
            if(!empty($tag['class'])){ //类名称
                $class=$tag['class'];
            }
            $style="";
            if(!empty($tag['style'])){ //样式
                $style=$tag['style'];
            }
            $ver="";
            if(!empty($tag['verify'])){
                $ver=$tag['verify'];
            }
            $place="";
            if(!empty($tag['place'])){
                $place=$tag['place'];
            }
            $html = "<div class='layui-form-item'>";
            $html .= "<div class='layui-form-label'>".$tag['label']."</div> <div class='layui-input-block input-custom-width'>";
            if (empty($tag['value'])) {
                $html .= "<textarea name='".$tag['name']."' class='layui-textarea ".$class."' lay-verType='tips' lay-reqText='".$place."' autocomplete='off' placeholder='".$place."' lay-verify='".$ver."' style='".$style."'></textarea>";
            } else {
                $html .= "<textarea name='".$tag['name']."'  class='layui-textarea ".$class."' lay-verType='tips' lay-reqText='".$place."'  autocomplete='off' lay-verify='".$ver."' style='".$style."' placeholder='".$place."'>";
                $html .= "<?php echo ".$tag['value']."?>";
                $html .= "</textarea>";
            }
            $html .= "</div>";
            if(!empty($tag['word'])) {
                $html .= " <div class=\"layui-form-mid layui-word-aux\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tag['word']."</div>";
            }
            $html .= "</div>";
            return $html;
        }

        /**
         * @param $tag
         * @return string
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: tagInput
         * @describe:单个 input输入
         */
        public function tagInput($tag){
            if(empty($tag['type'])){ //input 类型
                $type="text";
            }else{
                $type=$tag['type'];
            }
            $style="";
            if(!empty($tag['style'])){ //样式
                $style=$tag['style'];
            }
            $class="";
            if(!empty($tag['class'])){ //类名称
                $class=$tag['class'];
            }
            if(empty($tag['id']) && !isset($tag['id'])){ //ID
                $id="";
            }else{
                $id=$tag['id'];
            }
            $ver="";
            if(!empty($tag['verify'])){
                $ver=$tag['verify'];
            }
            if (empty($tag['value'])) {
                $html='<input type="'.$type.'"  style="'.$style.'" name="'.$tag['name'].'" id="'.$id.'"   value="" placeholder="'.$tag['place'].'" lay-verify="'.$ver.'" lay-verType="tips" lay-reqText="'.$tag['place'].'"  autocomplete="off"  class="layui-input '.$class.'">';
            } else {
                $val=$this->autoBuildVar($tag['value']);
                $html= "<input type='".$type."' name='".$tag['name']."' style='".$style."'  id='".$id."' lay-verify='".$tag['verify']."' lay-verType='tips' lay-reqText='".$tag['place']."' autocomplete='off'  class='layui-input ".$class."'  placeholder='".$tag['place']."' value='";
                $html.= "<?php echo ".$val."?>";
                $html.= "' />";
            }
            return $html;
        }

        /**
         * @param $tag
         * @return string
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: tagInput
         * @describe:input 输入标签
         */
        public function tagInputForm($tag) {
            $html = "<div class=\"layui-form-item\" >";
            $html.="<label class=\"layui-form-label\">".$tag['label']."</label>";
            $val="";
            if(!empty($tag['value'])){ //值
                $val=$this->autoBuildVar($tag['value']);
            }
            $tg="inline";
            if(empty($tag['lang'])){ //行内或者单行
                $tg="block";
            }
            if(empty($tag['type'])){ //input 类型
                $type="text";
            }else{
                $type=$tag['type'];
            }
            if(empty($tag['id']) && !isset($tag['id'])){ //ID
                $id="";
            }else{
                $id=$tag['id'];
            }
            $style="";
            if(!empty($tag['style'])){ //样式
                $style=$tag['style'];
            }
            $class="";
            if(!empty($tag['class'])){ //类名称
                $class=$tag['class'];
            }
            $ver="";
            if(!empty($tag['verify'])){
                $ver=$tag['verify'];
            }

            if($tg=="inline"){
                $html.='<div class="layui-input-inline input-custom-width" style="'.$style.'">';
            }else{
                $html.='<div class="layui-input-block input-custom-width"  style="'.$style.'">';
            }
            if (empty($tag['value'])) {
                $html.='<input type="'.$type.'" name="'.$tag['name'].'" id="'.$id.'"   value="" placeholder="'.$tag['place'].'" lay-verify="'.$ver.'" lay-verType="tips" lay-reqText="'.$tag['place'].'"  autocomplete="off"  class="layui-input '.$class.'">';
            } else {
                $html .= "<input type='".$type."' name='".$tag['name']."' id='".$id."' lay-verify='".$ver."' lay-verType='tips' lay-reqText='".$tag['place']."' autocomplete='off'  class='layui-input ".$class."'  placeholder='".$tag['place']."' value='";
                $html .= "<?php echo ".$val."?>";
                $html .= "' />";
            }
            $html .= "</div>";
            if(!empty($tag['word'])){ //注释
                if($tg=="inline"){
                    $html.='<div class="layui-form-mid layui-word-aux layui-text text-success">'.$tag['word'].'</div>';
                }else{
                    $html.='<div class="layui-form-mid layui-word-aux layui-text text-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$tag['word'].'</div>';
                }
            }
            $html .= "</div>";
            return $html;
        }




    }