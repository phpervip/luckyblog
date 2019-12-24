<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;


return [
    '__pattern__' => [
        'name' => '\w+',
    ],

    //文章模型
    '[article-i]'    => [
        '[:navigate_id]'   => ['index/article/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[article-l]'    => [
        '[:navigate_id]'   => ['index/article/lists', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[article]'          => [
        '[:navigate_id]/[:id]'            => ['index/article/show', ['method' => 'get'], ['id' => '\d+','navigate_id' => '\d+']],
    ],

    //新闻模型
    '[n-i]'    => [
        '[:navigate_id]'   => ['index/news/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[n-ls]'    => [
        '[:navigate_id]'   => ['index/news/lists', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[ns]'          => [
        '[:id]'            => ['index/news/show', ['method' => 'get'], ['id' => '\d+']],
    ],

    //名言记事
    '[y-i]'    => [
        '[:navigate_id]'   => ['index/yuju/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[y-l]'    => [
        '[:navigate_id]'   => ['index/yuju/lists', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[y]'          => [
        '[:id]'            => ['index/yuju/show', ['method' => 'get'], ['id' => '\d+']],
    ],

    //下载模型
    '[down-i]'    => [
        '[:navigate_id]'   => ['index/download/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[down-l]'    => [
        '[:navigate_id]'   => ['index/download/lists', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[down]'          => [
        '[:id]/[:pwd]'    => ['index/download/show', [], ['id' => '\d+','pwd' => '\w+']],
    ],


    '[page]'    => [
        '[:navigate_id]'   => ['index/page/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[feedback]'    => [
        '[:navigate_id]'   => ['index/feedback/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],

    '[link]'    => [
        '[:navigate_id]'   => ['index/link/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],


    //图片模型
    '[a-i]'    => [
        '[:navigate_id]'   => ['index/album/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[a-l]'    => [
        '[:navigate_id]'   => ['index/album/lists', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[album]'          => [
        '[:id]/[:pwd]'            => ['index/album/show', [], ['id' => '\d+','pwd' => '\w+']],
    ],

    //段子模型
    '[d-i]'    => [
        '[:navigate_id]'   => ['index/duanjie/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[d-l]'    => [
        '[:navigate_id]'   => ['index/duanjie/lists', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[duan]'          => [
        '[:id]/[:pwd]'            => ['index/duanjie/show', [], ['id' => '\d+','pwd' => '\w+']],
    ],

    //趣图模型
    '[pic-index]'    => [
        '[:navigate_id]'   => ['index/jokeimg/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[pic-lists]'    => [
        '[:navigate_id]'   => ['index/jokeimg/lists', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[pic]'          => [
        '[:id]/[:pwd]'            => ['index/jokeimg/show', [], ['id' => '\d+','pwd' => '\w+']],
    ],

    //视频模型
    '[video-index]'    => [
        '[:category]'   => ['index/video/index', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[video-lists]'    => [
        '[:category]'   => ['index/video/lists', ['method' => 'get'], ['navigate_id' => '\d+']],
    ],
    '[video]'          => [
        '[:id]/[:pwd]'            => ['index/video/show', [], ['id' => '\d+','pwd' => '\w+']],
    ],


    //标签
    '[tags]'          => [
        '[:tag]'  => ['index/index/tags_search', ['method' => 'get'],['tag' => '\w+']],
    ],

    //搜索
    '[search]'          => [
        '[:keywords]'  => ['index/index/search', [], ['keywords' => '\w+']],
    ],







];
