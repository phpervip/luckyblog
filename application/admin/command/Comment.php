<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/8/27-15:53
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Comment.php
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


    namespace app\admin\command;


    use think\console\Command;
    use think\console\Input;
    use think\console\Output;
    use think\Db;
    use think\Log;

    class Comment extends Command
    {

        /**
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: configure
         * @describe:
         */
        protected function configure(){
            $this->setName('Comment')->setDescription("计划任务:发送短信通知");
        }

        /**
         * @param Input $input
         * @param Output $output
         * @return int|void|null
         * @throws \phpmailerException
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: execute
         * @describe:调用个类时,会自动运行execute方法
         */
        protected function execute(Input $input, Output $output){
            $output->writeln('Date Crontab job start...');
            /*** 这里写计划任务列表集 START ***/

            $this->send_maile();//发短信通知博主

            /*** 这里写计划任务列表集 END ***/
            $output->writeln('Date Crontab job end...');
        }


        /**
         * @throws \phpmailerException
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: send_maile
         * @describe:获取未审核留言和评论
         */
        public function send_maile()
        {
           $liuyan=Db::name("feedback")->where("status",2)->count("id");//查询未审核留言数
           $pinglun= Db::name("comment")->where("status",2)->count("id");//查询未审核评论数量
           if((int)$liuyan==0 && (int)$pinglun==0){
               Log::write("本次暂无留言，评论未审核数据");
           } else{
               $msg="亲爱的:小贺博主\t\n您总共有待审核评论【".$pinglun."】条，留言【".$liuyan."】条！\t\n <a href='http://www.jackhhy.cn' target='_blank'>点击链接查看</a>";
               $res=SendMail('1668862539@qq.com',$msg);
               if($res!=false){
                   Log::write("本次邮件发送通知成功！");
               }else{
                   Log::write("本次邮件发送通知失败！");
               }
           }

        }


        /**
         * crontab -l //计划任务列表
           crontab -e //编辑新增
           crontab -r //删除
         */


    // */1 * * * * php /www/wwwroot/www.jackhhy.cn/think Comment>>/www/wwwlogs/www.jackhhy.cn/logs/comment/2019.log 2>&1

        //注意上面的php如果不能执行,请写全路径,我的是 /usr/local/php/bin/php

        //监控一下你的脚本是不是正常的
    // tail -f /www/wwwroot/tool/runtime/message/2019.log*/


    }