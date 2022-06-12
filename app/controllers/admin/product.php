<?php

namespace admin;

use lmonkey\CatTree as CT;
use models\BaseDao;

class Product extends Admin
{
    public function __construct()
    {
        // 获取父类的构造方法
        parent::__construct();
        // 获取数据库操作对象
        $db = new BaseDao();
        //获取全部的商品分类, 并能按ord排序
        $data = $db->select('category', ['id', 'catname', 'pid', 'ord']);
        // 引入无限分类插件
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
        //获取全部的商品, 并能按ord排序
        $data = $db->select('product', '*');
        // 将数据分给模版
        $this->assign('data', $data);
        // 标题
        $this->assign('title', '商品列表');
        //导入模版
        $this->display('product/index');
    }

    // 添加方法
    function add()
    {
        //获取数据库操作对象
        $db = new BaseDao();
        $product = $db->select('addproduct', 'productName');
        $this->assign('product', $product);
        //如果$_POST['do_submit']存在，说明是添加的动作
        if (isset($_POST['do_submit'])) {
            // 将do_submit从$_POST中删除
            unset($_POST['do_submit']);
            // 判断时间状态
            $_POST['atime'] = time();
//            dd($_POST['cid']);
            // 执行添加产品并跳转
            if ($db->insert('product', $_POST)) {
                // 添加成功并跳转
                $this->success('/admin/product', '添加成功！');
            } else {
                // 添加失败并跳转
                $this->error('/admin/product/add', '添加失败！');
            }
        }
        // 设置标题
        $this->assign('title', '添加商品');
        // 分配模板
        $this->display('product/add');
    }

    // 编辑方法
    function mod($productMark)
    {
        // 实例化数据库对象
        $db = new BaseDao();
        $product = $db->select('product', "*");
        $this->assign('product', $product);

        // 获取id所属的元组
        $this->assign($db->get('product', '*', ['productMark' => $productMark]));
        // 设置标题
        $this->assign('title', '修改商品');
        // 编辑视图
        $this->display('product/mod');
    }

    // 执行更新方法
    function doupdate()
    {
        // 获取ID
        $productMark = $_POST['productMark'];
        // 将productMark从$_POST中取消
        unset($_POST['productMark']);
        // 获取数据库操作对象
        $db = new BaseDao();
        // 更新数据库并跳转
        if ($db->update('product', $_POST, ['productMark' => $productMark])) {
            // 跳转并提示修改成功
            $this->success('/admin/product', '修改成功');
        } else {
            // 跳转并提示修改失败
            $this->error('/admin/product/mod/' . $productMark, '修改失败！');
        }
    }

    // 删除方法
    function del($productMark)
    {
        // 获取数据库操作对象
        $db = new BaseDao();
        // 执行删除并跳转
        if ($db->delete('product', ['productMark' => $productMark])) {
            // 跳转并提示修改成功
            $this->success('/admin/product', '删除成功！');
        } else {
            // 跳转并提示删除失败
            $this->error('/admin/product', '删除失败！');
        }
    }


}
