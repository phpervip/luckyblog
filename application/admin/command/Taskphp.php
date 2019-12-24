<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/15-10:01
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Taskphp.php
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

    namespace app\admin\command;


    use think\console\Command;
    use think\console\Input;
    use think\console\Output;
    use think\console\input\Argument;

    //定义启动文件入口标记
    define("START_PATH", dirname(APP_PATH));
    // 载入taskphp入口文件
    require_once dirname(APP_PATH).'/vendor/taskphp/taskphp/src/taskphp/base.php';

    class Taskphp extends Command
    {

        protected function get_config(){
            return [
                //任务列表
                'task_list'=>[
                    //key为任务名，多任务下名称必须唯一
                    'demo'=>[
                        'callback'=>['app\\admin\\command\\News','run'],//任务调用:类名和方法
                        //指定任务进程最大内存  系统默认为512M
                        'worker_memory'      =>'1024M',
                        //开启任务进程的多线程模式
                        'worker_pthreads'   =>false,
                        //任务的进程数 系统默认1
                        'worker_count'=>1,
                        //crontad格式 :秒 分 时 天 月 年 周
                        'crontab'     =>'/5 * * * * * *',
                    ],
                ],
            ];
        }


        protected function configure(){
            $this->addArgument('param', Argument::OPTIONAL);
            // 设置命令名称
            $this->setName($_SERVER['argv'][1])->setDescription('this is a taskphp!');
        }


        protected function execute(Input $input, Output $output){
            //系统配置
            $config= $this->get_config();
            //加载配置信息
            \taskphp\Config::load($config);
            //定义启动文件入口标记
            //运行框架
            \taskphp\App::run();
        }

    }