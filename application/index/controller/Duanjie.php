<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/8/15-15:28
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Duanjie.php
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


    namespace app\index\controller;


    use service\UtilService;
    use think\Cache;
    use think\Exception;

    class Duanjie extends Base
    {

        protected function _initialize()
        {
            parent::_initialize(); // TODO: Change the autogenerated stub
        }


        /**
         * @return mixed
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: lists
         * @describe:段子視頻
         */
        public function lists(){
            $data=db("duanjie")->order("passtime DESC")->paginate(32);
            $page = $data->render();
            $this->assign('datas',$data);
            $this->assign('page',$page);
            return $this->fetch();
        }


        /**
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: zan
         * @describe:视频点赞
         */
        public function zan(){
            if($this->request->isAjax()){
                $id=$this->request->post("id");
                $this->all_zan("duanjie","up",$id);
            }
        }


    }