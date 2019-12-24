<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/19-15:32
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Article.php
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
    use think\Cache;
    use think\Exception;
    use think\Url;

    class Article extends ModelBase
    {

        protected $update = ["update_time"];

        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: init
         * @describe:模型添加清除缓存
         */
        protected static function init()
        {
            //编辑后可用
            Article::event('after_update', function () {
                Cache::tag('article_data')->clear();
            });
            //新增后可用
            Article::event('after_insert', function () {
                Cache::tag('article_data')->clear();
            });
            //写入后  貌似没用到
            Article::event('after_write', function () {
                Cache::tag('article_data')->clear();
            });
            //删除后
            Article::event('after_delete', function () {
                Cache::tag('article_data')->clear();
            });
        }



        /**
         * @param array $param
         * @param string $order
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetArticleDataPage
         * @describe:获取分页数据
         */
        public function GetArticleDataPage($param = [], $order = "id desc")
        {
            $where = [];
            $whre=[];
            if(!empty($param)) {
                //搜索条件
                if(!empty($param['title'])) {
                    $where['a.title|a.describe'] = $whre['title|describe']=['like', "%".$param['title']."%"];
                }
                if(!empty($param['navigate_id'])){
                    $where['a.navigate_id']=$whre['navigate_id']=$param['navigate_id'];
                }
            }

            try {
                $field = ('a.*,n.title as navigate_title');
                $data = $this->alias("a")->join("navigate n","a.navigate_id=n.id","LEFT") ->where($where)->order($order)->field($field)->page(PAGE)->limit(PERPAGE)->select()->toArray();

                $count = $this->where($whre)->count("id");

            } catch (Exception $exception) {

                return JsonService::fail($exception->getMessage());
            }
            return JsonService::result(0, "", $data, $count);

        }


        /**
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetNavigateArticle
         * @describe:查询文章模型的栏目
         */
        public function GetNavigateArticle(){
            $navigate=new Navigate();
            return $navigate->where("model_id",1)->order("create_time")->select()->toArray();
        }


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
         * @param $data
         * @return false|int
         * @author: hhygyl
         * @name: AddData
         * @describe:添加编辑数据
         */
        public function addEditData($data)
        {
             $res=parent::ChangeData($data);
             if(!isset($data['id'])){
                 Url::root("/");
                 $da = [
                     'id'=>$this->id,
                     'url'=>url('index/article/show',['id'=>$res['id'],'navigate_id'=>$data['navigate_id']]),
                     'update_time'=>time()
                 ];
                 $this->editData($da);
             }
             return $res;
        }

        /**
         * @param $params
         * @return false|int
         * @author: hhygyl
         * @name: editData
         * @describe:修改数据
         */
        public function editData($params)
        {
            $res = $this->isUpdate(true)->allowField(true)->save($params);
            return $res;
        }


        /**
         * @param $id
         * @return int|true
         * @throws Exception
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: Hits
         * @describe:点击量加1
         */
        public function Hits($id)
        {
            return $this->where("id", $id)->setInc("hits");
        }




    }