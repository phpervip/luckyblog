<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/8/16-17:18
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Feedback.php
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

    class Feedback extends Base
    {
        protected function _initialize()
        {
            parent::_initialize(); // TODO: Change the autogenerated stub
        }


        /**
         * @return mixed
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: index
         * @describe:留言列表
         */
        public function index(){
            try{
                $data=db("feedback")->where(['status'=>1,'pid'=>0])->order("create_time desc")->paginate(5);
            }catch (Exception $exception){

            }

            $page=$data->render();
            $this->assign("page",$page);
            $this->assign("data",$data);
            return $this->fetch();
        }


        /**
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: feedsave
         * @describe:留言
         */
        public function feedsave(){
            if($this->request->isPost()){
                $data=$this->request->post();

                //留言被关闭
                if ((int)$this->setting['safe']['home_liuyan']==2){
                    $this->error("留言功能已被站长关闭，敬请期待！");
                }

                $this->chek_user($data['qq']); //检测用户

                //防止频繁留言
                if(Cache::has("qq"."_".$data['qq'])){
                    $this->error("请别频繁留言，谢谢！");
                }
                $data['ip']=UtilService::getip();
                $data['email']=$data['qq']."@qq.com";
                $data['browse']=UtilService::getBrowser();
                $data['content']=GetSensitive($data['content']);
                $data['create_time']=time();
                $data['time_formt']=date("Y-m-d H:i:s",time());
                try{
                    $res=db("feedback")->insert($data);
                    if($res){
                        Cache::set("qq"."_".$data['qq'],$data['content'].$data['qq'],300); //5分钟
                        $this->success("留言成功");
                    }else{
                        $this->error("留言失败");
                    }
                }catch (Exception $exception){
                    $this->error($exception->getMessage());
                }
            }
        }

    }