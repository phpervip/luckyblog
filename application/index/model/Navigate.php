<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/8/14-10:48
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Navigate.php
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


    namespace app\index\model;


    use service\TreeService;
    use think\Model;

    class Navigate extends Model
    {


        /**
         * @return array|mixed
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: indexGetNavigate
         * @describe:获取栏目导航
         */
        public function indexGetNavigate(){
            $cacheName=SYSTEM_NAME.'indexGetNavigate';
            $where=['a.status'=>1];
            $data=cache($cacheName); //获取缓存里面的栏目

           // dump($data);
            if($data == false || is_null($data)){
                $field='a.id,a.model_id,a.pid,a.title,a.href,a.create_time,a.listorder,c.name,c.tablename';
                $data=$this->alias('a')
                     ->join('model c', 'a.model_id=c.id')
                    ->where($where)
                    ->field($field)
                    ->order('a.listorder DESC,a.create_time asc')
                    ->select()
                    ->toArray();

                $data = TreeService::DeepTree($data); //转换成数结构
                cache($cacheName,$data,'','navigate_data'); //存到缓存里面
            }


            return $data;
        }

    }