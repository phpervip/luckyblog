<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/1-14:19
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: CacheService.php
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
     * 缓存处理
     */

    namespace service;

    use think\Cache;
    class CacheService
    {

        protected static $globalCacheName = '_lucky_admin'; //缓存标签

        /**
         * @param $name
         * @param $value
         * @param int $expire
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: set
         * @describe:设置缓存
         */
        public static function set($name, $value, $expire = 3600)
        {
            return self::handler()->set($name,$value,$expire);
        }


        /**
         * @param $name
         * @param $value
         * @param int $expire
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: setNoTag
         * @describe:不设置缓存标签
         */
        public static function setNoTag($name, $value, $expire = 3600){
            return Cache::set($name,$value,$expire);
        }

        /**
         * @param $name
         * @param int $step
         * @return false|int
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: inc
         * @describe:缓存自增长
         */
        public static function inc($name,$step=1){
            return self::handler()->inc($name,$step);
        }

        /**
         * @param $name
         * @param bool $default
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: get
         * @describe:获取缓存
         */
        public static function get($name,$default = false)
        {
            return self::handler()->get($name,$default);
        }


        /**
         * @param $name
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: getNoTag
         * @describe:获取无标签的缓存
         */
        public static function  getNoTag($name){
            return Cache::get($name);
        }





        /**
         * @param $name
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: rm
         * @describe:删除缓存
         */
        public static function rm($name)
        {
            return self::handler()->rm($name);
        }



        /**
         * @param $name
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: rmNoTag
         * @describe:删除无标签缓存
         */
        public static function rmNoTag($name){
            return Cache::rm($name);
        }


        /**
         * @return \think\cache\Driver
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: handler
         * @describe:缓存标签
         */
        public static function handler()
        {
            return Cache::tag(self::$globalCacheName);
        }


        /**
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: clear
         * @describe:清空标签缓存
         */
        public static function clear()
        {
            return Cache::clear(self::$globalCacheName);
        }


        /**
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: clearNoTag
         * @describe:清空所有缓存
         */
        public static function clearNoTag(){
            return Cache::clear();
        }



    }