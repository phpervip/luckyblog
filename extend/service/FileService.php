<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/6/28-11:05
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: FileService.php
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
     * 文件，文件夹操作
     */

    namespace service;

    class FileService
    {

        /**
         * @param $dir
         * @return bool
         * @author: hhygyl
         * @name: mk_dir
         * @describe:创建目录
         */
        static public function mk_dir($dir)
        {
            $dir = rtrim($dir, '/').'/';
            if(!is_dir($dir)) {
                if(mkdir($dir, 0700)==false) {
                    return false;
                }
                return true;
            }
            return true;
        }


        /**
         * @param $filename
         * @param $writetext
         * @param StringService $openmod
         * @return bool
         * @author: hhygyl
         * @name: write_file
         * @describe:
         */

        static function write_file($filename, $writetext, $openmod = 'w')
        {
            if(@$fp = fopen($filename, $openmod)) {
                flock($fp, 2);
                fwrite($fp, $writetext);
                fclose($fp);
                return true;
            }
            else {
                return false;
            }
        }



        /**
         * @param $dirName
         * @return bool
         * @author: hhygyl
         * @name: del_dir
         * @describe:删除目录
         */
        static function del_dir($dirName)
        {
            if(!file_exists($dirName)) {
                return false;
            }

            $dir = opendir($dirName);
            while ($fileName = readdir($dir)) {
                $file = $dirName.'/'.$fileName;
                if($fileName!='.' && $fileName!='..') {
                    if(is_dir($file)) {
                        self::del_dir($file);
                    }
                    else {
                        unlink($file);
                    }
                }
            }
            closedir($dir);
            return rmdir($dirName);
        }



        /**
         * @param $surDir
         * @param $toDir
         * @return bool
         * @author: hhygyl
         * @name: copy_dir
         * @describe:复制目录
         */
        public function copy_dir($surDir, $toDir)
        {
            $surDir = rtrim($surDir, '/').'/';
            $toDir  = rtrim($toDir, '/').'/';
            if(!file_exists($surDir)) {
                return false;
            }

            if(!file_exists($toDir)) {
                $this->create_dir($toDir);
            }
            $file = opendir($surDir);
            while ($fileName = readdir($file)) {
                $file1 = $surDir.'/'.$fileName;
                $file2 = $toDir.'/'.$fileName;
                if($fileName!='.' && $fileName!='..') {
                    if(is_dir($file1)) {
                        self::copy_dir($file1, $file2);
                    }
                    else {
                        copy($file1, $file2);
                    }
                }
            }
            closedir($file);
            return true;
        }


        /**
         * @param $dir
         * @return array
         * @author: hhygyl
         * @name: get_dirs
         * @describe:列出目录,列出文件夹下内容，返回数组 $dirArray['dir']:存文件夹；$dirArray['file']：存文件
         */
        static function get_dirs($dir)
        {
            $dir           = rtrim($dir, '/').'/';
            $dirArray [][] = NULL;
            if(false!=($handle = opendir($dir))) {
                $i = 0;
                $j = 0;
                while (false!==($file = readdir($handle))) {
                    if(is_dir($dir.$file)) { //判断是否文件夹
                        $dirArray ['dir'] [$i] = $file;
                        $i++;
                    }
                    else {
                        $dirArray ['file'] [$j] = $file;
                        $j++;
                    }
                }
                closedir($handle);
            }
            return $dirArray;
        }


        /**
         * @param $dir
         * @return false|int
         * @author: hhygyl
         * @name: get_size
         * @describe:统计文件夹大小,(单位 B)
         */
        static function get_size($dir)
        {
            $dirlist = opendir($dir);
            $dirsize = 0;
            while (false!==($folderorfile = readdir($dirlist))) {
                if($folderorfile!="." && $folderorfile!="..") {
                    if(is_dir("$dir/$folderorfile")) {
                        $dirsize += self::get_size("$dir/$folderorfile");
                    }
                    else {
                        $dirsize += filesize("$dir/$folderorfile");
                    }
                }
            }
            closedir($dirlist);
            return $dirsize;
        }



        /**
         * @param $dir
         * @return bool
         * @author: hhygyl
         * @name: empty_dir
         * @describe:检测是否为空文件夹
         */
        static function empty_dir($dir)
        {
            return (($files = @scandir($dir)) && count($files) <= 2);
        }



        /**
         * 创建多级目录
         * @param StringService $dir
         * @param int $mode
         * @return boolean
         */
        public function create_dir($dir, $mode = 0777)
        {
            return is_dir($dir) or ($this->create_dir(dirname($dir)) and mkdir($dir, $mode));
        }

        /**
         * 创建指定路径下的指定文件
         * @param StringService $path (需要包含文件名和后缀)
         * @param boolean $over_write 是否覆盖文件
         * @param int $time 设置时间。默认是当前系统时间
         * @param int $atime 设置访问时间。默认是当前系统时间
         * @return boolean
         */
        public function create_file($path, $over_write = false, $time = NULL, $atime = NULL)
        {
            $path  = $this->dir_replace($path);
            $time  = empty($time) ? time() : $time;
            $atime = empty($atime) ? time() : $atime;
            if(file_exists($path) && $over_write) {
                $this->unlink_file($path);
            }
            $aimDir = dirname($path);
            $this->create_dir($aimDir);
            return touch($path, $time, $atime);
        }



        /**
         * 关闭文件操作
         * @param StringService $path
         * @return boolean
         */
        public function close($path)
        {
            return fclose($path);
        }

        /**
         * 读取文件操作
         * @param StringService $file
         * @return boolean
         */
        public static function read_file($file)
        {
            return @file_get_contents($file);
        }

        /**
         * 确定服务器的最大上传限制（字节数）
         * @return int 服务器允许的最大上传字节数
         */
        public function allow_upload_size()
        {
            $val = trim(ini_get('upload_max_filesize'));
            return $val;
        }


        /**
         * 字节格式化 把字节数格式为 B K M G T P E Z Y 描述的大小
         * @param int $size 大小
         * @param int $dec 显示类型
         * @return int
         */
        public static function byte_format($size, $dec = 2)
        {
            $a   = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
            $pos = 0;
            while ($size >= 1024) {
                $size /= 1024;
                $pos++;
            }
            return round($size, $dec)." ".$a[$pos];
        }


        /**
         * @param $dir_path
         * @param bool $is_all
         * @return bool
         * @author: hhygyl
         * @name: remove_dir
         * @describe: 说明:只能删除非系统和特定权限的文件,否则会出现错误
         */
        public function remove_dir($dir_path, $is_all = false)
        {
            $dirName = $this->dir_replace($dir_path);
            $handle  = @opendir($dirName);
            while (($file = @readdir($handle))!==false) {
                if($file!='.' && $file!='..') {
                    $dir = $dirName.'/'.$file;
                    if($is_all) {
                        is_dir($dir) ? $this->remove_dir($dir) : $this->unlink_file($dir);
                    }
                    else {
                        if(is_file($dir)) {
                            $this->unlink_file($dir);
                        }
                    }
                }
            }
            closedir($handle);
            return @rmdir($dirName);
        }



        /**
         * 获取完整文件名
         * @param StringService $fn 路径
         * @return StringService
         */
        public function get_basename($file_path)
        {
            $file_path = $this->dir_replace($file_path);
            return basename(str_replace('\\', '/', $file_path));
            //return pathinfo($file_path,PATHINFO_BASENAME);
        }

        /**
         * 获取文件后缀名
         * @param StringService $file_name 文件路径
         * @return StringService
         */
        public static function get_ext($file)
        {
            $file = self::dir_replace($file);
            //return strtolower(substr(strrchr(basename($file), '.'),1));
            //return end(explode(".",$filename ));
            //return strtolower(trim(array_pop(explode('.', $file))));//取得后缀
            //return preg_replace('/.*\.(.*[^\.].*)*/iU','\\1',$file);
            return pathinfo($file, PATHINFO_EXTENSION);
        }

        /**
         * 取得指定目录名称
         * @param StringService $path 文件路径
         * @param int $num 需要返回以上级目录的数
         * @return StringService
         */
        public function father_dir($path, $num = 1)
        {
            $path = $this->dir_replace($path);
            $arr  = explode('/', $path);
            if($num==0 || count($arr) < $num)
                return pathinfo($path, PATHINFO_BASENAME);
            return substr(strrev($path), 0, 1)=='/' ? $arr[(count($arr) - (1 + $num))] : $arr[(count($arr) - $num)];
        }

        /**
         * 删除文件
         * @param StringService $path
         * @return boolean
         */
        public function unlink_file($path)
        {
            $path = $this->dir_replace($path);
            if(file_exists($path)) {
                return @unlink($path);
            }
        }

        /**
         * 文件操作(复制/移动)
         * @param StringService $old_path 指定要操作文件路径(需要含有文件名和后缀名)
         * @param StringService $new_path 指定新文件路径（需要新的文件名和后缀名）
         * @param StringService $type 文件操作类型
         * @param boolean $overWrite 是否覆盖已存在文件
         * @return boolean
         */
        public function handle_file($old_path, $new_path, $type = 'copy', $overWrite = false)
        {
            $old_path = $this->dir_replace($old_path);
            $new_path = $this->dir_replace($new_path);
            if(file_exists($new_path) && $overWrite = false) {
                return false;
            }
            else if(file_exists($new_path) && $overWrite = true) {
                $this->unlink_file($new_path);
            }

            $aimDir = dirname($new_path);
            $this->create_dir($aimDir);
            switch ($type) {
                case 'copy':
                    return copy($old_path, $new_path);
                    break;
                case 'move':
                    return @rename($old_path, $new_path);
                    break;
            }
        }

        /**
         * 文件夹操作(复制/移动)
         * @param StringService $old_path 指定要操作文件夹路径
         * @param StringService $aimDir 指定新文件夹路径
         * @param StringService $type 操作类型
         * @param boolean $overWrite 是否覆盖文件和文件夹
         * @return boolean
         */
        public function handle_dir($old_path, $new_path, $type = 'copy', $overWrite = false)
        {
            $new_path = $this->check_path($new_path);
            $old_path = $this->check_path($old_path);
            if(!is_dir($old_path))
                return false;

            if(!file_exists($new_path))
                $this->create_dir($new_path);

            $dirHandle = opendir($old_path);

            if(!$dirHandle)
                return false;

            $boolean = true;

            while (false!==($file = readdir($dirHandle))) {
                if($file=='.' || $file=='..')
                    continue;

                if(!is_dir($old_path.$file)) {
                    $boolean = $this->handle_file($old_path.$file, $new_path.$file, $type, $overWrite);
                }
                else {
                    $this->handle_dir($old_path.$file, $new_path.$file, $type, $overWrite);
                }
            }
            switch ($type) {
                case 'copy':
                    closedir($dirHandle);
                    return $boolean;
                    break;
                case 'move':
                    closedir($dirHandle);
                    return @rmdir($old_path);
                    break;
            }
        }

        /**
         * 替换相应的字符
         * @param StringService $path 路径
         * @return StringService
         */
        public static function dir_replace($path)
        {
            return str_replace('//', '/', str_replace('\\', '/', $path));
        }

        /**
         * 读取指定路径下模板文件
         * @param StringService $path 指定路径下的文件
         * @return StringService $rstr
         */
        public static function get_templtes($path)
        {
            $path = self::dir_replace($path);
            if(file_exists($path)) {
                $fp   = fopen($path, 'r');
                $rstr = fread($fp, filesize($path));
                fclose($fp);
                return $rstr;
            }
            else {
                return '';
            }
        }


        /**
         * @param $oldname
         * @param $newname
         * @return bool
         * @author: hhygyl
         * @name: rename
         * @describe:文件重命名
         */
        public function rename($oldname, $newname)
        {
            if(($newname!=$oldname) && is_writable($oldname)) {
                return rename($oldname, $newname);
            }
        }

        /**
         * 获取指定路径下的信息
         * @param StringService $dir 路径
         * @return ArrayObject
         */
        public function get_dir_info($dir)
        {
            $handle          = @opendir($dir);//打开指定目录
            $directory_count = 0;
            $total_size="";
            $file_cout="";
            while (false!==($file_path = readdir($handle))) {
                if($file_path!="." && $file_path!="..") {
                    //is_dir("$dir/$file_path") ? $sizeResult += $this->get_dir_size("$dir/$file_path") : $sizeResult += filesize("$dir/$file_path");
                    $next_path = $dir.'/'.$file_path;
                    if(is_dir($next_path)) {
                        $directory_count++;
                        $result_value    = self::get_dir_info($next_path);
                        $total_size      += $result_value['size'];
                        $file_cout       += $result_value['filecount'];
                        $directory_count += $result_value['dircount'];
                    }
                    else if(is_file($next_path)) {
                        $total_size += filesize($next_path);
                        $file_cout++;
                    }
                }
            }
            closedir($handle);//关闭指定目录
            $result_value['size']      = $total_size;
            $result_value['filecount'] = $file_cout;
            $result_value['dircount']  = $directory_count;
            return $result_value;
        }

        /**
         * 指定文件编码转换
         * @param StringService $path 文件路径
         * @param StringService $input_code 原始编码
         * @param StringService $out_code 输出编码
         * @return boolean
         */
        public function change_file_code($path, $input_code, $out_code)
        {
            if(is_file($path))//检查文件是否存在,如果存在就执行转码,返回真
            {
                $content = file_get_contents($path);
                $content = StringService::chang_code($content, $input_code, $out_code);
                $fp      = fopen($path, 'w');
                return fputs($fp, $content) ? true : false;
                fclose($fp);
            }
        }

        /**
         * 指定目录下指定条件文件编码转换
         * @param StringService $dirname 目录路径
         * @param StringService $input_code 原始编码
         * @param StringService $out_code 输出编码
         * @param boolean $is_all 是否转换所有子目录下文件编码
         * @param StringService $exts 文件类型
         * @return boolean
         */
        public function change_dir_files_code($dirname, $input_code, $out_code, $is_all = true, $exts = '')
        {
            if(is_dir($dirname)) {
                $fh = opendir($dirname);
                while (($file = readdir($fh))!==false) {
                    if(strcmp($file, '.')==0 || strcmp($file, '..')==0) {
                        continue;
                    }
                    $filepath = $dirname.'/'.$file;

                    if(is_dir($filepath) && $is_all==true) {
                        $files = $this->change_dir_files_code($filepath, $input_code, $out_code, $is_all, $exts);
                    }
                    else {
                        if($this->get_ext($filepath)==$exts && is_file($filepath)) {
                            $boole = $this->change_file_code($filepath, $input_code, $out_code, $is_all, $exts);
                            if(!$boole)
                                continue;
                        }
                    }
                }
                closedir($fh);
                return true;
            }
            else {
                return false;
            }
        }

        /**
         * 列出指定目录下符合条件的文件和文件夹
         * @param StringService $dirname 路径
         * @param boolean $is_all 是否列出子目录中的文件
         * @param StringService $exts 需要列出的后缀名文件
         * @param StringService $sort 数组排序
         * @return ArrayObject
         */
        public function list_dir_info($dirname, $is_all = false, $exts = '', $sort = 'ASC')
        {
            //处理多于的/号
            $new = strrev($dirname);
            if(strpos($new, '/')==0) {
                $new = substr($new, 1);
            }
            $dirname = strrev($new);

            $sort = strtolower($sort);//将字符转换成小写

            $files    = [];
            $subfiles = [];

            if(is_dir($dirname)) {
                $fh = opendir($dirname);
                while (($file = readdir($fh))!==false) {
                    if(strcmp($file, '.')==0 || strcmp($file, '..')==0)
                        continue;

                    $filepath = $dirname.'/'.$file;

                    switch ($exts) {
                        case '*':
                            if(is_dir($filepath) && $is_all==true) {
                                $files = array_merge($files, self::list_dir_info($filepath, $is_all, $exts, $sort));
                            }
                            array_push($files, $filepath);
                            break;
                        case 'folder':
                            if(is_dir($filepath) && $is_all==true) {
                                $files = array_merge($files, self::list_dir_info($filepath, $is_all, $exts, $sort));
                                array_push($files, $filepath);
                            }
                            else if(is_dir($filepath)) {
                                array_push($files, $filepath);
                            }
                            break;
                        case 'file':
                            if(is_dir($filepath) && $is_all==true) {
                                $files = array_merge($files, self::list_dir_info($filepath, $is_all, $exts, $sort));
                            }
                            else if(is_file($filepath)) {
                                array_push($files, $filepath);
                            }
                            break;
                        default:
                            if(is_dir($filepath) && $is_all==true) {
                                $files = array_merge($files, self::list_dir_info($filepath, $is_all, $exts, $sort));
                            }
                            else if(preg_match("/\.($exts)/i", $filepath) && is_file($filepath)) {
                                array_push($files, $filepath);
                            }
                            break;
                    }

                    switch ($sort) {
                        case 'asc':
                            sort($files);
                            break;
                        case 'desc':
                            rsort($files);
                            break;
                        case 'nat':
                            natcasesort($files);
                            break;
                    }
                }
                closedir($fh);
                return $files;
            }
            else {
                return false;
            }
        }

        /**
         * 返回指定路径的文件夹信息，其中包含指定路径中的文件和目录
         * @param StringService $dir
         * @return ArrayObject
         */
        public function dir_info($dir)
        {
            return scandir($dir);
        }

        /**
         * 判断目录是否为空
         * @param StringService $dir
         * @return boolean
         */
        public function is_empty($dir)
        {
            $handle = opendir($dir);
            while (($file = readdir($handle))!==false) {
                if($file!='.' && $file!='..') {
                    closedir($handle);
                    return true;
                }
            }
            closedir($handle);
            return false;
        }

        /**
         * 返回指定文件和目录的信息
         * @param StringService $file
         * @return ArrayObject
         */
        public static function list_info($file)
        {
            $dir               = [];
            $dir['filename']   = basename($file);//返回路径中的文件名部分。
            $dir['pathname']   = realpath($file);//返回绝对路径名。
            $dir['owner']      = fileowner($file);//文件的 user ID （所有者）。
            $dir['perms']      = fileperms($file);//返回文件的 inode 编号。
            $dir['inode']      = fileinode($file);//返回文件的 inode 编号。
            $dir['group']      = filegroup($file);//返回文件的组 ID。
            $dir['path']       = dirname($file);//返回路径中的目录名称部分。
            $dir['atime']      = fileatime($file);//返回文件的上次访问时间。
            $dir['ctime']      = filectime($file);//返回文件的上次改变时间。
            $dir['perms']      = fileperms($file);//返回文件的权限。
            $dir['size']       = self::byte_format(filesize($file), 2);//返回文件大小。
            $dir['type']       = filetype($file);//返回文件类型。
            $dir['ext']        = is_file($file) ? pathinfo($file, PATHINFO_EXTENSION) : '';//返回文件后缀名
            $dir['mtime']      = filemtime($file);//返回文件的上次修改时间。
            $dir['isDir']      = is_dir($file);//判断指定的文件名是否是一个目录。
            $dir['isFile']     = is_file($file);//判断指定文件是否为常规的文件。
            $dir['isLink']     = is_link($file);//判断指定的文件是否是连接。
            $dir['isReadable'] = is_readable($file);//判断文件是否可读。
            $dir['isWritable'] = is_writable($file);//判断文件是否可写。
            $dir['isUpload']   = is_uploaded_file($file);//判断文件是否是通过 HTTP POST 上传的。
            return $dir;
        }

        /**
         * 返回关于打开文件的信息
         * @param $file
         * @return ArrayObject
         * 数字下标     关联键名（自 PHP 4.0.6）     说明
         * 0     dev     设备名
         * 1     ino     号码
         * 2     mode     inode 保护模式
         * 3     nlink     被连接数目
         * 4     uid     所有者的用户 id
         * 5     gid     所有者的组 id
         * 6     rdev     设备类型，如果是 inode 设备的话
         * 7     size     文件大小的字节数
         * 8     atime     上次访问时间（Unix 时间戳）
         * 9     mtime     上次修改时间（Unix 时间戳）
         * 10     ctime     上次改变时间（Unix 时间戳）
         * 11     blksize     文件系统 IO 的块大小
         * 12     blocks     所占据块的数目
         */
        public function open_info($file)
        {
            $file   = fopen($file, "r");
            $result = fstat($file);
            fclose($file);
            return $result;
        }

        /**
         * 改变文件和目录的相关属性
         * @param StringService $file 文件路径
         * @param StringService $type 操作类型
         * @param StringService $ch_info 操作信息
         * @return boolean
         */
        public function change_file($file, $type, $ch_info)
        {
            switch ($type) {
                case 'group' :
                    $is_ok = chgrp($file, $ch_info);//改变文件组。
                    break;
                case 'mode' :
                    $is_ok = chmod($file, $ch_info);//改变文件模式。
                    break;
                case 'ower' :
                    $is_ok = chown($file, $ch_info);//改变文件所有者。
                    break;
            }
        }

        /**
         * 取得文件路径信息
         * @param $full_path 完整路径
         * @return ArrayObject
         */
        public function get_file_type($path)
        {
            //pathinfo() 函数以数组的形式返回文件路径的信息。
            //---------$file_info = pathinfo($path); echo file_info['extension'];----------//
            //extension取得文件后缀名【pathinfo($path,PATHINFO_EXTENSION)】-----dirname取得文件路径【pathinfo($path,PATHINFO_DIRNAME)】-----basename取得文件完整文件名【pathinfo($path,PATHINFO_BASENAME)】-----filename取得文件名【pathinfo($path,PATHINFO_FILENAME)】
            return pathinfo($path);
        }

        /**
         * 取得上传文件信息
         * @param $file file属性信息
         * @return array
         */
        public function get_upload_file_info($file)
        {
            $file_info     = $_FILES[$file];//取得上传文件基本信息
            $info          = [];
            $info['type']  = strtolower(trim(stripslashes(preg_replace("/^(.+?);.*$/", "\\1", $file_info['type'])), '"'));//取得文件类型
            $info['temp']  = $file_info['tmp_name'];//取得上传文件在服务器中临时保存目录
            $info['size']  = $file_info['size'];//取得上传文件大小
            $info['error'] = $file_info['error'];//取得文件上传错误
            $info['name']  = $file_info['name'];//取得上传文件名
            $info['ext']   = $this->get_ext($file_info['name']);//取得上传文件后缀
            return $info;
        }

        /**
         * 设置文件命名规则
         * @param StringService $type 命名规则
         * @param StringService $filename 文件名
         * @return StringService
         */
        public function set_file_name($type)
        {
            switch ($type) {
                case 'hash' :
                    $new_file = md5(uniqid(mt_rand()));//mt_srand()以随机数md5加密来命名
                    break;
                case 'time' :
                    $new_file = time();
                    break;
                default :
                    $new_file = date($type, time());//以时间格式来命名
                    break;
            }
            return $new_file;
        }

        /**
         * 文件保存路径处理
         * @return StringService
         */
        public function check_path($path)
        {
            return (preg_match('/\/$/', $path)) ? $path : $path.'/';
        }

        /**
         * 文件下载
         * $save_dir 保存路径
         * $filename 文件名
         * @return array
         */
        public static function down_remote_file($url, $save_dir = '', $filename = '', $type = 0)
        {

            if(trim($url)=='') {
                return ['file_name' => '', 'save_path' => '', 'error' => 1];
            }
            if(trim($save_dir)=='') {
                $save_dir = './';
            }
            if(trim($filename)=='') {//保存文件名
                $ext = strrchr($url, '.');
                //    if($ext!='.gif'&&$ext!='.jpg'){
                //        return array('file_name'=>'','save_path'=>'','error'=>3);
                //    }
                $filename = time().$ext;
            }
            if(0!==strrpos($save_dir, '/')) {
                $save_dir .= '/';
            }
            //创建保存目录
            if(!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
                return ['file_name' => '', 'save_path' => '', 'error' => 5];
            }
            //获取远程文件所采用的方法
            if($type) {
                $ch      = curl_init();
                $timeout = 5;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $img = curl_exec($ch);
                curl_close($ch);
            }
            else {
                ob_start();
                readfile($url);
                $img = ob_get_contents();
                ob_end_clean();
            }
            //$size=strlen($img);
            //文件大小
            $fp2 = fopen($save_dir.$filename, 'a');

            fwrite($fp2, $img);
            fclose($fp2);
            unset($img, $url);
            return ['file_name' => $filename, 'save_path' => $save_dir.$filename, 'error' => 0];
        }



        /**
         * @param $filename
         * @param $savename
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: zipopen
         * @describe:解压zip文件
         */
        public static function zipopen($filename, $savename)
        {
            $zip     = new \ZipArchive;
            $zipfile = $filename;
            $res     = $zip->open($zipfile);
            $toDir   = $savename;
            if(!file_exists($toDir))
                mkdir($toDir, 0777);
            $docnum = $zip->numFiles;
            for($i = 0; $i < $docnum; $i++){
                $statInfo = $zip->statIndex($i);
                if($statInfo['crc']==0 && $statInfo['comp_size']!=2) {
                    //新建目录
                    mkdir($toDir.'/'.substr($statInfo['name'], 0, -1), 0777);
                }
                else {
                    //拷贝文件
                    copy('zip://'.$zipfile.'#'.$statInfo['name'], $toDir.'/'.$statInfo['name']);
                }
            }
            $zip->close();
            return true;
        }

        /**
         *设置字体格式
         * @param $title StringService 必选
         * return string
         */
        public static function setUtf8($title)
        {
            return iconv('utf-8', 'gb2312', $title);
        }

        /**
         *检查指定文件是否能写入
         * @param $file StringService 必选
         * return boole
         */
        public static function isWritable($file)
        {
            $file = str_replace('\\', '/', $file);
            if(!file_exists($file))
                return false;
            return is_writable($file);
        }



    }