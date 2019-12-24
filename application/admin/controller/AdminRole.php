<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/5-15:17
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: AdminRole.php
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


    use service\JsonService;
    use service\StringService;
    use service\TreeService;
    use service\UtilService;
    use think\Exception;
    use think\Validate;

    class AdminRole extends SystemBase
    {

        protected $admin_role;

        protected function _initialize()
        {
            parent::_initialize(); // TODO: Change the autogenerated stub

            $this->admin_role = new \app\admin\model\AdminRole();//角色模型
        }



        /**
         * @return mixed|void
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: index
         * @describe:角色列表
         */
        public function index()
        {
            if($this->request->isAjax()) {
                $param = $this->request->param();//接收参数
                /**
                 * 返回获取的分页数据
                 */
                return $this->admin_role->GetAdminRoleDataPage($param);
            }

            return $this->fetch();
        }



        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: addRole
         * @describe:添加角色
         */
        public function AddRole()
        {

            if($this->request->isAjax()) {
                $data     = $this->request->post();
                $validate = new Validate([['name|token', 'chsAlpha', '角色名称只允许汉字、字母'], ['rule', 'require', '请选择需要授权的菜单'],]);
                if(!$validate->check($data)) {
                    $this->error('提交失败：'.$validate->getError());
                }

                $data['rule'] = StringService::array2string($data['rule']); //数组转字符串

                $res = $this->admin_role->addEditData($data); //添加数据
                if($res['code']==1) {
                    if(isset($data['id'])){
                        $this->AddLogs('编辑角色【'.$data['name'].'】信息');
                    }else{
                        $this->AddLogs('添加角色角色名称');
                    }
                    $this->success("操作成功");
                }
                else {
                    $this->error($res['msg']);
                }

            }
            $pid  = $this->request->param("id/d");//父id
            $tree = TreeService::toFormatTree($this->admin_role->GetRoleList(), "name");//获取菜单列表
            //dump($tree);die;
            $this->assign(compact("tree", "pid"));
            return $this->fetch();
        }


        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: EditRole
         * @describe:编辑角色
         */
        public function EditRole()
        {
            $id   = $this->request->param("id/d");//父id
            $info = $this->admin_role->get($id)->toArray();
            $pid  = $info['pid'];
            $tree = TreeService::toFormatTree($this->admin_role->GetRoleList(), "name");//获取菜单列表
            $this->assign(compact("pid", "tree", "info"));
            return $this->fetch();
        }


        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: delete
         * @describe:删除角色
         */
        public function delete()
        {
            if($this->request->isAjax()) {
                $ids = $this->request->post("ids");
                try {
                    $res = $this->admin_role->del($ids); //模型删除
                    if($res) {

                        $this->AddLogs('删除角色');

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


        /**
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: authtreeData
         * @describe:获取权限树菜单数据
         */
        public function authtreeData()
        {
            if($this->request->isAjax()) {
                $menu = new \app\admin\model\AdminMenu(); //实例化菜单模型
                $id  = $this->request->param("id/d");

                if($id==1){
                    $da  = $menu->GetMenuList(["is_menu" => 1]); //获取数据
                    if(!empty($da)) {
                        foreach($da as $k => $v){
                            $da[$k]['checked'] = true; //追加默认选中
                        }
                    }
                    $menulistt = TreeService::DeepTree($da, "list");
                    $this->success("ok", '', $menulistt);
                }else{
                    $info=$this->admin_role->get($id); //
                    $rules=$info['rule'];

                    if(isset($rules) && !empty($rules)) { //编辑获取的数据
                        $ids = StringService::string2array($rules); //字符串转数组
                        $da  = $menu->GetMenuList(["is_menu" => 1]); //获取数据
                        if(!empty($da)) {
                            foreach($da as $k => $v){
                                if(in_array($v['id'], $ids)) { //
                                    $da[$k]['checked'] = true; //追加默认选中
                                    //$da[$k]['disable']=true; //不可选择
                                }
                            }
                        }
                        $menulist = TreeService::DeepTree($da, "list");
                    }
                    else {
                        $menulist = TreeService::DeepTree($menu->GetMenuList(['is_menu' => 1]), "list");//获取数据
                    }

                    $this->success("ok", '', $menulist);
                }

            }
        }



    }