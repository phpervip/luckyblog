<?php


    use service\JsonService;
    use service\TimeService;
    use service\TreeService;
    use service\UtilService;
    use think\Exception;
    use think\Image;


    /**
 * @param $str
 * @return mixed
 * 密码隐藏
 */
function hide_pwd($str){
    $resstr = substr_replace($str,'****',3,10);
    return $resstr;
}


    /**
     * @param $pass
     * @return mixed
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: Lucky_Pass
     * @describe:加密密码
     */
function Lucky_Pass($pass){
    return UtilService::think_encrypt($pass);
}



    /**
     * 格式化字节大小
     * @param  number $size      字节数
     * @param  StringService $delimiter 数字和单位分隔符
     * @return StringService            格式化后的带单位的大小
     */
    function format_bytes($size, $delimiter = '') {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for($i = 0; $size >= 1024 && $i < 5; $i++)
            $size /= 1024;
        return round($size, 2).$delimiter.$units[$i];
    }


    /**
     * @param $sTime
     * @return false|\service\StringService
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: friend_time
     * @describe:时间友好
     */
    function friend_time($sTime){
        return TimeService::friendlyDate($sTime);
    }




    /**
     * 缩略图生成
     * @param sting $src
     * @param intval $width
     * @param intval $height
     * @param boolean $replace
     * @param intval $type
    1、标识缩略图等比例缩放类型
    2、标识缩略图缩放后填充类型
    3、标识缩略图居中裁剪类型
    4、标识缩略图左上角裁剪类型
    5、标识缩略图右下角裁剪类型
    6、标识缩略图固定尺寸缩放类型
     * @return string
     */
    function thumb($src = '', $width = 500, $height = 500, $type = 1, $replace = false) {
        $src = './'.$src;
        if(is_file($src) && file_exists($src)) {
            $ext = pathinfo($src, PATHINFO_EXTENSION);
            $name = basename($src, '.'.$ext);
            $dir = dirname($src);
            if(in_array($ext, array('gif','jpg','jpeg','bmp','png'))) {
                $name = $name.'_thumb_'.$width.'_'.$height.'.'.$ext;
                $file = $dir.'/'.$name;
                if(!file_exists($file) || $replace == TRUE) {
                    $image = Image::open($src);
                    $image->thumb($width, $height, $type);
                    $image->save($file);
                }
                $file=str_replace("\\","/",$file);
                $file = '/'.trim($file,'./');
                return $file;
            }
        }
        $src=str_replace("\\","/",$src);
        $src = '/'.trim($src,'./');
        return $src;
    }


    /**
     * @param $address
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws phpmailerException
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: SendMail
     * @describe:发送邮件
     */
    function SendMail($address,$content="")
    {
        vendor('phpmailer.PHPMailerAutoload');
        $mail = new \PHPMailer();
        // 设置PHPMailer使用SMTP服务器发送Email
        $mail->IsSMTP();
        // 设置邮件的字符编码，若不指定，则为'UTF-8'
        $mail->CharSet='UTF-8';
        // 添加收件人地址，可以多次使用来添加多个收件人
        $mail->AddAddress($address);
        $data=db("setting")->where("key","email")->find();
        $data=json_decode($data["value"]);
        $title = $data->title;
        if(empty($content)){
            $message = $data->content;
        }else{
            $message=$content;
        }
        $from = $data->from_email;
        $fromname = $data->from_name;
        $smtp = $data->smtp;
        $username = $data->username;
        $password = $data->password;
        // 设置邮件正文
        $mail->Body=$message;
        // 设置邮件头的From字段。
        $mail->From=$from;
        // 设置发件人名字
        $mail->FromName=$fromname;
        // 设置邮件标题
        $mail->Subject=$title;
        // 设置SMTP服务器。
        $mail->Host=$smtp;
        // 设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';
        // 设置ssl连接smtp服务器的远程服务器端口号
        $mail->Port = 465;
        // 设置为"需要验证" ThinkPHP 的config方法读取配置文件
        $mail->SMTPAuth=true;
        //设置html发送格式
        $mail->isHTML(true);
        // 设置用户名和密码。
        $mail->Username=$username;
        $mail->Password=$password;
        // 发送邮件。
        return($mail->Send());
    }





    /**
     * @param $str
     * @return mixed|string
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: sensitive_words_filter
     * @describe:敏感词过滤
     */
    function sensitive_words_filter($str)
    {
        if (!$str) return '';
        $file = ROOT_PATH.VIEW_PATH.'/static/plug/censorwords/CensorWords';
        $words = file($file);
        foreach($words as $word)
        {
            $word = str_replace(array("\r\n","\r","\n","/","<",">","="," "), '', $word);
            if (!$word) continue;

            $ret = preg_match("/$word/", $str, $match);
            if ($ret) {
                return $match[0];
            }
        }
        return '';
    }


    /**
     * @param $string
     * @return string
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: GetSensitive
     * @describe:敏感词过滤
     */
    function GetSensitive($string){
        $count = 0; //违规词的个数
        $sensitiveWord = ''; //违规词
        $stringAfter = $string; //替换后的内容
        $list=[
            '发抡','发抡功','发伦功','艹','罚仑','伐囵','法 轮 功','法*功','法轮大法','法轮佛法','法轮功','五不争鸣论坛','包二奶','爆草','骚女','骚比','色情网站',
            '舔阴','性交','淫荡','阴精','阴b','抓胸','社会主义灭亡','贱人','装b','大sb','卧艹','卧槽','cao你','干你娘','操你全家','操你大爷',
            '爆乳','暴淫','逼奸','操逼','操黑','插比','插阴','潮吹','潮喷','成人电影','成人论坛','成人色情','成人网站','成人文学','成人小说',
            '骚穴','色诱','色欲','吸精','性欲','淫电影','淫色','自慰','作爱','脱裤门','傻b','欠干','婊子养的','我操','日你妈','干你妈','狗操','妈逼','你麻痹','妈了个逼',
            '吃精','春药','肛交','鸡巴','鸡吧','口活','口射','口交','口淫','狂插','浪逼','轮奸','美少妇','嫩穴','内射','女优','强奸处女','乳房',
            '色逼','射爽','手淫','要射了','阳具','淫妇','fuck','xing伴侣','你他妈','真他妈','草你丫','擦你妈','操他妈','狗杂种','狗日的','操你祖宗','麻痹的'
        ];
        $pattern = "/".implode( "|",$list). "/i"; //定义正则表达式
        if(preg_match_all($pattern, $string, $matches)){ //匹配到了结果
            $patternList = $matches[ 0]; //匹配到的数组
            $count = count($patternList);
            $sensitiveWord = implode( ',', $patternList); //敏感词数组转字符串
            $replaceArray = array_combine($patternList,array_fill( 0,count($patternList), '*')); //把匹配到的数组进行合并，替换使用
            $stringAfter = strtr($string, $replaceArray); //结果替换
        }
        $log =$string;
        if($count== 0){
        } else{
          /*  $log .= "匹配到 [ {$count} ]个敏感词：[ {$sensitiveWord} ]<br/>".
                "替换后为：[ {$stringAfter} ]";*/
          $log=$stringAfter;
        }
        return $log;
    }



    /**
     * @param $string
     * @param $start
     * @param $end
     * @return string
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: strReplace
     * @describe:替换一部分字符
     */
    function strReplace($string,$start,$end)
    {
        $strlen = mb_strlen($string, 'UTF-8');//获取字符串长度
        $firstStr = mb_substr($string, 0, $start,'UTF-8');//获取第一位
        $lastStr = mb_substr($string, -1, $end, 'UTF-8');//获取最后一位
        return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($string, 'utf-8') -1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
    }
