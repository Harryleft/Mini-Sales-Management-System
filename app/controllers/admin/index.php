<?php

namespace admin;

use models\BaseDao;


class Index extends Admin
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        $db = new BaseDao();
        $TongJiData = $db->select('transaction', ["[<]product" => ['productMark' => 'productMark']], ['productName', 'saleNum'], ['totalMoney[>]' => 200, "LIMIT" => 5]);
        $this->assign('TongJiData', json_encode($TongJiData));
        // 创建一个空数组存储变量
        $data = [];
        /*
         * 时间计算
         **/

        // 今天
        $today = strtotime(date('Y-m-d'));
        //明天
        $tomorrow = strtotime(date('Y-m-d', strtotime('+1 day')));
        // 昨天
        $yesterday = strtotime(date('Y-m-d', strtotime('-1 day')));
        // 上一月
        $month = strtotime(date('Y-m-d', strtotime('last month')));
        // 今年
        $year = strtotime(date('Y-m-d', strtotime('last year')));
//        dd($today);

        /*
         * 商品的统计
         **/

        // 在架商品
        $data['ownProduct'] = $db->count('product', '*');
        // 已售数量
        $data['saleProduct'] = $db->sum('product', 'saleNum');
        // 缺货的商品
        $data['productEmpty'] = $db->count('product', ['inventoryNum[<]' => 1]);
        // 退货商品
        $data['productReturn'] = $db->count('transcation', 'returnNum');

        /*
         * 交易数据统计
         **/


        // 今日交易数
        $data['transactionToday'] = $db->count('transaction', ['atime[>]' => $today, 'atime[<]' => $tomorrow]);

        // 昨日交易数
        $data['transactionYesterday'] = $db->count('transaction', ['atime[>=]' => $yesterday, 'atime[<]' => $today]);
        // 今日交易额
        $data['moneyToday'] = number_format($db->sum('transaction', 'totalMoney', ['atime[=]' => $today]), 2, '.', '');
        // 昨日交易额
        $data['moneyYesterday'] = number_format((float)$db->sum('transaction', 'totalMoney', ['atime[>=]' => $yesterday, 'atime[<]' => $today]), 2, '.', '');
        // 当月交易额
        $data['moneyMonth'] = number_format((float)$db->sum('transaction', 'totalMoney', ['atime[>=]' => $month]), 2, '.', '');
        // 当年交易额
        $data['moneyYear'] = number_format((float)$db->sum('transaction', 'totalMoney', ['atime[>=]' => $year]), 2, '.', '');
        // 当月交易数
        $data['transactionMonth'] = $db->count('transaction', ['atime[>]' => $month]);
        // 全部交易数
        $data['transactionAll'] = $db->count('transaction');
        // 总交易额
        $data['moneyAll'] = number_format((float)$db->sum('transaction', 'totalMoney', ['status[=]' => 1]), 2, '.', '');
        $data['returnMoney'] = number_format((float)$db->sum('transaction', 'totalMoney', ['status[=]' => 2]), 2, '.', '');


        /**
         * 商行客户统计
         */
        $data['client'] = $db->count('client', '*');


        $this->assign($data);

        $this->assign("title", "首页");
        $this->display("index/index");
    }


}