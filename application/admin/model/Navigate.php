<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/9-16:31
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Navigate.php
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
    use service\StringService;
    use service\TreeService;
    use service\UtilService;
    use think\Cache;
    use think\Db;
    use think\Exception;
    use think\Url;

    class Navigate extends ModelBase
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
            Navigate::event('after_update', function () {
                Cache::tag('navigate_data')->clear();
            });
            //新增后可用
            Navigate::event('after_insert', function () {
                Cache::tag('navigate_data')->clear();
            });
            //写入后  貌似没用到
            Navigate::event('after_write', function () {
                Cache::tag('navigate_data')->clear();
            });
            //删除后
            Navigate::event('after_delete', function () {
                Cache::tag('navigate_data')->clear();
            });
        }

        /**
         * @param array $param
         * @param string $order
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetNavigateDataPage
         * @describe:获取栏目分页数据
         */
        public function GetNavigateDataPage($param = [], $order = "a.listorder desc")
        {
            $where = [];
            if(!empty($param)) {

                //搜索条件
                if(!empty($param['title'])) {
                    $where['a.title'] = ['like', "%".$param['title']."%"];
                }
            }
            $field = ('a.*,c.name');
            try {
                $data = $this->alias('a')->join('model c', 'a.model_id=c.id')->where($where)->order($order)->field($field)->page(PAGE)->limit(PERPAGE)->select()->toArray();

                $count = count($data);
                $datas = TreeService::toFormatTree($data); //转换成数结构

            } catch (Exception $exception) {
                return JsonService::fail($exception->getMessage());
            }
            return JsonService::result(0, "", $datas, $count);

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
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: addEditData
         * @describe:添加编辑数据
         */
        public function addEditData($data)
        {
            $res=parent::ChangeData($data);
            if(!isset($data['id'])){
                if($data['model_id']!=7) {
                    $fun='lists';
                    if ((int)$data['model_id'] == 6 || (int)$data['pid'] == 0){
                        $fun='index';
                    }
                    $id=$this->id;
                    $this->getUrlToModelId($id,$data['model_id'],$fun);
                }
            }
            return $res;
        }

        /**
         * @param $id
         * @param $model_id
         * @param string $fun
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: getUrlToModelId
         * @describe:生成前台url地址
         */
        public function getUrlToModelId($id,$model_id,$fun='index'){
            $na=Db::name("model")->where("id",$model_id)->find();
            Url::root("/");
            $da = [
                'id'=>$this->id,
                'href'=>url('index/'.$na['tablename'].'/'.$fun,['navigate_id'=>$id]),
                'update_time'=>time()
            ];
            $this->editData($da);
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
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl
         * @name: GetMenuList
         * @describe:获取格式化栏目数据
         */
        public function GetNavigateList($where = [])
        {
            $res = $this->where($where)->order("listorder asc")->select()->toArray();
            if(!empty($res)) {
                foreach($res as $k => $v){
                    $res[$k]['url'] = url($v['href']);
                }
            }
            return $res;
        }


        /**
         * @param $model_id
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetList
         * @describe:根据模型ID查询
         */
        public function GetList($model_id){
            $res = $this->where(["model_id"=>$model_id])->order("listorder asc")->select()->toArray();
            return $res;
        }





        /**
         * @param $id
         * @return int|void
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: del
         * @describe:删除
         */
        public function del($id)
        {
            if(strlen($id) > 1) {
                $ids = @explode(',', $id);
                foreach($ids as $v){
                    $resd = $this->findChild($v);//判断是否有子集
                    if($resd!==true) {
                        return JsonService::fail("ID:【".$v."】该栏目下有子集不能删除！");
                    }
                }
            }
            else {
                $res = $this->findChild($id);//判断是否有子集
                if($res!==true) {
                    return JsonService::fail("该栏目下有子集不能删除！");
                }
            }
            try {
                $del = $this->destroy(['id' => ['in', $id]]);
                return $del;
            } catch (Exception $exception) {

                return JsonService::fail($exception->getMessage());
            }


        }



        /**
         * @param $id
         * @return bool
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: findChild
         * @describe:查找是否有子集
         */
        private function findChild($id)
        {
            $res = TreeService::getChildrenPid($this->GetNavigateList(), $id);
            if(empty($res)) {
                return true;
            }
            else {
                return false;
            }
        }



    }