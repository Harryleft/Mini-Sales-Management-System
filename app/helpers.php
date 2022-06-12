<?php

// 打印辅助函数
if(!function_exists('dd')) {
    function dd(...$args) {
        http_response_code(500);

        foreach($args as $x){
            var_dump($x);
        }

        die(1);
    }
}

function getCurUrl() {

    $url = 'http://';

    if(isset($_SERVER['SERVER_HTTPS']) && $_SERVER['SERVER_HTTPS'] == 'on') {
        $url = 'https://';
    }

    //判断端口
    if($_SERVER['SERVER_PORT'] != '80') {
        $url .= $_SERVER['SERVER_NAME'] .':'.$_SERVER['SERVER_PORT'];
    }else{
        $url .= $_SERVER['SERVER_NAME'];
    }


    return $url;

}

// 判断登录状态
function qx_login($utype) {
    return  md5($_SESSION['id'].$_SERVER['HTTP_HOST']) == $_SESSION[$utype.'_token'] ? 1 : 0;

}



