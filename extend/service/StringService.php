<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/1-11:55
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: String.php
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
     * 字符串处理类
     */

    namespace service;

    class StringService
    {

        /**
         * @param $string
         * @param string $operation 操作标识。DECODE为解密
         * @param string $key
         * @param int $expiry
         * @return bool|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: authcode
         * @describe: 字符串解密加密
         */
       public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
            $ckey_length = 4; // 随机密钥长度 取值 0-32;
            // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
            // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
            // 当此值为 0 时，则不产生随机密钥
            $uc_key = config('data_auth_key') ? config('data_auth_key') : 'eacoophp';
            $key    = md5($key ? $key : $uc_key);
            $keya   = md5(substr($key, 0, 16));
            $keyb   = md5(substr($key, 16, 16));
            $keyc   = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

            $cryptkey   = $keya . md5($keya . $keyc);
            $key_length = strlen($cryptkey);

            $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;

            $string_length = strlen($string);
            $result        = '';
            $box           = range(0, 255);
            $rndkey        = [];
            for ($i = 0; $i <= 255; $i++) {
                $rndkey[$i] = ord($cryptkey[$i % $key_length]);
            }

            for ($j = $i = 0; $i < 256; $i++) {
                $j       = ($j + $box[$i] + $rndkey[$i]) % 256;
                $tmp     = $box[$i];
                $box[$i] = $box[$j];
                $box[$j] = $tmp;
            }

            for ($a = $j = $i = 0; $i < $string_length; $i++) {
                $a       = ($a + 1) % 256;
                $j       = ($j + $box[$a]) % 256;
                $tmp     = $box[$a];
                $box[$a] = $box[$j];
                $box[$j] = $tmp;
                $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
            }

            if ($operation == 'DECODE') {
                if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                    return substr($result, 26);
                } else {
                    return '';
                }
            } else {
                return $keyc . str_replace('=', '', base64_encode($result));
            }
        }


        /**
         * @param $string
         * @return string|string[]|null
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: remove_xss
         * @describe:过滤xss攻击
         */
       public static function remove_xss($string) {
            $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $string);

            $parm1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');

            $parm2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');

            $parm = array_merge($parm1, $parm2);

            for ($i = 0; $i < sizeof($parm); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($parm[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[x|X]0([9][a][b]);?)?';
                        $pattern .= '|(&#0([9][10][13]);?)?';
                        $pattern .= ')?';
                    }
                    $pattern .= $parm[$i][$j];
                }
                $pattern .= '/i';
                $string = preg_replace($pattern, ' ', $string);
            }
            return $string;
        }


        /**
         * @param string $prefix
         * @return string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: create_uuid
         * @describe:密钥串
         */
        public static function create_uuid($prefix = ""){
            $str = md5(uniqid(mt_rand(), true));
            $uuid  = substr($str,0,8) . '-';
            $uuid .= substr($str,8,4) . '-';
            $uuid .= substr($str,12,4) . '-';
            $uuid .= substr($str,16,4) . '-';
            $uuid .= substr($str,20,12);
            return strtoupper($prefix . $uuid);
        }

        /**
         * @param string $string
         * @param string $skey 加密key
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: symmetry_encode
         * @describe:简单对称加密算法之加密
         */
       public static function symmetry_encode($string = '', $skey = 'http://www.hhygyl.cn/') {
            $strArr = str_split(base64_encode($string));
            $strCount = count($strArr);
            foreach (str_split($skey) as $key => $value)
                $key < $strCount && $strArr[$key].=$value;
            return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
        }


        /**
         * @param string $string
         * @param string $skey
         * @return bool|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: symmetry_decode
         * @describe:简单对称加密算法之解密
         */
       public static function symmetry_decode($string = '', $skey = 'http://www.hhygyl.cn/') {
            $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
            $strCount = count($strArr);
            foreach (str_split($skey) as $key => $value)
                $key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
            return base64_decode(join('', $strArr));
        }

        /**
         * @param $length
         * @param string $extra
         * @return bool|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: build_user_no
         * @describe:生成唯一用户ID号
         */
       public static function build_user_no($length, $extra = ''){
            if (!empty($extra)) {
                $no_code = substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))).mb_substr($extra, -5, 5, 'utf8'), 0, $length);
            } else {
                $no_code = substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, $length);
            }
            return $no_code;
        }


        /**
         * @param $data
         * @return array|mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: string2array
         * @describe:将字符串转换为数组
         */
        public static function  string2array($data)
        {
            if ($data == '') return array();
            return unserialize($data);
        }

        /**
         * @param $data
         * @param int $isformdata
         * @return string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: array2string
         * @describe:将数组转换为字符串
         */
        public static function array2string($data, $isformdata = 1)
        {
            if ($data == '') return '';
            if ($isformdata) $data = self::new_stripslashes($data);
            return serialize($data);
        }


        /**
         * @param $string
         * @return array|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: new_stripslashes
         * @describe:返回经stripslashes处理过的字符串或数组
         */
        protected static function new_stripslashes($string)
        {
            if (!is_array($string)) return stripslashes($string);
            foreach ($string as $key => $val) $string[$key] = self::new_stripslashes($val);
            return $string;
        }



        /**
         * @param $string
         * @param $length
         * @param string $dot
         * @param string $code
         * @return mixed|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: str_cut
         * @describe:字符串截取
         */
        public static function str_cut($string, $length, $dot = '...', $code = 'utf-8') {
            $strlen = strlen($string);
            if($strlen <= $length) return $string;
            $string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
            $strcut = '';
            if($code == 'utf-8') {
                $length = intval($length-strlen($dot)-$length/3);
                $n = $tn = $noc = 0;
                while($n < strlen($string)) {
                    $t = ord($string[$n]);
                    if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                        $tn = 1; $n++; $noc++;
                    } elseif(194 <= $t && $t <= 223) {
                        $tn = 2; $n += 2; $noc += 2;
                    } elseif(224 <= $t && $t <= 239) {
                        $tn = 3; $n += 3; $noc += 2;
                    } elseif(240 <= $t && $t <= 247) {
                        $tn = 4; $n += 4; $noc += 2;
                    } elseif(248 <= $t && $t <= 251) {
                        $tn = 5; $n += 5; $noc += 2;
                    } elseif($t == 252 || $t == 253) {
                        $tn = 6; $n += 6; $noc += 2;
                    } else {
                        $n++;
                    }
                    if($noc >= $length) {
                        break;
                    }
                }
                if($noc > $length) {
                    $n -= $tn;
                }
                $strcut = substr($string, 0, $n);
                $strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
            } else {
                $dotlen = strlen($dot);
                $maxi = $length - $dotlen - 1;
                $current_str = '';
                $search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
                $replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
                $search_flip = array_flip($search_arr);
                for ($i = 0; $i < $maxi; $i++) {
                    $current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
                    if (in_array($current_str, $search_arr)) {
                        $key = $search_flip[$current_str];
                        $current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
                    }
                    $strcut .= $current_str;
                }
            }
            return $strcut.$dot;
        }


        /**
         * @param $str
         * @param int $start 开始位置
         * @param $length 截取长度
         * @param string $charset 编码格式
         * @param bool $suffix 截断显示字符
         * @return false|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: msubstr
         * @describe:字符串截取，支持中文和其他编码
         */
       public static function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
            if(function_exists("mb_substr"))
                $slice = mb_substr($str, $start, $length, $charset);
            elseif(function_exists('iconv_substr')) {
                $slice = iconv_substr($str,$start,$length,$charset);
                if(false === $slice) {
                    $slice = '';
                }
            } else{
                $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
                $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
                $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
                $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
                preg_match_all($re[$charset], $str, $match);
                $slice = join("",array_slice($match[0], $start, $length));
            }
            return $suffix ? $slice.'...' : $slice;
        }


        /**
         * @param $str
         * @param int $len 截取的长度
         * @param int $start 从第几个字符开始截取
         * @param int $suffix 是否在截取后的字符串后跟上省略号
         * @return string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: cut_str
         * @describe:字符串截取指定长度
         */
        public static function cut_str($str, $len = 100, $start = 0, $suffix = 1) {
            $str = strip_tags(trim(strip_tags($str)));
            $str = str_replace(array("\n", "\t"), "", $str);
            $strlen = mb_strlen($str);
            while ($strlen) {
                $array[] = mb_substr($str, 0, 1, "utf8");
                $str = mb_substr($str, 1, $strlen, "utf8");
                $strlen = mb_strlen($str);
            }
            $end = $len + $start;
            $str ='';
            for ($i = $start; $i < $end; $i++) {
                if(isset($array[$i])) $str.=$array[$i];
            }
            return count($array) > $len ? ($suffix == 1 ? $str . "&hellip;" : $str) : $str;
        }

        /**
         * @param $str
         * @param $start
         * @param $len
         * @param $trimmarker
         * @return string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: eacoo_strimwidth
         * @describe:摘要截断
         */
        function lucky_strimwidth($str ,$start , $len ,$trimmarker ){
            $output = preg_replace('/^(?:[x00-x7F]|[xC0-xFF][x80-xBF]+){0,'.$start.'}((?:[x00-x7F]|[xC0-xFF][x80-xBF]+){0,'.$len.'}).*/s','1',$str);
            return $output.$trimmarker;
        }


        /**
         * @param int $len
         * @param string $type   0 字母 1 数字 其它 混合
         * @param string $addChars
         * @return bool|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: rand_string
         * @describe:产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
         */
        public static function rand_string($len=6,$type='',$addChars='') {
            $str ='';
            switch($type) {
                case 0:
                    $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
                    break;
                case 1:
                    $chars= str_repeat('0123456789',3);
                    break;
                case 2:
                    $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
                    break;
                case 3:
                    $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
                    break;
                case 4:
                    $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
                    break;
                default :
                    // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
                    $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
                    break;
            }
            if($len>10 ) {//位数过长重复字符串一定次数
                $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
            }
            if($type!=4) {
                $chars   =   str_shuffle($chars);
                $str     =   substr($chars,0,$len);
            } else{
                // 中文随机字
                for($i=0;$i<$len;$i++){
                    $str.= msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1);
                }
            }
            return $str;
        }

        /**
         * @param $string
         * @return mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: safe_replace
         * @describe:安全过滤
         */
        public static function safe_replace($string) {
            $string = str_replace('%20','',$string);
            $string = str_replace('%27','',$string);
            $string = str_replace('%2527','',$string);
            $string = str_replace('*','',$string);
            $string = str_replace('"','',$string);
            $string = str_replace("'",'',$string);
            $string = str_replace(';','',$string);
            $string = str_replace('<','&lt;',$string);
            $string = str_replace('>','&gt;',$string);
            $string = str_replace("{",'',$string);
            $string = str_replace('}','',$string);
            $string = str_replace('\\','',$string);
            return $string;
        }

        /**
         * @param $data
         * @return string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: data_auth_sign
         * @describe:数据签名认证
         */
       public static function data_auth_sign($data)
        {
            //数据类型检测
            if (!is_array($data)) {
                $data = (array)$data;
            }
            ksort($data); //排序
            $code = http_build_query($data); //url编码并生成query字符串
            $sign = sha1($code); //生成签名
            return $sign;
        }



        /**
         * @param $number
         * @param int $length
         * @param int $mode
         * @return 0|array|bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: build_count_rand
         * @describe:随机生成一组字符串
         */
        public static function build_count_rand ($number,$length=4,$mode=1) {
            if($mode==1 && $length<strlen($number) ) {
                //不足以生成一定数量的不重复数字
                return false;
            }
            $rand   =  array();
            for($i=0; $i<$number; $i++) {
                $rand[] =   rand_string($length,$mode);
            }
            $unqiue = array_unique($rand);
            if(count($unqiue)==count($rand)) {
                return $rand;
            }
            $count   = count($rand)-count($unqiue);
            for($i=0; $i<$count*3; $i++) {
                $rand[] =   rand_string($length,$mode);
            }
            $rand = array_slice(array_unique ($rand),0,$number);
            return $rand;
        }


        /**
         * @param string $content
         * @param string $begin  开始字符串
         * @param string $end   结尾字符串
         * @return bool|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: get_sub_content
         * @describe:截取内容
         */
       public static function get_sub_content($content='',$begin='',$end='')
        {
            if($begin)$content = strstr($content,$begin);
            if($end)$content = substr($content,0,strpos($content,$end));
            return $content;
        }

        /**
         * @param $string
         * @return false|int
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: is_utf8
         * @describe:检查字符串是否是UTF8编码
         */
       public static function is_utf8($string) {
            return preg_match('%^(?:
         [\x09\x0A\x0D\x20-\x7E]            # ASCII
       | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
       |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
       | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
       |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
       |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
       | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
       |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
    )*$%xs', $string);
        }



        /**
         * @param $number
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: isIdCard
         * @describe:检查是否是身份证号
         */
        public static function isIdCard($number) { // 检查是否是身份证号

            if (strlen($number) == 18) {
                return self::check18IDCard($number);
            } elseif ((strlen($number) == 15)) {
                $IDCard = self::convertIDCard15to18($number);
                return self::check18IDCard($IDCard);
            } else {
                return false;
            }
        }


        /**
         * @param $IDCardBody
         * @return bool|mixed
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: calcIDCardCode
         * @describe:计算身份证的最后一位验证码,根据国家标准GB 11643-1999
         */
       public static function calcIDCardCode($IDCardBody) {
            if (strlen($IDCardBody) != 17) {
                return false;
            }
            //加权因子
            $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            //校验码对应值
            $code = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            $checksum = 0;
            for ($i = 0; $i < strlen($IDCardBody); $i++) {
                $checksum += substr($IDCardBody, $i, 1) * $factor[$i];
            }

            return $code[$checksum % 11];
        }



        /**
         * @param $IDCard
         * @return bool|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: convertIDCard15to18
         * @describe:将15位身份证升级到18位
         */
        public static function convertIDCard15to18($IDCard) {
            if (strlen($IDCard) != 15) {
                return false;
            } else {
                // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
                if (array_search(substr($IDCard, 12, 3), array('996', '997', '998', '999')) !== false) {
                    $IDCard = substr($IDCard, 0, 6) . '18' . substr($IDCard, 6, 9);
                } else {
                    $IDCard = substr($IDCard, 0, 6) . '19' . substr($IDCard, 6, 9);
                }
            }
            $IDCard = $IDCard . self::calcIDCardCode($IDCard);
            return $IDCard;
        }



        /**
         * @param $IDCard
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: check18IDCard
         * @describe:18位身份证校验码有效性检查
         */
       public static function check18IDCard($IDCard) {
            if (strlen($IDCard) != 18) {
                return false;
            }

            $IDCardBody = substr($IDCard, 0, 17); //身份证主体
            $IDCardCode = strtoupper(substr($IDCard, 17, 1)); //身份证最后一位的验证码

            if (self::calcIDCardCode($IDCardBody) != $IDCardCode) {
                return false;
            } else {
                return true;
            }
        }




        /***********************************金额相关 money****************************************/

        /**
         * @param $number
         * @return string
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: format_money
         * @describe:金额格式化
         */
       public static function format_money($number)
        {
            return number_format($number,2,'.','');
        }

        /**
         * @param $accountPrice
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: check_money_format
         * @describe:校验金额格式
         */
       public static function check_money_format($accountPrice)
        {
            if (!preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $accountPrice)) return false;
            return true;
        }


    }