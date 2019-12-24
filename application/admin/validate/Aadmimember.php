<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/8-10:46
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Aadmimember.php
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

    namespace app\admin\validate;


    use think\Validate;

    class Aadmimember extends Validate
    {

        protected $rule = [
            'nickname|token'  =>  'chsAlpha|max:12',
            'username' =>  'alphaNum|max:12',
            'password' =>  'min:6|max:16|alphaDash',
        ];

        protected $message = [
            'nickname.chsAlpha'  =>  '管理员昵称只允许汉字、字母',
            'nickname.max'  =>  '用户昵称最大长度为12个字符',
            'username.alphaNum'  =>  '用户名只允许字母与数字',
            'username.max'  =>  '用户名最大长度为12个字符',
            'password.min'  =>  '密码最少6个字符',
            'password.max' =>  '密码最长16个字符',
            'password.alphaNum' =>  '密码只允许字母、数字',
        ];


        /**
         * 验证场景
         */
       /* protected $scene = [
            'edit'  =>  ['name','age'],
        ];*/


    }