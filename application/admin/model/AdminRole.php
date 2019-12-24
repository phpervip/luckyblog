<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/5-15:17
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: AdminRole.php
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
    use think\Db;
    use think\Exception;

    class AdminRole extends ModelBase
    {

        protected $update = ["update_time"];


        /**
         * @param string $param
         * @param string $order
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetAdminMemberDataPage
         * @describe:获取角色分页数据
         */
        public function GetAdminRoleDataPage($param = [], $order = "id")
        {
            $where = [];
            if(!empty($param)) {
                //搜索条件
                if(!empty($param['name'])) {
                    $where['name'] = ['like', "%".$param['name']."%"];
                }
            }

            try {
                $data = $this->where($where)->order($order)->page(PAGE)->limit(PERPAGE)->select()->toArray();
                $count =$this->where($where)->count("id");

                if(!empty($data)) {
                    foreach($data as $k => $v){

                        if((int)$v['id']==1){  //超级管理
                            $data[$k]['auth'] = "All";
                        }else{
                            $ids = StringService::string2array($v['rule']);
                            $ds  = Db::name("admin_menu")->where(["id" => ["in", $ids]])->column("title");
                            if(!empty($ds)) {
                                $caidan = implode(",", $ds);
                            }
                            else {
                                $caidan = "";
                            }
                            $data[$k]['auth'] = $caidan;
                        }

                    }
                }

                $datas = TreeService::toFormatTree($data, "name"); //转换成数结构

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
         * @return false|int
         * @author: hhygyl
         * @name: AddData
         * @describe:添加编辑数据
         */
        public function addEditData($data)
        {
            return parent::ChangeData($data);
        }


        /**
         * @return array|false|string
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetAll
         * @describe:获取所有角色
         */
        public function GetAllJson()
        {
            $res = $this->where(['status' => 1])->select()->toArray();
            if(empty($res)) {
                $resd = [];
            }
            else {
                foreach($res as $k => $v){
                    $res[$k]['title'] = $v['name'];
                }
                $resd = json_encode(TreeService::DeepTree($res), true);
            }
            return $resd;
        }


        /**
         * @param array $where
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetRoleList
         * @describe:获取角色
         */
        public function GetRoleList($where = [])
        {
            $res = $this->where($where)->order("id asc")->select()->toArray();
            return $res;
        }



        /**
         * @param $id
         * @return int
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: del
         * @describe:角色删除，真实
         */
        public function del($id)
        {
            if(strlen($id) > 1) {
                $ids = @explode(',', $id);
                foreach($ids as $v){
                    $resd = $this->findChild($v);//判断是否有子集
                    if($resd!==true) {
                        return JsonService::fail("ID:【".$v."】该角色下有子集不能删除！");
                    }
                }
            }
            else {
                $res = $this->findChild($id);//判断是否有子集
                if($res!==true) {
                    return JsonService::fail("该角色下有子集不能删除！");
                }
            }
            try {
                $del = $this->destroy(['id' => ['in', $id]], true);
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
            $res = TreeService::getChildrenPid($this->GetRoleList(), $id);
            if(empty($res)) {
                return true;
            }
            else {
                return false;
            }
        }



    }