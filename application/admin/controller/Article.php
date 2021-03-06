<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/19-15:32
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Article.php
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


    use service\PHPExcelService;
    use service\StringService;
    use think\Exception;

    class Article extends SystemBase
    {


        protected $article;

        protected function _initialize()
        {
            parent::_initialize(); // TODO: Change the autogenerated stub
            $this->article = new \app\admin\model\Article();
        }



        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: index
         * @describe:文章首页列表
         */
        public function index()
        {
            if($this->request->isAjax()) {
                $param = $this->request->param();//接收参数
                /**
                 * 返回获取的分页数据
                 */
                return $this->article->GetArticleDataPage($param);
            }
            $this->assign("navigate", $this->article->GetNavigateArticle());//获取文章模型栏目
            return $this->fetch();
        }



        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: EditArticle
         * @describe:编辑文章
         */
        public function EditArticle()
        {
            $id   = $this->request->param("id/d");
            $info = $this->article->get($id);
            $this->assign("info", $info);
            $this->assign("navigate", $this->article->GetNavigateArticle());//获取文章模型栏目
            return $this->fetch();
        }

        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: AddArticle
         * @describe:添加文章
         */
        public function AddArticle()
        {

            if($this->request->isAjax()) {
                $data = $this->request->post();


                if(empty($data['content'])) {
                    $this->error("文章内容不能为空");
                }
                $data['description'] = empty($data['description']) ? StringService::str_cut(strip_tags($data['content']), 200) : $data['description'];
                if(intval($data['pic'])==1) {
                    $img               = match_img($data['content']);
                    $data['image_url'] = $img ? thumb($img) : '';
                }
                unset($data['pic']);

                $data['content'] = GetSensitive($data['content']); //敏感词过滤

                $data['tags']=$data['keywords'];

                if(intval($data['cao'])==1) {
                    $data['status'] = 3; //草稿
                }
                unset($data['cao']);

                if(intval($data['img'])==1) {
                    $data['content'] = grab_image($data['content']); //文章远程图片本地化
                }

                unset($data['img']);

                $res = $this->article->addEditData($data);
                if($res['code']==1) {
                    if(isset($data['id'])) {
                        $this->AddLogs('修改文章内容【'.$data['title'].'】');
                    }
                    else {
                        $this->AddLogs('新增文章【'.$data['title'].'】');
                    }

                    $this->success("提交成功");
                }
                else {
                    $this->error($res['msg']);
                }

            }

            $this->assign("navigate", $this->article->GetNavigateArticle());//获取文章模型栏目
            return $this->fetch();
        }



        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: move_article
         * @describe:移动文章
         */
        public function move_article()
        {
            if($this->request->isAjax()) {
                $ids         = $this->request->post("ids");
                $navigate_id = $this->request->post("navigate_id");
                try {
                    $res = db("article")->where(['id' => ['in', $ids]])->setField("navigate_id", $navigate_id);
                    if($res) {
                        $this->AddLogs('移动文章');
                        $this->success("移动成功");
                    }
                    else {
                        $this->error("移动失败");
                    }
                } catch (Exception $exception) {
                    $this->error($exception->getMessage());
                }
            }
        }



        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: delete
         * @describe:删除文章
         */
        public function delete()
        {
            if($this->request->isAjax()) {
                $ids = $this->request->post("ids");
                return $this->DeleteData("article",$ids);
            }
        }


        /**
         * @throws \PHPExcel_Reader_Exception
         * @throws \PHPExcel_Writer_Exception
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: test
         * @describe:数据导出测试
         */
        public function test(){
            $res=db("email_sends")->select();
            $export = [];
            foreach($res as $k=>$v){
                $export[] = [
                    $v['id'],$v['email'],$v['title'],strip_tags(htmlspecialchars_decode($v['content'])),$v['ok'],$v['nickname'],$v['create_time']
                ];
            }
            PHPExcelService::setExcelHeader(['ID','邮箱','标题','内容','发送状态','昵称','时间'])
                ->setExcelTile('订单导出','订单信息'.time(),' 生成时间：'.date('Y-m-d H:i:s',time()))
                ->setExcelContent($export)
                ->ExcelSave();

        }

        /**
         * @return mixed
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: get_images
         * @describe:弹窗选择
         */
        public function get_images()
        {
            $mod = new \app\admin\model\Upload();
            $res = $mod->GetImages();
            $this->assign("data", $res->toArray());
            $this->assign('page', $res->render());
            return $this->fetch();

        }


        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: down
         * @describe:下架文章
         */
        public function down()
        {
            if($this->request->isAjax()) {
                $id = $this->request->post("id");
                try {
                    $res = db("article")->where("id", $id)->setField("status", 2);
                    if($res) {
                        $this->success("下架成功");
                    }
                    else {
                        $this->error("下架失败");
                    }
                } catch (Exception $exception) {
                    $this->error($exception->getMessage());
                }
            }
        }



    }