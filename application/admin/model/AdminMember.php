<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/5-15:14
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: AdminMember.php
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

    class AdminMember extends ModelBase
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
         * @param string $param
         * @param string $order
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetAdminMemberDataPage
         * @describe:获取管理员分页数据
         */
        public function GetAdminMemberDataPage($param = [], $order = "id desc")
        {
            $where = [];
            $whre=[];
            if(!empty($param)) {
                //添加条件

                //栏目id
                if(isset($param['role_id']) && $param['role_id']!=0) {
                    $where['a.role_id'] = ['eq', $param['role_id']];
                    $whre['role_id']=['eq', $param['role_id']];
                }
                //搜索条件
                if(!empty($param['search'])) {
                    $where['a.username|a.nickname'] = ['like', "%".$param['search']."%"];
                    $whre['username|nickname']= ['like', "%".$param['search']."%"];
                }
            }

            $field = ('a.*,c.name as role_name');

            try {
                $data = $this->alias('a')->join('admin_role c', 'a.role_id=c.id')->where($where)->order($order)->field($field)->page(PAGE)->limit(PERPAGE)->select()->toArray();

                $count = $this->where($whre)->count("id");

                if(!empty($data)) {
                    foreach($data as $k => $v){
                        $data[$k]['pwd'] = UtilService::think_decrypt($v['password']);
                    }
                }

            } catch (Exception $exception) {
                return JsonService::fail($exception->getMessage());
            }
            return JsonService::result(0, "", $data, $count);

        }




    }