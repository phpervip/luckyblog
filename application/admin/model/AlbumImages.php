<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/10-16:21
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: AlbumImages.php
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
    use service\CacheService;
    use service\JsonService;
    use service\UtilService;
    use think\Exception;

    class AlbumImages extends ModelBase
    {

        /**
         * @param $album_id
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: getByAlbumId
         * @describe:根据相册ID获取图片
         */
        public function getByAlbumId($album_id)
        {
            return $this->where("album_id", $album_id)->select()->toArray();
        }


        /**
         * @param $data
         * @return array|false
         * @throws \Exception
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: addData
         * @describe:批量添加数据
         */
        public function addData($data)
        {
            $res = $this->isUpdate(false)->allowField(true)->saveAll($data);
            return $res;
        }


        public function getAll()
        {
            return $this->select()->toArray();
        }


        /**
         * @param $id
         * @return int
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: del
         * @describe:删除
         */
        public function del($id)
        {
            //dump($id);die;
            try {
                $data = $this->whereIn("id", $id)->select()->toArray();
                foreach($data as $k => $v){
                    @unlink($v['img_url']); //删除原图片
                }
                CacheService::rm("images_album");

                $del = $this->destroy(['id' => ['in', $id]]);

                if($del) {

                    return JsonService::success("删除成功");
                }
                else {
                    return JsonService::fail("删除失败");
                }


            } catch (Exception $exception) {

                return JsonService::fail($exception->getMessage());
            }
        }



    }