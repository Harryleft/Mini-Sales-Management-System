<?php

namespace admin;

use models\BaseDao;

class Supplier extends Admin
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
        $data = $db->select('supplier', '*');
        // 将数据分给模版
        $this->assign('data', $data);
        // 标题
        $this->assign('title', '供应商管理');
        //导入模版
        $this->display('supplier/index');
    }

    function add()
    {

        //如果$_POST['do_submit']存在，说明是添加的动作,执行添加表单
        if (isset($_POST['do_submit'])) {
            $db = new BaseDao();
            unset($_POST['do_submit']);
            $_POST['supplierMark'] = date('Ymd') . str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);
            if ($db->insert('supplier', $_POST)) {
                $this->success('/admin/supplier', '添加成功！');
            } else {
                $this->error('/admin/supplier/add', '添加失败！');
            }
        }
        // 设置title
        $this->assign('title', '添加供应商');
        // 加载模板
        $this->display('supplier/add');
    }

    // 修改方法
    function mod($supplierMark)
    {
        // 实例化数据库对象
        $db = new BaseDao();
        // 依据ID获取client表中的客户信息
        $this->assign($db->get('supplier', '*', ['supplierMark' => $supplierMark]));
        // 设置title
        $this->assign('title', '修改供应商');
        // 加载模板
        $this->display('supplier/mod');
    }

    // 执行更新方法
    function doupdate()
    {
        // 实例化数据库对象
        $db = new BaseDao();
        $supplierMark = $_POST['supplierMark'];
        unset($_POST['supplierMark']);
        if ($db->update('supplier', $_POST)) {
            // 成功消息
            $this->success('/admin/supplier', '修改成功');
        } else {
            // 失败消息
            $this->error('/admin/supplier/mod/' . $supplierMark, '修改失败！');
        }
    }

    // 删除方法
    function del($supplierMark)
    {
        $db = new BaseDao();
        if ($db->delete('supplier', ['supplierMark' => $supplierMark])) {
            $this->success('/admin/supplier', '删除成功！');
        } else {
            $this->error('/admin/supplier/mod/', '删除失败！');
        }
    }

    function detail($supplierMark)
    {
        // 获取数据库操作对象
        $db = new BaseDao();
        //获取全部的交易信息
        $supplierData = $db->select('supplier', ["[<]addproduct" => ['supplierMark' => 'supplierMark']], '*', ['jid[>]' => 0, 'addproduct.supplierMark' => $supplierMark]);
        $this->assign('supplierData', $supplierData);
        // 客户详细信息视图
        $this->display('supplier/detail');

    }

}
