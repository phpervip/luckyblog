<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/8/20-16:12
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Advice.php
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


    namespace app\admin\model;


    use app\common\model\ModelBase;
    use service\JsonService;
    use think\Exception;

    class Advice extends ModelBase
    {

        protected $update = ["update_time"];


        /**
         * @param string $param
         * @param string $order
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetAdminMemberDataPage
         * @describe:获取分页数据
         */
        public function GetAdminAdviceDataPage($param = [], $order = "id desc")
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

            } catch (Exception $exception) {
                return JsonService::fail($exception->getMessage());
            }
            return JsonService::result(0, "", $data, $count);

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
         * @param $id
         * @return int
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: del
         * @describe:删除
         */
        public function del($id)
        {
            try {
                $del = $this->destroy(['id' => ['in', $id]]);
                return $del;
            } catch (Exception $exception) {
                return JsonService::fail($exception->getMessage());
            }
        }



        /**
         * @param array $where
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: getdatabywhere
         * @describe:
         */
        public function getdatabywhere($where=[]){

            return $this->where($where)->order("id")->select()->toArray();

        }





    }