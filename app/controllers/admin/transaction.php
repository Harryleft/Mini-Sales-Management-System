<?php

namespace admin;

use models\BaseDao;

date_default_timezone_set('Asia/Shanghai');

class Transaction extends Admin
{
    public function __construct()
    {
        // 获取父类的构造方法
        parent::__construct();

    }

    /**
     * 商品列表页面
     */

    function index()
    {
        //获取数据库操作对象
        $db = new BaseDao();
        $productData = $db->select('transaction', ["[<]product" => ['productMark' => 'productMark']], '*', ['TransactionNum[>]' => 0]);
        // 将数据分给模版
        $this->assign('product', $productData);
        // 标题
        $this->assign('title', '交易管理');
        //导入模版
        $this->display('transaction/index');
    }

    // 添加方法
    function add()
    {
        $db = new BaseDao();
        $product = $db->select('product', "*");
        $client = $db->select('client', '*');
        $this->assign('client', $client);
        $this->assign('product', $product);
        //如果$_POST['do_submit']存在，说明是添加的动作
        if (isset($_POST['do_submit'])) {
            // 将do_submit从$_POST中删除
            unset($_POST['do_submit']);
            $goods = $_POST['goods'];

            foreach ($goods as $v) {
                // 交易时间
                $v['atime'] = time();
                // 交易编号
                $v['oid'] = date('Ymd') . str_pad(mt_rand(1, 50), 2, '0', STR_PAD_LEFT);
                // 遍历商品的库存数量并与提交的数量进行比较
                if ($v['TransactionNum'] > $db->get('product', 'inventoryNum', ['productMark' => $v['productMark']])) {
                    $this->error('/admin/transaction/add', '所选商品存在库存不足，请联系销售管理员补货');
                } elseif ($v['status'] == 1 && $db->insert('transaction', $v)) {
                    // 更新商品库存
                    $db->update('product', ['inventoryNum[-]' => $v['TransactionNum'], 'saleNum[+]' => $v['TransactionNum']], ['productMark' => $v['productMark']]);
                    // 添加成功并跳转
                    $this->success('/admin/transaction', '添加成功！');
                } elseif ($v['status'] == 0) {
                    $db->insert('transaction', $v);
                    $this->success('/admin/transaction', '添加成功！');
                }
            }
        }
        // 设置标题
        $this->assign('title', '添加商品');
        // 分配模板
        $this->display('transaction/add');
    }

    // 编辑方法
    function mod($id)
    {
        $db = new BaseDao();
        $product = $db->select('product', "*");
        $client = $db->select('client', '*');
        $transaction = $db->select('transaction', '*');
        $this->assign('transaction', $transaction);
        $this->assign('client', $client);
        $this->assign('product', $product);
        // 获取id所属的元组
        $this->assign($db->get('transaction', '*', ['tid' => $id]));
        // 设置标题
        $this->assign('title', '修改交易');
        // 编辑视图
        $this->display('transaction/mod');
    }

    // 执行更新方法
    function doupdate()
    {
        // 获取ID
        $id = $_POST['tid'];
        // 将ID从$_POST中取消
        unset($_POST['tid']);
        // 获取数据库操作对象
        $db = new BaseDao();
        // 更新数据库并跳转
        if ($_POST['TransactionNum'] > $db->get('product', 'inventoryNum', ['productMark' => $_POST['productMark']]) and $_POST['status'] == 1) {
            $this->error('/admin/transaction', '所选商品存在库存不足，请联系销售管理员补货');
        } elseif ($_POST['status'] == 1 && $db->update('transaction', $_POST)) {
            // 更新商品库存
            $db->update('product', ['inventoryNum[-]' => $_POST['TransactionNum'], 'saleNum[+]' => $_POST['TransactionNum']], ['productMark' => $_POST['productMark']]);
            // 添加成功并跳转
            $this->success('/admin/transaction', '添加成功！');
        }
    }

    // 删除方法
    function del($tid)
    {
        // 获取数据库操作对象
        $db = new BaseDao();
        // 执行删除并跳转
        if ($db->delete('transaction', ['tid' => $tid])) {
            // 跳转并提示修改成功
            $this->success('/admin/transaction', '删除成功！');
        } else {
            // 跳转并提示删除失败
            $this->error('/admin/transaction', '删除失败！');
        }
    }

    function return($tid)
    {
        // 获取数据库操作对象
        $db = new BaseDao();
        $transaction = $db->select('transaction', '*', ['tid' => $tid]);
        foreach ($transaction as $value) {
            // 执行退货并跳转
            if (($db->update('transaction', ['status' => '2', 'ltime' => time()], ['tid' => $tid]))) {
                $db->update('product', ['inventoryNum[+]' => $value['TransactionNum'], 'saleNum[-]' => $value['TransactionNum'], 'returnNum[+]' => $value['TransactionNum']], ['productMark' => $value['productMark']]);
                // 跳转并提示修改成功
                $this->success('/admin/transaction', '设置退货成功！');
            } else {
                // 跳转并提示删除失败
                $this->error('/admin/transaction', '设置退货失败！');
            }
        }
    }

    function cancelreturn($tid)
    {
        // 获取数据库操作对象
        $db = new BaseDao();

        $transaction = $db->select('transaction', '*', ['tid' => $tid]);
        foreach ($transaction as $value) {
            // 执行退货并跳转
            if (($db->update('transaction', ['status' => '1', 'ltime' => time()], ['tid' => $tid]))) {

                $db->update('product', ['inventoryNum[-]' => $value['TransactionNum'], 'saleNum[+]' => $value['TransactionNum'], 'returnNum[-]' => $value['TransactionNum']], ['productMark' => $value['productMark']]);

                // 跳转并提示修改成功
                $this->success('/admin/transaction', '取消退货成功！');
            } else {
                // 跳转并提示删除失败
                $this->error('/admin/transaction', '取消退货失败！，请重试');
            }
        }
    }


}
