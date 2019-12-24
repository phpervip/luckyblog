<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/24-16:59
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

    namespace app\admin\model;


    use app\common\model\ModelBase;
    use service\JsonService;
    use service\TreeService;
    use service\UtilService;
    use think\Exception;

    class Comment extends ModelBase
    {

        protected $update = ["update_time"];


        /**
         * @return mixed
         * @author: hhygyl
         * @name: setUpdateTimeAttr
         * @describe:
         */
        protected function setUpdateTimeAttr()
        {
            return time();
        }


        /**
         * @param array $param
         * @param string $order
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetPage
         * @describe:获取分页数据
         */
        public function GetCommentDataPage($param = [], $order = "a.status ,a.id desc")
        {
            $where = [];
            $whre=[];
            if(!empty($param)) {

                //搜索条件
                if(!empty($param['title'])) {
                    $where['a.content'] = $whre['content']=['like', "%".$param['title']."%"];
                }
            }

            try {
                $field = ('a.*,t.title as article_title,u.username as users_name');
                $data = $this->alias("a")
                    ->join("users u","a.users_id=u.id","LEFT")
                    ->join("article t","a.article_id=t.id","LEFT")
                    ->where($where)->order($order)->field($field)->page(PAGE)
                    ->limit(PERPAGE)->select()->toArray();

                if($data){
                    $data=TreeService::toFormatTree($data,"users_name"); //格式化数据
                }
                $count = $this->where($whre)->count("id");

            } catch (Exception $exception) {

                return JsonService::fail($exception->getMessage());
            }
            return JsonService::result(0, "", $data, $count);

        }



        /**
         * @param $data
         * @return false|int
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: save_data
         * @describe:文章评论
         */
        public function save_data($data){
            $user_id=db("users")->where("qq",$data['qq'])->value("id");
            $data['users_id']=$user_id;
            //dump($user_id);die;
            $data['browse']=UtilService::getBrowser();//浏览器
            $res=$this->allowField(true)->isUpdate(false)->save($data);
            return $res;
        }

        /**
         * @param $aid
         * @return \think\Paginator
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: admin_article_comments
         * @describe:文章相关评论
         */
        public function admin_article_comments($aid){
            $field = ('a.*,u.username as users_name,u.image');
            $data = $this->alias("a")
                ->join("users u","a.users_id=u.id","LEFT")
                ->where(['a.article_id'=>$aid,"a.status"=>1,"a.pid"=>0])->order("create_time desc")->field($field)->paginate(6);
            return $data;
        }





        /**
         * @param $id
         * @return int|void
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: check_ok
         * @describe:批量审核
         */
        public function check_ok($id)
        {
            try {
                $del = $this->where(['id' => ['in', $id]])->setField(['status'=>1,'check_time'=>date("Y-m-d H:i:s",time())]);//批量审核通过
                return $del;
            } catch (Exception $exception) {

                return JsonService::fail($exception->getMessage());
            }
        }


        /**
         * @param $id
         * @return Comment|void
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: ZanComment
         * @describe:评论点赞
         */
        public function ZanComment($id){
            try{
                $res=$this->where("id",$id)->setInc("zan"); //点赞加一
                return $res;
            }catch (Exception $exception){
                return JsonService::fail($exception->getMessage());
            }
        }



    }