<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/6/26-14:31
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Index.php
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

    use service\CacheService;
    use service\UtilService;
    use think\Cache;
    use think\Cookie;
    use think\Exception;


    class Index extends SystemBase
    {

        protected function _initialize()
        {
            parent::_initialize(); // TODO: Change the autogenerated stub

        }



        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: index
         * @describe:
         */
        public function index()
        {
            if(Cookie::has(self::$admin_info['id'].self::$admin_info['username'])) { //有锁屏进入锁屏页面
                $this->redirect(url("index/lock"));
                exit;
            }

            return $this->fetch();

        }



        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: home
         * @describe:
         */
        public function home()
        {

            $role_id = self::$admin_info['role_id'];
            isset($role_id) ? $role_id : 0;
            $res = db("admin_role")->where("id", $role_id)->value("rule");

            if(empty($res)) {
                return $this->fetch("public/no_rule");
            }
            else {
                $log = db("admin_log")->order("create_time desc")->limit(8)->select();
                $this->assign("log", $log);

                $this->count_data();//数据统计

                $this->tongji();

                return $this->fetch();
            }
        }



        /**
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: count_data
         * @describe:
         */
        public function count_data(){
            try{
                $article_num=db("article")->where("status",1)->count("id"); //文章总数
                $users_num=db("users")->count("id"); //用户总数
                $feedback_num=db("feedback")->where(['status'=>1,'pid'=>0])->count("id"); //留言总数
                $yuju_num=db("yuju")->where("status",1)->count("id"); //名言名句
                $shen_ping=db("comment")->where("status",2)->count("id"); //待审核评论
                $shen_feedback=db("feedback")->where("status",2)->count("id"); //待审核留言
                $shen_article=db("article")->where("status",3)->count("id"); //待发布文章
                $duan_num=db("duanjie")->count("id"); //采集数据

                $liuyan = db("feedback")->where(['pid'=>0])->order("create_time desc")->limit(5)->select();


            }catch (Exception $exception){

            }

            $this->assign(compact("article_num","users_num","feedback_num","yuju_num","shen_ping","shen_article","shen_feedback","duan_num","liuyan"));

        }


        /**
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: tongji
         * @describe:
         */
        public function tongji(){
            $res= db("ip_count")->field("month,SUM(nums) as number")->where("year",2019)->group("month")->select();
            $houdata=array();

            if ($res){
                for ($i=0;$i<12;$i++){
                    $houdata[$i]=0;
                    foreach ($res as $k=>$t){
                        if($t['month']==$i+1){
                            $houdata[$i]=(int)$t['number'];
                        }
                    }
                }
                $houdata=json_encode($houdata);
            }else{
                for ($i=0;$i<12;$i++){
                    $houdata[$i]=0;
                }
                $houdata=json_encode($houdata);
            }
            $this->assign("tongji",$houdata);
        }


        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: lock_pass
         * @describe:设置锁屏密码
         */
        public function lock_pass()
        {
            if($this->request->isPost()) {
                $Pass = $this->request->post("pass");
                if(empty($Pass)) {
                    $this->error("锁屏密码不能为空");
                }
                Cookie::set(self::$admin_info['id'].self::$admin_info['username'], $Pass);//保存锁屏密码
                $this->success("锁屏成功");
            }
        }




        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: lock
         * @describe:锁屏页面
         */
        public function lock()
        {
            if(!Cookie::has(self::$admin_info['id'].self::$admin_info['username'])) { //解锁完毕
                $this->redirect(url("index/index"));
                exit;
            }
            return $this->fetch();
        }



        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: pass_lock
         * @describe:使用登录密码解锁
         */
        public function pass_lock()
        {
            if($this->request->isPost()) {
                $Pass = $this->request->post("password");
                if(empty($Pass)) {
                    $this->error("管理员登录密码不能为空");
                }

                if(UtilService::think_decrypt(self::$admin_info['password'])==$Pass) {
                    Cookie::delete(self::$admin_info['id'].self::$admin_info['username']); //清除解锁密码
                    $this->success("解锁成功");
                }
                else {
                    $this->error("管理登录密码错误！");
                }
            }
        }

        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: unlock
         * @describe:解锁
         */
        public function unlock()
        {
            if($this->request->isPost()) {
                $Pass = $this->request->post("pass");
                if(empty($Pass)) {
                    $this->error("锁屏密码不能为空");
                }

                $lockpass = Cookie::get(self::$admin_info['id'].self::$admin_info['username']);
                if($lockpass==$Pass) {
                    Cookie::delete(self::$admin_info['id'].self::$admin_info['username']); //清除解锁密码
                    $this->success("解锁成功");
                }
                else {
                    $this->error("锁屏密码错误！");
                }
            }
        }


        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: cache_clear
         * @describe:刷新系统缓存
         */
        public function cache_clear(){
            if($this->request->isPost()) {
                $Pass = $this->request->post("name");
                if(empty($Pass)) {
                    $this->error("清除失败");
                }

                   $type=config("cache.type");
                   if($type=="redis"){
                       Cache::tag('album_data')->clear();
                       Cache::tag('article_data')->clear();
                       Cache::tag('navigate_data')->clear();
                   }else{
                       clear_cache();//清除缓存文件
                   }
                    clear_log(); //清除系统日志
                    clear_temp();//清除系统模板文件
                    $this->success();

            }

        }



    }