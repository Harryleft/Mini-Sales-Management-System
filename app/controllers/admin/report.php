<?php

namespace admin;

use models\BaseDao;

class Report extends Admin
{
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 客户列表页面
     */
    function index()
    {
        //获取数据库操作对象
        $db = new BaseDao();
        $TakeData = $db->select('transaction', ['atime', 'totalMoney']);
        $TotalOutData = $db->select('addProduct', ['supplierTime', 'totalMoney']);

        // 将数据分给模版
        $this->assign('TakeData', $TakeData);
        $this->assign('TotalOutData', $TotalOutData);

        // 标题
        $this->assign('title', '收支表');

        //导入模版
        $this->display('report/index');
    }
}
