<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/26-13:09
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Apii.php
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

    namespace app\api\controller;

    use service\UtilService;

    class Api
    {

        /**
         * @return mixed|\think\response\Json
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: getQQNickName
         * @describe:
         */
        function getQQNickName(){
            $qq = input('param.qq/d');
            $returnArr=['code'=>0,'msg'=>'获取失败'];

            if(!$qq || !preg_match('|^[1-9]\d{4,10}$|i',$qq)){
                $returnArr['msg']='QQ格式错误';
                return json($returnArr);
            }

            $cache_key=SYSTEM_NAME . 'qq_nickname' . $qq;
            $cache_nickname=cache($cache_key);

            if($cache_nickname != false){

                return $cache_nickname;
            }


            $arrContextOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ];

            $nickname = file_get_contents('http://users.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins='.$qq,false,stream_context_create($arrContextOptions));

            $image = 'http://q.qlogo.cn/headimg_dl?dst_uin='.$qq.'&spec=100';

            if(strstr($nickname,'portraitCallBack')){
                $name=trim(mb_convert_encoding($nickname, "UTF-8", "GBK"),'portraitCallBack()');
                $name=json_decode($name,true);
                if(isset($name[$qq][6]) && !empty($name[$qq][6])){
                    $name=$name[$qq][6];
                }else{
                    $name='游客';
                }

                $returnArr= array('code'=>1, 'msg'=>'成功', 'image'=>$image, 'name'=> $name,'qq'=>$qq);
                $this->save_qq($returnArr);
                cache($cache_key , $returnArr , 3600);

            }else if(strstr($nickname,'_Callback')){
                $returnArr['msg']='获取昵称失败';
            }
            return json($returnArr);
        }


        //保存用户
        public function save_qq($arr){
            $res=db("users")->where("qq",$arr['qq'])->select();
            if($res){
                return true;
            }else{
                $arr['username']=$arr['name'];
                $arr['create_time']=time();
                $arr['time_formt']=date("Y-m-d H:i:s",time());
                $arr['ip']=UtilService::getip();
                unset($arr['code']); unset($arr['msg']);unset($arr['name']);
                $gid=db("users")->insert($arr);
                return true;
            }
        }

    }