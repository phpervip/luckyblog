<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/6/28-11:51
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Menu.php
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
    use think\Exception;

    class AdminMenu extends ModelBase
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
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl
         * @name: GetMenuList
         * @describe:获取格式化菜单数据
         */
        public function GetMenuList($where = [])
        {
            $where['status']=1;
            $res = $this->where($where)->order("listorder asc")->select()->toArray();
            if(!empty($res)) {
                foreach($res as $k => $v){
                    $res[$k]['url'] = url($v['href']);
                }
            }
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
            $res = $this->findChild($id);
            if($res!==true) {
                return JsonService::fail("该菜单下有子集不能删除！");
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
         * @return int
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: del_true
         * @describe:真实删除
         */
        public function del_true($id)
        {
            try {
                $del = $this->destroy(['id' => ['in', $id]], true);
                return $del;
            } catch (Exception $exception) {
                return JsonService::fail($exception->getMessage());
            }
        }


        /**
         * @param $id
         * @return int
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: recycle_true
         * @describe:批量恢复数据
         */
        public function recycle_true($id)
        {
            if(is_array($id)) {
                $ids = @implode(',', $id);
            }
            else {
                $ids = $id;
            }
            try {
                $del = $this->allowField(true)->save(["delete_time" => null, "update_time" => null], ['id' => ['in', $ids]]);
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
            $res = TreeService::getChildrenPid($this->GetMenuList(), $id);
            if(empty($res)) {
                return true;
            }
            else {
                return false;
            }
        }

    }