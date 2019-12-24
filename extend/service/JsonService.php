<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/6/26-15:22
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: JsonService.php
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

    namespace  service;

    class JsonService
    {
        private static $SUCCESSFUL_DEFAULT_MSG = 'ok';

        private static $FAIL_DEFAULT_MSG = 'no';

        /**
         * @param $code
         * @param StringService $msg
         * @param array $data
         * @param int $count
         * @author: hhygyl
         * @name: result
         * @describe:以json格式返回数据
         */
        public static function result($code,$msg='',$data=[],$count=0)
        {
            exit(json_encode(compact('code','msg','data','count')));
        }


        /**
         * @param int $count
         * @param array $data
         * @param StringService $msg
         * @author: hhygyl
         * @name: successlayui
         * @describe:layui 数据返回
         */
        public static function successlayui($count=0,$data=[],$msg='')
        {
            if(is_array($count)){
                if(isset($count['data'])) $data=$count['data'];
                if(isset($count['count'])) $count=$count['count'];
            }
            if(false == is_string($msg)){
                $data = $msg;
                $msg = self::$SUCCESSFUL_DEFAULT_MSG;
            }
            return self::result(0,$msg,$data,$count);
        }



        /**
         * @param StringService $msg
         * @param array $data
         * @param int $status
         * @author: hhygyl
         * @name: successful
         * @describe:返回成功数据
         */
        public static function successful($msg = 'ok',$data=[],$status=200)
        {
            if(false == is_string($msg)){
                $data = $msg;
                $msg = self::$SUCCESSFUL_DEFAULT_MSG;
            }
            return self::result($status,$msg,$data);
        }


        /**
         * @param $status
         * @param $msg
         * @param array $result
         * @author: hhygyl
         * @name: status
         * @describe:返回状态
         */
        public static function status($status,$msg,$result = [])
        {
            $status = strtoupper($status);
            if(true == is_array($msg)){
                $result = $msg;
                $msg = self::$SUCCESSFUL_DEFAULT_MSG;
            }
            return self::result(200,$msg,compact('status','result'));
        }


        /**
         * @param $msg
         * @param array $data
         * @author: hhygyl
         * @name: fail
         * @describe:失败
         */
        public static function fail($msg,$data=[])
        {
            if(true == is_array($msg)){
                $data = $msg;
                $msg = self::$FAIL_DEFAULT_MSG;
            }
            return self::result(400,$msg,$data);
        }



        /**
         * @param $msg
         * @param array $data
         * @author: hhygyl
         * @name: success
         * @describe:成功
         */
        public static function success($msg,$data=[])
        {
            if(true == is_array($msg)){
                $data = $msg;
                $msg = self::$SUCCESSFUL_DEFAULT_MSG;
            }
            return self::result(200,$msg,$data);
        }




    }