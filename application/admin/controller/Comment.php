<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/24-17:01
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Comment.php
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

    namespace app\admin\controller;


    use think\Exception;

    class Comment extends SystemBase
    {
        protected $comment;
        protected function _initialize()
        {
            parent::_initialize(); // TODO: Change the autogenerated stub
            $this->comment=new \app\admin\model\Comment();
        }


        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: index
         * @describe:数据展示
         */
        public function index(){
            if($this->request->isAjax()) {
                $param = $this->request->param();//接收参数

                return $this->comment->GetCommentDataPage($param);
            }
            return $this->fetch();
        }



        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: check_ok
         * @describe:评论审核
         */
        public function check_ok(){
            if($this->request->isAjax()){
                $ids=$this->request->post("ids");
                try{
                    $res=$this->comment->check_ok($ids);
                    if($res!==false){
                        $this->AddLogs("审核评论ID【".$ids."】");
                        $this->success("审核成功");
                    }else{
                        $this->error("审核失败");
                    }
                }catch (Exception $exception){
                    $this->error($exception->getMessage());
                }
            }
        }


        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: delete
         * @describe:单个或者多个删除
         */
        public function delete()
        {
            if($this->request->isAjax()) {
                $ids = $this->request->post("ids");
                return $this->DeleteData("comment",$ids);
            }
        }



    }