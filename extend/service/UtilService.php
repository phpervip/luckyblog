<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/1-11:31
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: Util.php
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

    namespace service;

    use think\Request;

    class UtilService
    {


        /**
         * @param $params
         * @param Request|null $request
         * @param bool $suffix
         * @return array
         * @author: hhygyl
         * @name: postMore
         * @describe:获取post请求的数据
         */
        public static function postMore($params, Request $request = null, $suffix = false)
        {
            if($request===null)
                $request = Request::instance();
            $p = [];
            $i = 0;
            foreach($params as $param){
                if(!is_array($param)) {
                    $p[$suffix==true ? $i++ : $param] = $request->post($param);
                }
                else {
                    if(!isset($param[1]))
                        $param[1] = null;
                    if(!isset($param[2]))
                        $param[2] = '';
                    $name                                                                 = is_array($param[1]) ? $param[0].'/a' : $param[0];
                    $p[$suffix==true ? $i++ : (isset($param[3]) ? $param[3] : $param[0])] = $request->post($name, $param[1], $param[2]);
                }
            }
            return $p;
        }



        /**
         * @param $params
         * @param Request|null $request
         * @param bool $suffix
         * @return array
         * @author: hhygyl
         * @name: getMore
         * @describe:获取get请求的数据
         */
        public static function getMore($params, Request $request = null, $suffix = false)
        {
            if($request===null)
                $request = Request::instance();
            $p = [];
            $i = 0;
            foreach($params as $param){
                if(!is_array($param)) {
                    $p[$suffix==true ? $i++ : $param] = $request->get($param);
                }
                else {
                    if(!isset($param[1]))
                        $param[1] = null;
                    if(!isset($param[2]))
                        $param[2] = '';
                    $name                                                                 = is_array($param[1]) ? $param[0].'/a' : $param[0];
                    $p[$suffix==true ? $i++ : (isset($param[3]) ? $param[3] : $param[0])] = $request->get($name, $param[1], $param[2]);
                }
            }
            return $p;
        }



        /**
         * @param $data
         * @param StringService $key
         * @param int $expire
         * @return mixed
         * @author: hhygyl < hhygyl520@qq.com >
         * @name: think_encrypt
         * @describe:系统加密方法
         */
        public static function think_encrypt($data, $key = 'http://dao.hhygyl.cn', $expire = 0)
        {
            $key  = md5(empty($key) ? config("pwd_script") : $key);
            $data = base64_encode($data);
            $x    = 0;
            $len  = strlen($data);
            $l    = strlen($key);
            $char = '';

            for($i = 0; $i < $len; $i++){
                if($x==$l)
                    $x = 0;
                $char .= substr($key, $x, 1);
                $x++;
            }

            $str = sprintf('%010d', $expire ? $expire + time() : 0);

            for($i = 0; $i < $len; $i++){
                $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
            }
            return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($str));
        }

        /**
         * @param $data
         * @param StringService $key
         * @return bool|StringService
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: think_decrypt
         * @describe:系统解密方法
         */
        public static function think_decrypt($data, $key = 'http://dao.hhygyl.cn')
        {
            $key  = md5(empty($key) ? config("pwd_script") : $key);
            $data = str_replace(['-', '_'], ['+', '/'], $data);
            $mod4 = strlen($data)%4;
            if($mod4) {
                $data .= substr('====', $mod4);
            }
            $data   = base64_decode($data);
            $expire = substr($data, 0, 10);
            $data   = substr($data, 10);

            if($expire > 0 && $expire < time()) {
                return '';
            }
            $x    = 0;
            $len  = strlen($data);
            $l    = strlen($key);
            $char = $str = '';

            for($i = 0; $i < $len; $i++){
                if($x==$l)
                    $x = 0;
                $char .= substr($key, $x, 1);
                $x++;
            }

            for($i = 0; $i < $len; $i++){
                if(ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
                    $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
                }
                else {
                    $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
                }
            }
            return base64_decode($str);
        }



             /**
         * @param $url
         * @return bool
         * @author: hhygyl <jackhhy520@qq.com>
         * @name: is_url
         * @describe:验证url
         */
        public static function is_url($url){
            if(empty($url)) return false;
            if(preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)){
                return true;
            }else{
                return false;
            }
        }

        /**
         * @param $path
         * @return StringService
         * @author: hhygyl
         * @name: pathToUrl
         * @describe:路径转url路径
         */
        public static function pathToUrl($path)
        {
            return trim(str_replace(DS, '/', $path), '.');
        }

        /**
         * @param $url
         * @return StringService
         * @author: hhygyl
         * @name: urlToPath
         * @describe:url转换路径
         */
        public static function urlToPath($url)
        {
            return ROOT_PATH.trim(str_replace('/', DS, $url), DS);
        }


        /**
         * @param $str
         * @return mixed
         * @author: hhygyl
         * @name: hide_phone
         * @describe:替换手机号码中间四位数字
         */
        public static function hide_phone($str)
        {
            $resstr = substr_replace($str, '****', 3, 4);
            return $resstr;
        }


        /**
         * 格式化字节大小
         * @param number $size 字节数
         * @param StringService $delimiter 数字和单位分隔符
         * @return StringService            格式化后的带单位的大小
         */
        public static function format_bytes($size, $delimiter = '')
        {
            $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
            for($i = 0; $size >= 1024 && $i < 5; $i++)
                $size /= 1024;
            return round($size, 2).$delimiter.$units[$i];
        }


        /**
         * @return bool
         * @author: hhygyl
         * @name: isWechatBrowser
         * @describe:是否为微信内部浏览器
         */
        public static function isWechatBrowser()
        {
            return (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false);
        }

        /**
         * @param $name
         * @return StringService
         * @author: hhygyl
         * @name: anonymity
         * @describe:匿名处理
         */
        public static function anonymity($name)
        {
            $strLen = mb_strlen($name, 'UTF-8');
            $min    = 3;
            if($strLen <= 1)
                return '*';
            if($strLen <= $min)
                return mb_substr($name, 0, 1, 'UTF-8').str_repeat('*', $min - 1);
            else
                return mb_substr($name, 0, 1, 'UTF-8').str_repeat('*', $strLen - 1).mb_substr($name, -1, 1, 'UTF-8');
        }

        /**
         * @param $card
         * @return bool
         * @author: hhygyl
         * @name: setCard
         * @describe:身份证验证
         */
        public static function setCard($card)
        {
            $city  = [11 => "北京", 12 => "天津", 13 => "河北", 14 => "山西", 15 => "内蒙古", 21 => "辽宁", 22 => "吉林", 23 => "黑龙江 ", 31 => "上海", 32 => "江苏", 33 => "浙江", 34 => "安徽", 35 => "福建", 36 => "江西", 37 => "山东", 41 => "河南", 42 => "湖北 ", 43 => "湖南", 44 => "广东", 45 => "广西", 46 => "海南", 50 => "重庆", 51 => "四川", 52 => "贵州", 53 => "云南", 54 => "西藏 ", 61 => "陕西", 62 => "甘肃", 63 => "青海", 64 => "宁夏", 65 => "新疆", 71 => "台湾", 81 => "香港", 82 => "澳门", 91 => "国外 "];
            $tip   = "";
            $match = "/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/";
            $pass  = true;
            if(!$card || !preg_match($match, $card)) {
                //身份证格式错误
                $pass = false;
            }
            else if(!$city[substr($card, 0, 2)]) {
                //地址错误
                $pass = false;
            }
            else {
                //18位身份证需要验证最后一位校验位
                if(strlen($card)==18) {
                    $card = str_split($card);
                    //∑(ai×Wi)(mod 11)
                    //加权因子
                    $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
                    //校验位
                    $parity = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];
                    $sum    = 0;
                    $ai     = 0;
                    $wi     = 0;
                    for($i = 0; $i < 17; $i++){
                        $ai  = $card[$i];
                        $wi  = $factor[$i];
                        $sum += $ai*$wi;
                    }
                    $last = $parity[$sum%11];
                    if($parity[$sum%11]!=$card[17]) {
                        //                        $tip = "校验位错误";
                        $pass = false;
                    }
                }
                else {
                    $pass = false;
                }
            }
            if(!$pass)
                return false;/* 身份证格式错误*/
            return true;/* 身份证格式正确*/
        }



        /**
         * @return bool
         * @author: hhygyl
         * @name: is_mobile
         * @describe:判断是否为手机访问
         */
        public static function is_mobile()
        {
            static $is_mobile;

            if(isset($is_mobile)) {
                return $is_mobile;
            }

            if(empty($_SERVER['HTTP_USER_AGENT'])) {
                $is_mobile = false;
            }
            else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'Android')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi')!==false) {
                $is_mobile = true;
            }
            else {
                $is_mobile = false;
            }

            return $is_mobile;
        }



        /**
         * @return StringService
         * @author: hhygyl
         * @name: getOS
         * @describe:获取客户端操作系统
         */
        public static function getOS()
        {
            $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
            if(strpos($agent, 'windows')) {
                $platform = 'windows';
            }
            else if(strpos($agent, 'macintosh')) {
                $platform = 'mac';
            }
            else if(strpos($agent, 'ipod')) {
                $platform = 'ipod';
            }
            else if(strpos($agent, 'ipad')) {
                $platform = 'ipad';
            }
            else if(strpos($agent, 'iphone')) {
                $platform = 'iphone';
            }
            else if(strpos($agent, 'android')) {
                $platform = 'android';
            }
            else if(strpos($agent, 'unix')) {
                $platform = 'unix';
            }
            else if(strpos($agent, 'linux')) {
                $platform = 'linux';
            }
            else {
                $platform = 'other';
            }
            return $platform;
        }


        /**
         * @return array
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: getBrowser
         * @describe:获取浏览器模式
         */
        public static function getBrowser()
        {
            // 获取用户代理基本信息
            $flag = $_SERVER['HTTP_USER_AGENT'];
            // 定义一个空数组
            $para = array();
            // 检查操作系统

            if (preg_match('/Chrome\/[\d\.\w]*/', $flag, $match)) {
                // 检查Chrome
                $para['browser'] = $match[0];
            } elseif (preg_match('/Safari\/[\d\.\w]*/', $flag, $match)) {
                // 检查Safari
                $para['browser'] = $match[0];
            } elseif (preg_match('/MSIE [\d\.\w]*/', $flag, $match)) {
                // IE
                $para['browser'] = $match[0];
            } elseif (preg_match('/Opera\/[\d\.\w]*/', $flag, $match)) {
                // opera
                $para['browser'] = $match[0];
            } elseif (preg_match('/Firefox\/[\d\.\w]*/', $flag, $match)) {
                // Firefox
                $para['browser'] = $match[0];
            } elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $flag, $match)) {
                //OmniWeb
                $para['browser'] = $match[2];
            } elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $flag, $match)) {
                //Netscape
                $para['browser'] = $match[2];
            } elseif (preg_match('/Lynx\/([^\s]+)/i', $flag, $match)) {
                //Lynx
                $para['browser'] = $match[1];
            } elseif (preg_match('/360SE/i', $flag, $match)) {
                //360SE
                $para['browser'] = '360安全浏览器';
            } elseif (preg_match('/SE 2.x/i', $flag, $match)) {
                //搜狗
                $para['browser'] = '搜狗浏览器';
            } else {
                $para['browser'] = 'unkown';
            }
            // 数据返回
            return $para['browser'];
        }




        /**
         * @return string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: get_url
         * @describe:获取当前页面完整URL地址
         */
        public static function get_url()
        {
            $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT']=='443' ? 'https://' : 'http://';
            $php_self     = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
            $path_info    = isset($_SERVER['PATH_INFO']) ? safe_replace($_SERVER['PATH_INFO']) : '';
            $relate_url   = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.safe_replace($_SERVER['QUERY_STRING']) : $path_info);
            return $sys_protocal.HTTP_HOST.$relate_url;
        }


        /**
         * @return mixed|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: getip
         * @describe:获取IP地址
         */
        public static function getip()
        {
            if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
                $ip = getenv('HTTP_CLIENT_IP');
            }
            else if(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            }
            else if(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
                $ip = getenv('REMOTE_ADDR');
            }
            else if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches [0] : '127.0.0.1';
        }


        /**
         * @param $email
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: is_email
         * @describe:判断email格式是否正确
         */
        public static function is_email($email)
        {
            return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
        }


        /**
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: is_ie
         * @describe:IE浏览器判断
         */
        public static function is_ie()
        {
            $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
            if((strpos($useragent, 'opera')!==false) || (strpos($useragent, 'konqueror')!==false))
                return false;
            if(strpos($useragent, 'msie ')!==false)
                return true;
            return false;
        }



    }