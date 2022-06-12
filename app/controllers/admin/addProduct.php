<?php

namespace admin;

use lmonkey\CatTree as CT;
use models\BaseDao;

class AddProduct extends Admin
{
    public function __construct()
    {
        // 获取父类的构造方法
        parent::__construct();
        // 获取数据库操作对象
        $db = new BaseDao();
        //获取全部的商品分类, 并能按ord排序
        $data = $db->select('category', ['id', 'catname', 'pid', 'ord']);
        // 引入分类插件
        $tree = CT::getlist($data);
        // 将数据分给模版
        $this->assign('cats', $tree);
    }

    /**
     * 商品列表页面
     */
    function index()
    {
        //获取数据库操作对象
        $db = new BaseDao();
        $product = $db->select('addproduct', ["[<]product" => ['productMark' => 'productMark']], '*', ['atime[>]' => 0]);
        $this->assign('product', $product);
        // 标题
        $this->assign('title', '进货管理');
        //导入模版
        $this->display('addProduct/index');
    }

    // 添加方法
    function add()
    {
        //获取数据库操作对象
        $db = new BaseDao();
        $productData = $db->select('product', '*');
        $supplierData = $db->select('supplier', '*');
        // 将数据分给模版
        $this->assign('productData', $productData);
        $this->assign('supplierData', $supplierData);
        //如果$_POST['do_submit']存在，说明是添加的动作
        if (isset($_POST['do_submit'])) {
            // 将do_submit从$_POST中删除
            unset($_POST['do_submit']);
            $goods = $_POST['goods'];
//            dd($goods);
            foreach ($goods as $v) {
                // 设置时间
                $v['satime'] = time();
                if ($db->insert('addproduct', $v) && $v['status'] != 0) {
                    // 更新商品库存
                    $db->update('product', ['inventoryNum[+]' => $v['productNum']], ['productMark' => $v['productMark']]);
                    // 添加成功并跳转
                    $this->success('/admin/addProduct', '添加成功！');
                } else {
//                    $db->update('product', ['inventoryNum[+]' => $v['productNum']], ['productMark' => $v['productMark']]);
                    $this->error('/admin/addProduct/add', '添加成功');
                }
            }

        }
        // 设置标题
        $this->assign('title', '商品进货');
        // 分配模板
        $this->display('addProduct/add');
    }

    // 编辑方法
    function mod($jid)
    {
        //获取数据库操作对象
        $db = new BaseDao();
        $productData = $db->select('product', '*');
        $supplierData = $db->select('supplier', '*');
        // 将数据分给模版
        $this->assign('productData', $productData);
        $this->assign('supplierData', $supplierData);
        // 获取id所属的元组
        $this->assign($db->get('addproduct', '*', ['jid' => $jid]));
        // 设置标题
        $this->assign('title', '修改进货信息');
        // 编辑视图
        $this->display('addProduct/mod');

    }

    // 执行更新方法
    function doupdate()
    {

        //如果$_POST['do_submit']存在，说明是添加的动作
        // 获取数据库操作对象
        $db = new BaseDao();
        // 获取ID
        $id = $_POST['jid'];
        // 将ID从$_POST中取消
        unset($_POST['jid']);
        // 更新数据库并跳转
        if ($db->update('addProduct', $_POST, ['jid' => $id]) and $_POST['status'] == 1) {
            $db->update('product', ['inventoryNum[+]' => $_POST['productNum']], ['productMark' => $_POST['productMark']]);
            // 跳转并提示修改成功
            $this->success('/admin/addProduct', '修改成功');
        } else {
            // 跳转并提示修改失败
            $this->error('/admin/addProduct/mod/' . $id, '修改失败！');
        }

    }

    // 删除方法
    function del($jid)
    {
        // 获取数据库操作对象
        $db = new BaseDao();
        // 执行删除并跳转
        if ($db->delete('addproduct', ['jid' => $jid])) {
            // 跳转并提示修改成功
            $this->success('/admin/addProduct', '删除成功！');
        } else {
            // 跳转并提示删除失败
            $this->error('/admin/addProduct', '删除失败！');
        }
    }


}
