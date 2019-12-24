<?php

    use app\admin\model\AdminLog;
    use app\admin\model\Setting;
    use app\admin\model\Upload;
    use service\JsonService;
    use service\TimeService;
    use service\TreeService;
    use think\Exception;
    use think\Image;
    use think\Db;
    use think\Request;

    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/6/26-14:14
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: common.php
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





    /**
     * @param $arrs
     * @return bool|int
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: AddLogs
     * @describe: 日志
     */
     function addLogs($arrs){
        $set=new Setting();
        $res=$set->getSetting();
        if((int)$res['safe']['admin_log']==2){ //关闭后台日志
            return true;
        }
         $log=new AdminLog();
        try{
            $resd= $log->allowField(true)->save($arrs);
            return $resd;
        }catch (\Exception $exception){
            JsonService::fail($exception->getMessage());
        }

}



    /**
     * @param $data 下拉框数据源
     * @param int $selected_id 选择数据ID
     * @param string $show_field 显示名称
     * @param string $val_field 显示值
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: make_option
     * @describe: 下拉选择框组件
     */
    function make_option($data, $selected_id = 0, $show_field = 'name', $val_field = 'id')
    {
        $html = '';
        $show_field_arr = explode(',', $show_field);
        //dump($data);
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $show_text = '';
                if (is_array($v)) {
                    foreach ($show_field_arr as $s) {
                        $show_text .= $v[$s] . ' ';
                    }
                    $show_text = substr($show_text, 0, -1);
                    $val_field && $k = $v[$val_field];
                } else {
                    $show_text = $v;
                }
                $sel = '';
                if ($selected_id && $k == $selected_id) {
                    $sel = 'selected';
                }
                $html .= '<option value = ' . $k . ' ' . $sel . '>' . $show_text . '</option>';
            }
        }
        echo $html;
    }

    /**
     * @param $page
     * @param $limit
     * @param array $where
     * @param $tablename
     * @param string $order
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: GetPageData
     * @describe:生成分页数据
     */
    function GetPageData($where,$tablename,$order="create_time desc",$tree=1,$title="title"){

        if(empty($tablename)){
            return JsonService::fail("请填写表格表格");
        }
        try{
            $count=db("$tablename")->where($where)->count("id");
            $data=db("$tablename")->where($where)->order($order)->page(PAGE)->limit(PERPAGE)->select();
            if($tree!=1){
                $data=TreeService::toFormatTree($data,$title); //格式化数据
            }
        }catch (Exception $exception){
            return JsonService::fail($exception->getMessage());
        }
        return JsonService::result(0,"",$data,$count);
    }


    /**
     * @param $filename
     * @return string
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: fileext
     * @describe:获取文件后缀名
     */
    function fileext($filename) {
        return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
    }

    /**
     * @param $filepath
     * @param string $filename
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: file_down
     * @describe: 文件下载
     */
    function file_down($filepath, $filename = '') {
        if(!$filename) $filename = basename($filepath);
        if(is_ie()) $filename = rawurlencode($filename);
        $filetype = fileext($filename);
        $filesize = sprintf("%u", filesize($filepath));
        if(ob_get_length() !== false) @ob_end_clean();
        header('Pragma: public');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: pre-check=0, post-check=0, max-age=0');
        header('Content-Transfer-Encoding: binary');
        header('Content-Encoding: none');
        header('Content-type: '.$filetype);
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Content-length: '.$filesize);
        readfile($filepath);
        exit;
    }


    /**
     * @param $content
     * @return mixed|string
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: match_img
     * @describe: 获取内容中的图片
     */
    function match_img($content){
        preg_match('/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/', $content, $match);
        return !empty($match) ? $match[1] : '';
    }


    /**
     * @param $content
     * @param string $targeturl
     * @return bool|mixed
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: grab_image
     * @describe:获取远程图片并把它保存到本地, 确定您有把文件写入本地服务器的权限
     */
    function grab_image($content, $targeturl = ''){
        preg_match_all('/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/', $content, $img_array);
        $img_array = isset($img_array[1]) ? array_unique($img_array[1]) : array();

        if($img_array) {
            $path =  '/uploads/'.'grap_image/'.date('Ym/d');
            $urlpath = ROOT_PATH.$path;
            $imgpath =  UPLOAD_PATH.$path;
            if(!is_dir($imgpath)) @mkdir($imgpath, 0777, true);
        }

        foreach($img_array as $key=>$value){
            $val = $value;
            if(strpos($value, 'http') === false){
                if(!$targeturl) return $content;
                $value = $targeturl.$value;
            }
            $ext = strrchr($value, '.');
            if($ext!='.png' && $ext!='.jpg' && $ext!='.gif' && $ext!='.jpeg') return false;
            $imgname = date("YmdHis").rand(1,9999).$ext;
            $filename = $imgpath.'/'.$imgname;
            $urlname = $urlpath.'/'.$imgname;

            ob_start();
            readfile($value);
            $data = ob_get_contents();
            ob_end_clean();
            file_put_contents($filename, $data);

            if(is_file($filename)){
                $content = str_replace($val, $urlname, $content);
            }else{
                return $content;
            }
        }
        return $content;
    }



    /**
     * @param null $directory
     * @return bool
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: clear_cache
     * @describe:清除系统缓存
     */
    function clear_cache($directory = null)
    {
        $directory = empty($directory) ? ROOT_PATH . 'runtime/cache/' : $directory;
        if (is_dir($directory) == false) {
            return false;
        }
        $handle = opendir($directory);
        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != "..") {
                is_dir($directory . '/' . $file) ?
                    clear_cache($directory . '/' . $file) :
                    unlink($directory . '/' . $file);
            }
        }
        if (readdir($handle) == false) {
            closedir($handle);
            rmdir($directory);
        }
    }


    /**
     * @param null $directory
     * @return bool
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: clear_log
     * @describe:清除系统日志
     */
    function clear_log($directory = null)
    {
        $directory = empty($directory) ? ROOT_PATH . 'runtime/log/' : $directory;
        if (is_dir($directory) == false) {
            return false;
        }
        $handle = opendir($directory);
        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != "..") {
                is_dir($directory . '/' . $file) ?
                    clear_cache($directory . '/' . $file) :
                    unlink($directory . '/' . $file);
            }
        }
        if (readdir($handle) == false) {
            closedir($handle);
            rmdir($directory);
        }
    }


    /**
     * @param null $directory
     * @return bool
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: clear_temp
     * @describe:刷新系统静态文件
     */
    function clear_temp($directory = null)
    {
        $directory = empty($directory) ? ROOT_PATH . 'runtime/temp/' : $directory;
        if (is_dir($directory) == false) {
            return false;
        }
        $handle = opendir($directory);
        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != "..") {
                is_dir($directory . '/' . $file) ?
                    clear_cache($directory . '/' . $file) :
                    unlink($directory . '/' . $file);
            }
        }
        if (readdir($handle) == false) {
            closedir($handle);
            rmdir($directory);
        }
    }



