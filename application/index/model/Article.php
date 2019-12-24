<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/19-15:44
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Article.php
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

    namespace app\index\model;

    use think\Cache;
    use think\Model;

    class Article extends Model
    {

        /**
         * @return array|mixed
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: indexGetArticleToIsRecommend
         * @describe:文章列表
         */
        public function indexGetArticle($where=[],$page=13){
            $where['a.status']=1;
                $field='a.*,c.title as n_title,c.model_id';
                $data=$this->alias('a')
                    ->join('navigate c','a.navigate_id=c.id')
                    ->where($where)
                    ->field($field)
                    ->cache(true,'','article_data')
                    ->order('a.is_top DESC,a.create_time DESC')
                    ->paginate($page);;
            return $data;
        }


        /**
         * @param $keywords
         * @return \think\Paginator
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: GetArticleDataByKeywords
         * @describe:獲取數據
         */
        public function GetArticleDataByKeywords($keywords){
            $where=[];
            $where['a.status']=1;
            $where['a.title'] = ['like', "%".$keywords."%"];
            $field='a.*,c.title as n_title,c.model_id';
            $data=$this->alias('a')
                ->join('navigate c','a.navigate_id=c.id')
                ->where($where)
                ->field($field)
                ->order('a.is_top DESC,a.create_time DESC')
                ->paginate(13);
            return $data;
        }

        /**
         * @param $where
         * @param $limit
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: indexGetArticleToIsRecommend
         * @describe:推荐，置顶文章
         */
        public function indexGetArticleToIsRecommend($where,$limit,$order="a.create_time DESC"){
            $where['a.status']=1;
            $field='a.*,c.title as n_title,c.model_id';
            $data=$this->alias('a')
                ->join('navigate c','a.navigate_id=c.id')
                ->where($where)
                ->field($field)
                ->order($order)
                ->limit($limit)
                ->select()
                ->toArray();
            return $data;
        }





        /**
         * @param $where
         * @param int $limit
         * @param string $order
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: right_article
         * @describe:右侧文章
         */
        public function right_article($where,$limit,$order){
            $where['status']=1;
            $cacheName=SYSTEM_NAME.$where['navigate_id'];
            $returnArr= \cache($cacheName);

            if($returnArr==false || is_null($returnArr)){

                $data=$this->where($where)->order($order)->limit($limit)->select()->toArray();

                \cache($cacheName,$data,'','article_data');
                $returnArr=$data;
            }

            return $returnArr;
        }


        /**
         * @param $id
         * @return array
         * @throws \think\Exception
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: showarticle
         * @describe: 单个文章查看
         */
        public function showarticle($id){
            $cacheName=SYSTEM_NAME . 'showarticle' . $id;
            $returnArr= \cache($cacheName);
            $this->hits($id);

            if($returnArr == false || is_null($returnArr)) {
                $where['a.id'] = $id;
                $field         = 'a.*,c.title as n_title,c.model_id';
                $data          = $this->alias('a')->join('navigate c', 'a.navigate_id=c.id')->where($where)->field($field)->find()->toArray();

                $returnArr=[];
                if(!is_null($data)){
                    $returnArr=$data;
                    $next = $this->where('id','>',$id)->where('navigate_id',$data['navigate_id'])->order('id asc')->find();
                    $prev = $this->where('id','<',$id)->where('navigate_id',$data['navigate_id'])->order('id asc')->find();
                    $next = (!is_null($next)) ? $next->toArray() : ['title'=>'返回列表','url'=>url('index/article/lists',['navigate_id'=>$data['navigate_id']])];
                    $prev = (!is_null($prev)) ? $prev->toArray() : ['title'=>'返回列表','url'=>url('index/article/lists',['navigate_id'=>$data['navigate_id']])];
                    $returnArr['prev']=$prev;
                    $returnArr['next']=$next;

                    \cache($cacheName,$returnArr,'','article_data');

                    return $returnArr;
                }

            }
            return $returnArr;
        }



        /**
         * @return array
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: tagsAll
         * @describe:所有标签
         */
        public function tagsAll(){
            $tags=$this->where("status",1)->column("tags");
            $arr=[];
            if(!empty($tags)){
                foreach($tags as $k=>$v){
                    $ar=@explode(",",$v);
                    if(count($ar)>1){
                        foreach($ar as $a){
                           $arr[].=$a;
                        }
                    }else{
                       $arr[].=$ar[0];
                    }
                }
                $arr=array_unique($arr);
            }
           return $arr;
        }



        /**
         * @param $tag
         * @return \think\Paginator
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: tags_article
         * @describe:标签查询
         */
        public function tags_article($tag){
            $tags=$this->where("status",1)->select()->toArray();
            $ids=[];
            foreach($tags as $k=>$v){
                $ar=@explode(",",$v['tags']);
                if(in_array($tag,$ar)){ //
                    $ids[]=$v['id'];
                }
            }
            if(empty($ids)){
                $ids=[0];
            }
            $where=[];
            $where['a.status']=1;
            $where['a.id'] = ['in', $ids];
            $field='a.*,c.title as n_title,c.model_id';
            $data=$this->alias('a')
                ->join('navigate c','a.navigate_id=c.id')
                ->where($where)
                ->field($field)
                ->order('a.is_top DESC,a.create_time DESC')
                ->paginate(13);
           return $data;
        }



        /**
         * @param $id
         * @throws \think\Exception
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: hits
         * @describe:文章点击量加一
         */
        public function hits($id){
            $this->where("id",$id)->setInc("hits");
        }


        /**
         * @param $id
         * @throws \think\Exception
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: comment_nums
         * @describe:文章评论加一
         */
        public function comment_nums($id){
            $this->where("id",$id)->setInc("comment_nums");
        }










    }