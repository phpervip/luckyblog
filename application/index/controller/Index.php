<?php
namespace app\index\controller;


use service\UtilService;
use think\Cache;

class Index extends Base
{



    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

    }


    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: index
     * @describe:首页
     */
    public function index()
    {
        $data=$this->article_model->indexGetArticle(); //首页文章列表
        $page = $data->render();
        $this->assign('article_data',$data);
        $this->assign('page',$page);

        /*置顶文章*/
        $this->assign("top_article",$this->article_model->indexGetArticleToIsRecommend(['a.is_top'=>1],2));

        /*推荐文章*/
       // $this->assign("recommend_article",$this->article_model->indexGetArticleToIsRecommend(['a.is_recommend'=>1],3));

        /*点击排行*/
       // $this->assign("hits_article",$this->article_model->indexGetArticleToIsRecommend([],5,"a.hits DESC,a.create_time DESC"));

        /*友情链接*/
       /* $frindlink=db("friendlink")->where(['status'=>1,'type'=>1])->select();
        $this->assign("frindlink",$frindlink);*/

        $this->assign("tags",$this->article_model->tagsAll()); //文章标签

        $this->assign("bo",model("admin/bo")->admin_bo());//轮播图

        $this->assign("advice_pic",model("admin/Advice")->getdatabywhere(['status'=>1,'type'=>1]));

        $this->assign("advice_zi",model("admin/Advice")->getdatabywhere(['status'=>1,'type'=>2])); //文字广告


        return  $this->fetch();
    }





    /**
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: search
     * @describe:搜索
     */
    public function search(){
        $keywords=$this->request->get("keywords");
        $data=$this->article_model->GetArticleDataByKeywords($keywords);
        $this->right_article(['navigate_id'=>$this->navigate_id]);

        $this->assign("page",$data->render());
        $this->assign("datas",$data);
        $this->assign("keys",$keywords);
        $this->assign("count",count($data));
        return  $this->fetch();
    }



    /**
     * @return mixed
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: tags_search
     * @describe:标签搜索
     */
    public function tags_search(){
         $tag=$this->request->get("tag");
         $data=$this->article_model->tags_article($tag);
        $this->assign("page",$data->render());
        $this->assign("datas",$data);
        $this->assign("keys",$tag);
        $this->assign("count",count($data));
        return  $this->fetch();

    }









}
