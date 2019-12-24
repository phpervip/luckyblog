<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/2-11:42
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Common.php
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

    use app\admin\model\Upload;
    use service\DownloadService;
    use service\JsonService;
    use service\UtilService;
    use think\Exception;
    use think\Request;

    class Common extends SystemBase
    {

        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: ChangeStatus
         * @describe:异步提交修改数据状态
         */
        public function ChangeStatus()
        {
            if($this->request->isAjax()) {
                $data = $this->request->post();
                try {
                    $table = $data['table'] ? $data['table'] : "";
                    $res   = db("$table")->where(["id" => (int)$data['id']])->update([$data['field'] => $data['status']]);
                    if($res!==false) {

                        $this->AddLogs('修改'.$data['table'].'表ID为'.$data['id'].'的'.$data['field'].'字段改为'.$data['status'].'');

                        return JsonService::successful("修改成功");
                    }
                    else {
                        return JsonService::fail("修改失败");
                    }
                } catch (Exception $exception) {
                    return JsonService::fail($exception->getMessage());
                }
            }
        }



        /**
         * @return array|bool
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: UpImages
         * @describe:上传图片
         */
        public function UpImages()
        {
            $up = new Upload();
            return $up->upfile("images");
        }


        /**
         * @return false|string
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: Webploader
         * @describe:webuploader上传图片
         */
        public function Webploader(){
            $up = new Upload();
            $res= $up->upfile("album_images");
            if($res['code']==0){
                return  $res['msg'];
            }else{
                return json_encode($res['path']);
            }

        }


        /**
         * @return array|bool
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: UpFile
         * @describe:上传文件
         */
        public function UpFile()
        {
            $up = new Upload();
            return $up->upfile("files");
        }


        /**
         * @param int $with
         * @param int $heig
         * @return array
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: UpThumbImg
         * @describe:生成素略图
         */
        public function UpThumbImg()
        {
            $param = Request::instance()->param();//接收宽高参数
            $with  = 250;
            $heig  = 400;
            if(isset($param['width']) && !empty($param['width'])) {
                $with = $param['width'];
            }
            if(isset($param['height']) && !empty($param['height'])) {
                $heig = $param['height'];
            }
            $up = new Upload();
            return $up->uploadFileThumb($with, $heig);
        }



        /**
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: Jump
         * @describe:菜单找不到
         */
        public function No_rule()
        {
            return $this->fetch("public/no_rule");
        }



        /**
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: down_file
         * @describe:打包下载
         */
        public function down_file(){
            $ids=$this->request->param("ids");
            try{
                $data=db("upload")->where(["id"=>['in',$ids]])->select();
                $down=new DownloadService(); //实例化下载类
                //下面是实例操作过程：
                $dfile = tempnam('/tmp', 'tmp');//产生一个临时文件，用于缓存下载文件
                $filename = date ( 'YmdHis' ) . ".zip"; // 最终生成的文件名（含路径）
                //p($picarray);die;
                foreach($data as $val){
                    $down->add_file(file_get_contents(ROOT_PATH.'public'.$val['file_path']), iconv('UTF-8','gbk',$val['filename']));
                }
                $down->output($dfile);

                $ars = ['describe' => '打包下载文件ID【'.$ids.'】', 'type' => 2, 'admin_name' => self::$admin_info['username'], 'browse' => UtilService::getBrowser(), 'model' => self::$mode_name, 'controller' => self::$controller_name, 'action' => self::$action_name];
                AddLogs($ars); //添加操作日志

                ob_clean();
                header('Pragma: public');
                header('Last-Modified:'.gmdate('D, d M Y H:i:s') . 'GMT');
                header('Cache-Control:no-store, no-cache, must-revalidate');
                header('Cache-Control:pre-check=0, post-check=0, max-age=0');
                header('Content-Transfer-Encoding:binary');
                header('Content-Encoding:none');
                header('Content-type:multipart/form-data');
                header('Content-Disposition:attachment; filename="'.$filename.'"'); //设置下载的默认文件名
                header('Content-length:'. filesize($dfile));

                $fp = fopen($dfile, 'r');
                while(connection_status() == 0 && $buf = @fread($fp, 8192)){
                    echo $buf;
                }
                fclose($fp);
                @unlink($dfile);
                @flush();
                @ob_flush();
                ob_end_clean();
                exit();
                //打包下载结束
            }catch (Exception $exception){
                $this->error($exception->getMessage());
            }
        }



        /**
         * @throws \think\db\exception\DataNotFoundException
         * @throws \think\db\exception\ModelNotFoundException
         * @throws \think\exception\DbException
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: download
         * @describe:文件下载
         */
        public function down_img(){
            $id=input("id"); //文件路径
            $file=db("album_images")->find($id);
            if (!$file){
                $this->error("文件ID不存在");exit;
            }
            $file_name=$file['create_time'];
            $file_path=ROOT_PATH.'public'.$file['img_url'];
            $ext=explode(".",$file['img_url']);
            if(!file_exists($file_path)){
                $this->error("文件不存在");exit;
            }

            $file1=fopen($file_path,"r");
            Header("Content-type: application/octet-stream;charset=utf-8");
            Header("Accept-Ranges: bytes");
            header("Content-Length: " . filesize($file_path));//文件大小
            header('Content-Disposition:attachment;filename="'.$file_name.'.'.$ext[1].'"');
            ob_clean();
            flush();
            echo fread($file1,filesize($file_path)); //输出文件大小到浏览器
            fclose($file1);
            exit();
        }


    }