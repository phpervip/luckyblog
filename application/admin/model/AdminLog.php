<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/16-10:05
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: AdminLog.php
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
    use service\UtilService;
    use think\Exception;

    class AdminLog extends ModelBase
    {



        /**
         * @param array $param
         * @param string $order
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetAdminLogDataPage
         * @describe:获取分页数据
         */
        public function GetAdminLogDataPage($param = [], $order = "id desc")
        {
            $where = [];
            if(!empty($param)) {
                //添加条件

                //搜索条件
                if(!empty($param['admin_name'])) {
                    $where['admin_name|describe'] = ['like', "%".$param['admin_name']."%"];
                }
                if(!empty($param['type'])){
                    $where['type']=$param['type'];
                }
            }

            try {
                $data = $this->where($where)->order($order)->page(PAGE)->limit(PERPAGE)->select()->toArray();

                $count=$this->where($where)->count("id");
               // $count = count($data);

            } catch (Exception $exception) {

                return JsonService::fail($exception->getMessage());
            }
            return JsonService::result(0, "", $data, $count);

        }



    }