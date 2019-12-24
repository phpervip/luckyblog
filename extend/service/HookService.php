<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/1-14:36
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: HookService.php
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
     * 行为监控
     */

    namespace service;

     use think\Loader;
     use think\Exception;
     use think\Hook;

    class HookService
    {
        /**
         * @param $tag
         * @param $params
         * @param null $extra
         * @param bool $once
         * @param null $behavior
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: resultListen
         * @describe:监听有返回结果的行为
         */
        public static function resultListen($tag, $params, $extra = null, $once = false,$behavior = null)
        {
            self::beforeListen($tag,$params,$extra,false,$behavior);
            return self::listen($tag,$params,$extra,$once,$behavior);
        }

        /**
         * @param $tag
         * @param $params
         * @param null $extra
         * @param bool $once
         * @param null $behavior
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: afterListen
         * @describe:监听后置行为
         */
        public static function afterListen($tag, $params, $extra = null, $once = false, $behavior = null)
        {
            try{
                return self::listen($tag.'_after',$params,$extra,$once,$behavior);
            }catch (\Exception $e){}
        }


        /**
         * @param $tag
         * @param $params
         * @param null $extra
         * @param bool $once
         * @param null $behavior
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: beforeListen
         * @describe:监听前置行为
         */
        public static function beforeListen($tag,$params,$extra = null, $once = false, $behavior = null)
        {
            try{
                return self::listen($tag.'_before',$params,$extra,$once,$behavior);
            }catch (\Exception $e){}
        }



        /**
         * @param $tag
         * @param $params
         * @param null $extra
         * @param bool $once
         * @param null $behavior
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: listen
         * @describe:监听行为
         */
        public static function listen($tag, $params, $extra = null, $once = false, $behavior = null)
        {
            if($behavior && method_exists($behavior,Loader::parseName($tag,1,false))) self::add($tag,$behavior);
            return Hook::listen($tag,$params,$extra,$once);
        }

        /**
         * @param $tag
         * @param $behavior
         * @param bool $first
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: addBefore
         * @describe:添加前置行为
         */
        public static function addBefore($tag, $behavior, $first = false)
        {
            self::add($tag.'_before',$behavior,$first);
        }

        /**
         * @param $tag
         * @param $behavior
         * @param bool $first
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: addAfter
         * @describe:添加后置行为
         */
        public static function addAfter($tag, $behavior, $first = false)
        {
            self::add($tag.'_after',$behavior,$first);
        }


        /**
         * @param $tag
         * @param $behavior
         * @param bool $first
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: add
         * @describe:添加行为
         */
        public static function add($tag, $behavior, $first = false)
        {
            Hook::add($tag,$behavior,$first);
        }

    }