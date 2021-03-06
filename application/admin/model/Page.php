<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/24-11:13
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Page.php
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


    use service\JsonService;
    use think\Exception;
    use think\Url;

    class Page extends \think\Model
    {

        protected $insert=["create_time"];

        /**
         * @return false|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: setCreateTimeAttr
         * @describe:
         */
        public function setCreateTimeAttr(){
            return date("Y-m-d H:i:s",time());
        }

        /**
         * @param array $param
         * @param string $order
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetPage
         * @describe:获取分页数据
         */
        public function GetPage($param = [], $order = "id desc")
        {
            $where = [];
            $whre=[];
            if(!empty($param)) {

                //搜索条件
                if(!empty($param['title'])) {
                    $where['a.title'] = $whre['title']=['like', "%".$param['title']."%"];
                }
            }

            try {
                $field = ('a.*,n.title as navigate_title');
                $data = $this->alias("a")->join("navigate n","a.navigate_id=n.id") ->where($where)->order($order)->field($field)->page(PAGE)->limit(PERPAGE)->select()->toArray();

                $count = $this->where($whre)->count("id");

            } catch (Exception $exception) {

                return JsonService::fail($exception->getMessage());
            }
            return JsonService::result(0, "", $data, $count);


        }



        /**
         * @param $data
         * @return false|int
         * @author: hhygyl
         * @name: AddData
         * @describe:添加数据
         */
        public function addData($data)
        {
            $res = $this->isUpdate(false)->allowField(true)->save($data);
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

    }