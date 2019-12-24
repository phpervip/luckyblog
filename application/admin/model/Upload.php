<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/4-16:28
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Upload.php
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

    use service\JsonService;
    use think\Exception;
    use think\Model;
    use \think\Image;

    class Upload extends Model
    {

        public $setting;

        function initialize()
        {
            parent::initialize();
            $this->setting = model('setting')->getSetting(); //加载设置文件
        }


        /**
         * @param array $param
         * @param string $order
         * @return \think\Paginator
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetSucaiDataPage
         * @describe:获取分页数据
         */
        public function GetSucaiDataPage($param = [], $order = "create_time desc")
        {
            $where = [];
            $page  = 75;
            if(!empty($param)) {
                //搜索条件
                if(!empty($param['filename'])) {
                    $where['filename'] = ['like', "%".$param['filename']."%"];
                }
                isset($param['page_size']) && $param['page_size']!=0 ? $page = (int)$param['page_size'] : 1;
            }
            $data = $this->where($where)->order($order)->paginate($page);
            return $data;
        }


        /**
         * @param $ids
         * @return int|void
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: del
         * @describe:删除
         */
        public function del($ids){
            try {
                $info=$this->where(['id' => ['in', $ids]])->select()->toArray();
                foreach($info as $K){
                    @unlink($K['file_path']); //删除原件
                }
                $del = $this->destroy(['id' => ['in', $ids]]);
                return $del;
            } catch (Exception $exception) {

                return JsonService::fail($exception->getMessage());
            }
        }


        /**
         * @return array
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: GetImages
         * @describe:获取图片
         */
        public function GetImages(){
            $page  = 21;
            $data = $this->where(["ext"=>["in","png,jpg,gif"]])->order("create_time desc")->paginate($page);
            return $data;
        }

        /**
         * @param $width
         * @param $height
         * @param string $filePath
         * @param string $name
         * @return array
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: uploadThumb
         * @describe:缩略图上传
         */
        public function uploadThumb($width, $height, $filePath = "thumb_images", $name = "file")
        {
            $file = request()->file($name);
            if($file) {
                $filePaths = ROOT_PATH.'public'.DS.'uploads'.DS.$filePath;
                $info      = $file->validate(['size' => $this->setting['size'], 'ext' => $this->setting['ext']])->move($filePaths);
                if($info) {
                    $md5       = $file->hash('md5');
                    $sha1      = $file->hash('sha1');
                    $imgpath   = 'uploads/'.$filePath.'/'.$info->getSaveName();
                    $image     = \think\Image::open($imgpath);
                    $date_path = 'uploads/'.$filePath.'/thumb/'.date('Ymd');
                    if(!file_exists($date_path)) {
                        mkdir($date_path, 0777, true);
                    }
                    $thumb_path = $date_path.'/'.$info->getFilename();
                    $image->thumb($width, $height)->save($thumb_path);

                    @unlink(ROOT_PATH.'public'.DS.$imgpath);//删除原有上传的图片

                    $arr   = ['file_size' => $info->getSize(), 'thumb' => "", 'up_type' => $this->setting['upload_type'], 'ext' => $info->getExtension(), 'create_time' => time(), 'filename' => $file->getInfo('name'), 'file_path' => '/'.$thumb_path, 'file_md5' => $md5, 'file_sha1' => $sha1, 'suffix' => $info->getType()];
                    $getid = $this->saveUpload($arr);
                    return ['code' => 1, 'msg' => "上传成功", 'save_id' => $getid, 'thumb' => "", 'path' => '/'.$thumb_path, 'savename' => $info->getSaveName(), 'filename' => $info->getFilename(), 'info' => $info->getInfo(), 'ext' => $info->getExtension()];
                }
                else {
                    // 上传失败获取错误信息
                    return ['code' => 0, 'msg' => $file->getError()];
                }
            }
        }


        /**
         * 
         */
        public function uploadFileThumb($width, $height, $filePath = "thumb_images",$name="file")
        {
          $file = request()->file($name);
          if($file){
            $filePaths = ROOT_PATH . 'public' . DS . 'uploads' . DS .$filePath;
            if(!file_exists($filePaths)){
              mkdir($filePaths,0777,true);
            }
            $info      = $file->validate(['size' => $this->setting['size'], 'ext' => $this->setting['ext']])->move($filePaths);
            if($info){
              $imgpath = 'uploads/'.$filePath.'/'.$info->getSaveName();
              $image = \think\Image::open($imgpath);
              $date_path = 'uploads/'.$filePath.'/thumb/'.date('Ymd');
              if(!file_exists($date_path)){
                mkdir($date_path,0777,true);
              }
              $thumb_path = $date_path.'/'.$info->getFilename();
              $image->thumb($width, $height)->save($thumb_path);

              $arr   = ['file_size' => $info->getSize(), 'thumb' => $imgpath, 'up_type' => $this->setting['upload_type'], 'ext' => $info->getExtension(), 'create_time' => time(), 'filename' => $file->getInfo('name'), 'file_path' => '/'.$thumb_path, 'file_md5' => '', 'file_sha1' => '', 'suffix' => $info->getType()];
              $getid = $this->saveUpload($arr);
              return ['code' => 1, 'msg' => "上传成功", 'save_id' => $getid, 'thumb' => $imgpath, 'path' => '/'.$thumb_path, 'savename' => $info->getSaveName(), 'filename' => $info->getFilename(), 'info' => $info->getInfo(), 'ext' => $info->getExtension()];
            }else{
             // 上传失败获取错误信息
             return ['code' => 0, 'msg' => $file->getError()];
            }
          }
        }

        /**
         * @param $type
         * @param string $filename
         * @param bool $is_water
         * @return array|bool
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: upfile
         * @describe:上传文件
         */
        public function upfile($type, $filename = 'file', $is_water = false, $width = 200, $height = 400)
        {
            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file($filename);

            //先检测MD5和哈希是否存储过
            $md5   = $file->hash('md5');
            $sha1  = $file->hash('sha1');
            $is_up = $this->checkFileIsUp($md5, $sha1, $this->setting['upload_type']);

            if($is_up!==true) {
                //上传过了
                $is_up['code']         = 1;
                $is_up['msg']          = '上传成功';
                $is_up['info']['name'] = $file->getInfo('name');
                return $is_up;
            }

            //type 2 七牛  3 oss  1 本地
            if($this->setting['upload_type']==2) {
                /*    //七牛云存储
                    $tmp_name=$file->getInfo('tmp_name');   //临时目录
                    //文件后缀
                    $ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);
                    $config = $this->setting['qiniu_config'];
                    // 构建一个鉴权对象
                    $auth =new Auth($config['accessKey'],$config['secretKey']);
                    // 生成上传的token
                    $token = $auth->uploadToken($config['bucket']);

                    // 上传到七牛后保存的文件名
                    $up_file_name=date('Ymd') . '/' . md5($tmp_name . time().mt_rand(0,9999));
                    $key = $up_file_name . '.' .$ext;

                    // 初始化UploadManager类
                    $uploadMgr = new UploadManager();
                    list($ret,$err) = $uploadMgr->putFile($token,$key,$tmp_name);
                    if($err !== null){
                        return array('code'=>0,'msg'=>$err);
                    }else{
                        $file_path=$config['domain'] . '/' . $key;
                        //保存上传历史
                        $arr=['file_size'=>$file->getInfo('size'),'create_time'=>time(),'filename'=>$file->getInfo('name'),'file_path'=>$file_path,'file_md5'=>$md5,'file_sha1'=>$sha1,'suffix'=>$file->getInfo('type'),'up_type'=>2];
                        $this->saveUpload($arr);
                        return array('code'=>200,'msg'=>'上传成功','path'=>$file_path,'savename'=>$up_file_name,'filename'=>$file->getInfo('name'),'info'=>$file->getInfo());

                    }*/

            }
            else if($this->setting['upload_type']==3) {
                return ['code' => 0, 'msg' => '上传方式不存在'];
            }
            else {
                // 移动到框架应用根目录/uploads/ 目录下
                $info = $file->validate(['size' => $this->setting['size'], 'ext' => $this->setting['ext']])->move(ROOT_PATH.'public'.DS.'uploads'.DS.$type);
                //$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . $type);
                if($info) {
                    $path = DS.'uploads'.DS.$type.DS.$info->getSaveName();
                    //如果需要添加水印
                    /*$setting = cache('settings');
                    if($is_water && $setting['is_watermark'] && $setting['watermark'] && $type = 'images' ){
                        $image = \think\Image::open(ROOT_PATH . $path);
                        if($image->width() >= $setting['watermark_width'] && $image->height() >= $setting['watermark_height']){
                            $image->water(ROOT_PATH . $setting['watermark'],$setting['watermark_locate'],$setting['watermark_alpha'])->save(ROOT_PATH . $path);
                        }
                    }*/
                    $path = str_replace("\\", "/", $path);
                    $thum = "";
                    /*  if($type=="images"){
                          $image = Image::open($path);
                          $date_path = DS.'uploads/'.$type.'/thumb/'.date('Ymd');
                          if(!file_exists($date_path)){
                              mkdir($date_path,0777,true);
                          }
                          $thumb_path = $date_path.'/'.$info->getFilename();
                          $image->thumb($width, $height)->save($thumb_path);
                          $thum= $thumb_path;
                      }*/

                    //保存上传历史
                    $arr   = ['file_size' => $info->getSize(), 'thumb' => $thum, 'up_type' => $this->setting['upload_type'], 'ext' => $info->getExtension(), 'create_time' => time(), 'filename' => $file->getInfo('name'), 'file_path' => $path, 'file_md5' => $md5, 'file_sha1' => $sha1, 'suffix' => $info->getType()];
                    $getid = $this->saveUpload($arr);
                    return ['code' => 1, 'msg' => '上传成功', 'save_id' => $getid, 'thumb' => $thum, 'path' => $path, 'savename' => $info->getSaveName(), 'filename' => $info->getFilename(), 'info' => $info->getInfo(), 'ext' => $info->getExtension()];
                }
                else {
                    return ['code' => 0, 'msg' => $file->getError()];
                }
            }

        }


        /**
         * @param $type
         * @param string $filename
         * @param bool $is_water
         * @return array
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: upfiles
         * @describe:多文件上传
         */
        public function upfiles($type, $filename = 'file', $is_water = false)
        {
            // 获取表单上传文件 例如上传了001.jpg
            $files  = request()->file($filename);
            $result = ['code' => 1, 'msg' => '',];
            foreach($files as $k => $file){
                // 移动到框架应用根目录/uploads/ 目录下

                $info = $file->move(ROOT_PATH.'public'.DS.'uploads'.DS.$type);
                if($info) {
                    $path = DS.'uploads'.DS.$type.DS.$info->getSaveName();
                    //如果需要添加水印
                    /*$setting = cache('settings');
                    if($is_water && $setting['is_watermark'] && $setting['watermark'] && $type = 'images' ){
                        $image = \think\Image::open(ROOT_PATH . $path);
                        if($image->width() >= $setting['watermark_width'] && $image->height() >= $setting['watermark_height']){
                            $image->water(ROOT_PATH . $setting['watermark'],$setting['watermark_locate'],$setting['watermark_alpha'])->save(ROOT_PATH . $path);
                        }
                    }*/
                    $path               = str_replace("\\", "/", $path);
                    $result['data'][$k] = ['code' => 200, 'msg' => '上传成功', 'path' => $path, 'savename' => $info->getSaveName(), 'filename' => $info->getFilename(), 'info' => $info->getInfo()];
                }
                else {
                    $result['data'][$k] = ['code' => 0, 'msg' => $file->getError()];
                    $result['msg']      .= '第['.$k.']张'.$file->getError().' , ';
                }
            }
            if(empty($result['msg'])) {
                $result['msg']  = '上传成功';
                $result['code'] = 1;
            }
            else {
                $result['msg']  = trim($result['msg'], ',');
                $result['code'] = 100;
            }
            return $result;
        }



        /**
         * @param $md5
         * @param $sha1
         * @param $type
         * @return array|bool
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: checkFileIsUp
         * @describe:根据文件MD5和哈希值判断文件是否上传过
         */
        public function checkFileIsUp($md5, $sha1, $type)
        {
            $file_data = $this->where(['file_md5' => $md5, 'file_sha1' => $sha1, 'up_type' => $type])->find();
            if(empty($file_data)) {
                return true;
            }
            else {

                return ['path' => $file_data['file_path'], 'info' => ['name' => $file_data['filename'], 'size' => $file_data['file_size'], 'type' => $file_data['suffix']]];
            }
        }

        /**
         * @param $arr
         * @return int|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: saveUpload
         * @describe:保存到表里
         */
        public function saveUpload($arr)
        {
            return $this->insertGetId($arr);
        }


    }