<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/24-15:03
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Yuju.php
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

    namespace app\admin\controller;

    use think\Exception;

    class Yuju extends SystemBase
    {
        protected $yuju;
        protected function _initialize()
        {
            parent::_initialize(); // TODO: Change the autogenerated stub
            $this->yuju=new \app\admin\model\Yuju();
        }


        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: index
         * @describe:
         */
        public function index(){
            if($this->request->isAjax()){
                $param = $this->request->param();//接收参数
                return $this->yuju->GetYujuDataPage($param);
            }
            return $this->fetch();
        }



        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: AddYuju
         * @describe: 添加每日一句
         *
         *
         */
        public function AddYuju(){
            if($this->request->isAjax()) {
                $data = $this->request->post();

                $data['admin_name']=self::$admin_info['nickname'];

                $data['title']=GetSensitive($data['title']); //敏感词过滤

                 $res= $this->yuju->addEditData($data);

                 if($res['code']==1){
                     if(isset($data['id'])){
                         $this->AddLogs('编辑每日一句【'.$data['title'].'】');
                     }else{
                         $this->AddLogs('添加每日一句【'.$data['title'].'】');
                     }
                     $this->success("提交成功");
                 }else{
                     $this->error($res['msg']);
                 }

            }
            return $this->fetch();
        }


        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: EditYuju
         * @describe:编辑语句
         */
        public function EditYuju(){
            $id=$this->request->param("id/d");
            $info=$this->yuju->get($id);
            $this->assign("info",$info);
            return $this->fetch();
        }


        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: delete
         * @describe:删除
         */
        public function delete()
        {
            if($this->request->isAjax()) {
                $ids = $this->request->post("ids");
                return $this->DeleteData("yuju",$ids);
            }
        }


    }