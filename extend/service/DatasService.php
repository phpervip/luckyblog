<?php
    /**
     * Created by PhpStorm.
     * 版权所有: 2019~2022 [ hhygyl ]
     * Date: 2019/7/15-10:36
     * Link: http://luckyadmin.luckyhhy.cn
     * FileName: DatasService.php
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


    class DatasService
    {

        private $arr;
        private $page;
        private $GetJoke; //新实时段子

        public function __construct()
        {
            $this->arr=['code'=>0,'msg'=>'数据请求失败'];
            $this->GetJoke="https://api.apiopen.top/getJoke?page=$this->page&count=30&type=video";


        }


        /**
         * @param int $page
         * @return array
         * 获取段子
         */
        public function Getjoke($page=1){
            $this->page=$page;
            $joke=json_decode(@file_get_contents($this->GetJoke));
            if (!isset($joke->code)){
                return $this->arr;
            }
            if ($joke->code !=200){
                return $this->arr;
            }
            if (empty($joke->result)){
                return $this->arr;
            }

            return $this->DataArray($joke->result);
        }


        /**
         * @param int $page
         * @param int $type
         * @return array
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: getQuPic
         * @describe:获取趣图
         */
        public function getQuPic($page=1,$type=1){
            if ($type==1){
                $joke=json_decode(@file_get_contents("https://www.apiopen.top/satinGodApi?type=3&page=$page")); //pic
            }else{
                $joke=json_decode(@file_get_contents("https://www.apiopen.top/satinGodApi?type=4&page=$page")); //gif
            }
            //dump($joke);
            if (!isset($joke->code)){
                return $this->arr;
            }
            if ($joke->code !=200){
                return $this->arr;
            }
            if (empty($joke->data)){
                return $this->arr;
            }

            return $this->DataArray($joke->data);
        }


        /**
         * @param int $page
         * @return array
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: getwenzi
         * @describe:获取段子文字
         */
        public function getwenzi($page=1){

            $joke=json_decode(@file_get_contents("https://www.apiopen.top/satinGodApi?type=2&page=$page")); //pic
            //dump($joke);
            if (!isset($joke->code)){
                return $this->arr;
            }
            if ($joke->code !=200){
                return $this->arr;
            }
            if (empty($joke->data)){
                return $this->arr;
            }
            return $this->DataArray($joke->data);
        }



        /**
         * @param string $type
         * @return array
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: news
         * @describe:新闻头条
         */
        public function getnews($type=''){
            /**类型,,top(头条，默认),shehui(社会),guonei(国内),shishang(时尚)
             * guoji(国际),yule(娱乐),tiyu(体育)junshi(军事),keji(科技),caijing(财经),
             **/
            if(empty($type)) $type='top';
            $url="http://v.juhe.cn/toutiao/index";
            $params = array(
                "key" => '17d901a5156a56a365e8babb91501a8d',//您申请的appKey
                "type" => $type,//
            );
            $paramstring = http_build_query($params);
            $content = self::juhecurl($url,$paramstring);
            $result = json_decode($content,true);
            if(empty($result['result']['data'])){
                return $this->arr;
            }else{
                return $result['result']['data'];
            }

        }


        /**
         * 请求接口返回内容
         * @param  string $url [请求的URL地址]
         * @param  string $params [请求的参数]
         * @param  int $ipost [是否采用POST形式]
         * @return  string
         */
        private static function juhecurl($url,$params=false,$ispost=0){
            $httpInfo = array();
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
            curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
            curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
            curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            if( $ispost )
            {
                curl_setopt( $ch , CURLOPT_POST , true );
                curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
                curl_setopt( $ch , CURLOPT_URL , $url );
            }
            else
            {
                if($params){
                    curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
                }else{
                    curl_setopt( $ch , CURLOPT_URL , $url);
                }
            }
            $response = curl_exec( $ch );
            if ($response === FALSE) {
                //echo "cURL Error: " . curl_error($ch);
                return false;
            }
            $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
            $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
            curl_close( $ch );
            return $response;
        }



        /**
         * @param $arr
         * @return array
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: DataArray
         * @describe:数据转换
         */
        protected function DataArray($arr){
            $data=[];
            foreach($arr as $k=>$v){
                $data[$k]=$this->object_array($v);
            }
            return $data;
        }

        /**
         * @param $array
         * @return array
         * @author: hhygyl <hhygyl520@qq.com>
         * @name: object_array
         * @describe:php数据对象转数组
         */
        protected  function object_array($array) {
            if(is_object($array)) {
                $array = (array)$array;
            } if(is_array($array)) {
                foreach($array as $key=>$value) {
                    $array[$key] = $this->object_array($value);
                }
            }
            return $array;
        }




    }