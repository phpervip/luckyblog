<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/10-16:20
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Album.php
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

    namespace app\admin\model;


    use app\common\model\ModelBase;
    use service\JsonService;
    use service\UtilService;
    use think\Cache;
    use think\Exception;

    class Album extends ModelBase
    {

        protected $update = ["update_time"];

        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: init
         * @describe:模型添加清除缓存
         */
        protected static function init()
        {
            //编辑后可用
            Album::event('after_update', function () {
                Cache::tag('album_data')->clear();
            });
            //新增后可用
            Album::event('after_insert', function () {
                Cache::tag('album_data')->clear();
            });
            //写入后  貌似没用到
            Album::event('after_write', function () {
                Cache::tag('album_data')->clear();
            });
            //删除后
            Album::event('after_delete', function () {
                Cache::tag('album_data')->clear();
            });
        }

        /**
         * @param array $param
         * @param string $order
         * @return array
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetAlbumDataPage
         * @describe:获取相册分页数据
         */
        public function GetAlbumDataPage($param = [], $order = "is_top desc ,create_time desc")
        {
            $where = [];
            $page  = 12;
            if(!empty($param)) {
                //搜索条件
                if(!empty($param['name'])) {
                    $where['name'] = ['like', "%".$param['name']."%"];
                }
                isset($param['page_size']) && $param['page_size']!=0 ? $page = (int)$param['page_size'] : 1;
            }
            $data = $this->where($where)->order($order)->paginate($page);
            return $data;
        }


        /**
         * @param array $param
         * @param string $order
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetDataPage
         * @describe:
         */
        public function GetDataPage($param = [], $order = "is_top desc ,create_time desc")
        {
            $where = [];
            $limit = 15;
            $page  = 1;
            if(!empty($param)) {
                //搜索条件
                if(!empty($param['name'])) {
                    $where['name'] = ['like', "%".$param['name']."%"];
                }
                isset($param['limit']) && $param['limit']!=0 ? $limit = (int)$param['limit'] : '';
                isset($param['page']) && $param['page']!=0 ? $page = (int)$param['page'] : 1;
            }

            try {
                $data = $this->where($where)->order($order)->page($page)->limit($limit)->select()->toArray();

                if(!empty($data)) {
                    foreach($data as $k => $v){
                        if(!empty($v['password'])) {
                            $data[$k]['password'] = UtilService::think_decrypt($v['password']);
                        }

                    }
                }

                $count = count($data);

            } catch (Exception $exception) {
                return JsonService::fail($exception->getMessage());
            }
            return JsonService::result(0, "", $data, $count);

        }



        /**
         * @param array $where
         * @param int $page
         * @return \think\Paginator
         * @throws \think\exception\DbException
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: indexGetArticle
         * @describe: 分页获取相册列表
         */
        public function indedxAlbum($where=[],$page=15){
            $where['is_show']=1;
            $data=$this->where($where)
                ->field("*")
                ->cache(true,'','album_data')
                ->order('is_top DESC,create_time DESC')
                ->paginate($page);;
            return $data;
        }



        /**
         * @return mixed
         * @author: hhygyl
         * @name: setUpdateTimeAttr
         * @describe:
         */
        protected function setUpdateTimeAttr()
        {
            return time();
        }


        /**
         * @param $data
         * @return false|int
         * @author: hhygyl
         * @name: AddData
         * @describe:添加编辑数据
         */
        public function addEditData($data)
        {
            return parent::ChangeData($data);
        }


        /**
         * @param $id
         * @return int|true
         * @throws Exception
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: Hits
         * @describe:点击量加1
         */
        public function Hits($id)
        {
            return $this->where("id", $id)->setInc("hits");
        }



        /**
         * @param $id
         * @return int|void
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: del
         * @describe:删除相册
         */
        public function del($id)
        {
            $al_img = new AlbumImages();

            try {
                if(strlen($id) > 1) {
                    $ids = @explode(',', $id);
                    if(in_array(1, $ids)) {
                        $ids = array_diff($ids, [1, 0]); //去除回收相册
                    }
                    //dump($ids);die;
                    foreach($ids as $v){
                        $res = $al_img->getByAlbumId($v);
                        if(!empty($res)) {
                            db("album_images")->where("id", $v)->setField("album_id", 1);//把相册下面的图片放到回收相册
                        }
                    }

                    $del = $this->destroy(['id' => ['in', $ids]]);
                    return $del;
                }
                else {
                    if(intval($id)==1) {
                        return JsonService::fail("回收相册不可以删除");
                    }
                    $res = $al_img->getByAlbumId($id);
                    if(!empty($res)) {
                        db("album_images")->where("id", $id)->setField("album_id", 1);//把相册下面的图片放到回收相册
                    }

                    $del = $this->destroy(['id' => ['in', $id]]);
                    return $del;
                }

            } catch (Exception $exception) {

                return JsonService::fail($exception->getMessage());
            }

        }


    }