<?php
namespace models;

use Medoo\Medoo;

class BaseDao extends Medoo {
    function __construct()
    {
        // 初始化数据库
        $options = [
            // 数据库类型
            'database_type' => 'mysql',
            // 数据库名
            'database_name' => DBNAME,
            // 主机
            'server' => HOST,
            // 端口号
            'port' => PORT,
            // 数据库账号
            'username' => USER,
            // 数据库密码
            'password' => PASS,
            // 前缀
            'prefix' => TABPREFIX
        ];
        parent::__construct($options);
    }
}

