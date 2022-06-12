<?php

namespace admin;

use models\BaseDao;

class ProductReturn extends Admin
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
        //获取全部的客户
        $data = $db->select('ProductReturn', '*');
        // 将数据分给模版
        $this->assign('data', $data);
        // 标题
        $this->assign('title', '退货管理');
        //导入模版
        $this->display('return/index');
    }

    function add()
    {
        $db = new BaseDao();
        $product = $db->select('product', "*");
        $this->assign('product', $product);
        //如果$_POST['do_submit']存在，说明是添加的动作,执行添加表单
        if (isset($_POST['do_submit'])) {
            unset($_POST['do_submit']);
            $_POST['returnTime'] = strtotime($_POST['returnTime']);
            $_POST['returnMark'] = 'TH' . date('Ymd') . str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);
            if ($db->insert('productReturn', $_POST)) {
                // 更新库存
                $db->update('product', ['inventoryNum[+]' => $_POST['returnNum']], ['name' => $_POST['returnProduct']]);
                // 添加成功
                $this->success('/admin/return', '添加成功！');
            } else {
                // 添加失败
                $this->error('/admin/return/add', '添加失败！');
            }
        }
        // 设置title
        $this->assign('title', '添加管理员');
        // 加载模板
        $this->display('return/add');
    }

    // 修改方法
    function mod($id)
    {
        // 实例化数据库对象
        $db = new BaseDao();
        $product = $db->select('product', "*");
        $this->assign('product', $product);
        // 依据ID获取productReturn表中的客户信息
        $this->assign($db->get('productReturn', '*', ['id' => $id]));
        // 设置title
        $this->assign('title', '修改退货');
        // 加载模板
        $this->display('return/mod');
    }

    // 执行更新方法
    function doupdate()
    {

        if (isset($_POST['do_submit'])) {
            unset($_POST['do_submit']);
            $id = $_POST['id'];
            unset($_POST['id']);
            // 实例化数据库对象
            $db = new BaseDao();
            if ($db->update('productReturn', $_POST)) {
                // 成功消息
                $this->success('/admin/return', '修改成功');
            } else {
                // 失败消息
                $this->error('/admin/return/mod/' . $id, '修改失败！');
            }
        }
    }

    // 删除方法
    function del($id)
    {
        $db = new BaseDao();
        if ($db->delete('productReturn', ['id' => $id])) {

            $this->success('/admin/return', '删除成功！');
        } else {
            $this->error('/admin/return/mod/', '删除失败！');
        }
    }

}
