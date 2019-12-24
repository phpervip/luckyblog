<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/8/27-16:50
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


    namespace app\api\controller;


    use think\Controller;
    use think\Db;
    use think\Exception;
    use think\Log;

    class Task extends Controller
    {

        /**
         * @throws \phpmailerException
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: comment
         * @describe:定义执行方法评论和审核
         */
        public function comment(){
            $liuyan=Db::name("feedback")->where("status",2)->count("id");//查询未审核留言数
            $pinglun= Db::name("comment")->where("status",2)->count("id");//查询未审核评论数量
            $time=date("Y年m月d日 H:i:s",time());
            if((int)$liuyan==0 && (int)$pinglun==0){
                Log::write("本次暂无留言，评论未审核数据！操作时间：".$time);
            } else{
                $msg="亲爱的:小贺博主\t\n您总共有待审核评论【".$pinglun."】条，留言【".$liuyan."】条！\t\n <a href='http://www.jackhhy.cn' target='_blank'>点击链接查看</a>";
                $res=SendMail('1668862539@qq.com',$msg);
                if($res!=false){
                    Log::write("本次邮件发送通知成功！操作时间：".$time);
                }else{
                    Log::write("本次邮件发送通知失败！操作时间：".$time);
                }
            }
        }



        /**
         * @return bool
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: ip
         * @describe:记录每日的网站访问统计
         */
        public function ip(){
            $redis=new \Redis();
            $ok=$redis->connect("127.0.0.1",6379);
            if($ok==false){
                Log::write($redis->getLastError()); //记录错误日志
                return true;
            }
            $time=date("Y-m-d",time()); //时间
            //统计今日访问人数
            $all=$redis->zCard($time);
            $data=[
                'create_time'=>time(),
                'nums'=>$all,
                'time'=>date("Y年m月d日",time()),
                'year'=>intval(date("Y",time())),
                'month'=>intval(date("m",time())),
                'day'=>intval(date("d",time())),
            ];

            try{
                Db::name("ip_count")->insert($data);
            }catch (Exception $exception){
                Log::write("当日记录插入到数据库错误:".$exception->getMessage().$time); //记录错误日志
            }

        }



    }