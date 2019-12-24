<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/9-16:30
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

    namespace app\admin\controller;


    use service\TreeService;
    use service\UtilService;
    use think\Exception;

    class Navigate extends SystemBase
    {


        protected $navigate;

        protected function _initialize()
        {
            parent::_initialize(); // TODO: Change the autogenerated stub
            $this->navigate = new \app\admin\model\Navigate();//加载模型
        }



        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: index
         * @describe:栏目列表
         */
        public function index()
        {
            if($this->request->isAjax()) {
                $param = $this->request->param();//接收参数
                /**
                 * 返回获取的分页数据
                 */
                return $this->navigate->GetNavigateDataPage($param);
            }
            return $this->fetch();
        }



        /***
         * @return mixed
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: AddNavigate
         * @describe:添加栏目
         */
        public function AddNavigate()
        {
            if($this->request->isAjax()) {
                $data = $this->request->post();

                if($data['fontFamily']=="layui-icon") {
                    $data['icon'] = $data['layui-icon'];
                }
                else {
                    $data['icon'] = $data['fa'];
                }
                if(empty($data['icon'])) {
                    $this->error("请选择图标");
                }
                $res = $this->navigate->addEditData($data);
                if($res['code']==1) {
                    if(isset($data['id'])){
                        $this->AddLogs('编辑导航栏目【'.$data['title'].'】');
                    }else{
                        $this->AddLogs('添加导航栏目【'.$data['title'].'】');
                    }
                    $this->success("操作成功");
                }
                else {
                    $this->error($res['msg']);
                }


            }

            $this->assign("model", db("model")->select()); //模型
            $tree = TreeService::toFormatTree($this->navigate->GetNavigateList());//获取菜单列表
            //dump($tree);die;
            $pid = $this->request->param("id/d");//父id

            $this->assign(compact("pid", "tree"));
            return $this->fetch();
        }



        /**
         * @return mixed
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: EditNavigate
         * @describe:编辑栏目
         */
        public function EditNavigate()
        {

            $this->assign("model", db("model")->select()); //模型表数据
            $tree = TreeService::toFormatTree($this->navigate->GetNavigateList());//获取栏目列表
            $id   = $this->request->param("id/d");//
            $info = $this->navigate->get($id)->toArray();
            $pid  = $info['pid'];

            $this->assign(compact("pid", "tree", "info"));
            return $this->fetch();
        }


        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: EditLink
         * @describe:编辑外部链接
         */
        public function EditLink()
        {
            $tree = TreeService::toFormatTree($this->navigate->GetNavigateList());//获取栏目列表
            $id   = $this->request->param("id/d");//父id
            $info = $this->navigate->get($id)->toArray();
            $pid  = $info['pid'];
            $this->assign(compact("pid", "tree", "info"));
            return $this->fetch();
        }

        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: Addlink
         * @describe:添加外部链接
         */
        public function Addlink()
        {

            if($this->request->isAjax()) {
                $data = $this->request->post();
                try {
                    if($data['fontFamily']=="layui-icon") {
                        $data['icon'] = $data['layui-icon'];
                    }
                    else {
                        $data['icon'] = $data['fa'];
                    }
                    if(empty($data['icon'])) {
                        $this->error("请选择图标");
                    }
                    $res = $this->navigate->addEditData($data);
                    if($res!=false) {

                        $this->AddLogs('添加外部链接【'.$data['title'].'】');

                        $this->success("添加成功");
                    }
                    else {
                        $this->error("添加失败");
                    }

                } catch (Exception $exception) {
                    $this->error($exception->getMessage());
                }
            }

            $tree = TreeService::toFormatTree($this->navigate->GetNavigateList());//获取菜单列表
            $this->assign(compact("tree"));
            return $this->fetch();
        }


        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: delete
         * @describe:单个或者多个删除
         */
        public function delete()
        {
            if($this->request->isAjax()) {
                $ids = $this->request->post("ids");
                try {
                    $res = $this->navigate->del($ids);
                    if($res) {

                        $this->AddLogs('删除导航栏目');

                        $this->success("删除成功");
                    }
                    else {
                        $this->error("删除失败");
                    }
                } catch (Exception $exception) {
                    $this->error($exception->getMessage());
                }
            }
        }



    }