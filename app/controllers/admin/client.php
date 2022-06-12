<?php

namespace admin;

use models\BaseDao;

class Client extends Admin
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
        $data = $db->select('client', '*');
        // 将数据分给模版
        $this->assign('data', $data);
        // 标题
        $this->assign('title', '客户档案管理');
        //导入模版
        $this->display('Client/index');
    }

    function add()
    {
        //如果$_POST['do_submit']存在，说明是添加的动作,执行添加表单
        if (isset($_POST['do_submit'])) {
            $db = new BaseDao();
            unset($_POST['do_submit']);
            $_POST['cid'] = date('Ymd') . str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);
            $_POST['atime'] = time();
            if ($db->insert('client', $_POST)) {
                $this->success('/admin/client', '添加成功！');
            } else {
                $this->error('/admin/client/add', '添加失败！');
            }
        }
        // 设置title
        $this->assign('title', '添加客户');
        // 加载模板
        $this->display('client/add');
    }

    // 修改方法
    function mod($cid)
    {
        // 实例化数据库对象
        $db = new BaseDao();
        $client = $db->select('client', '*');
        $this->assign('client', $client);
        // 依据ID获取client表中的客户信息
        $this->assign($db->get('client', '*', ['cid' => $cid]));
        // 设置title
        $this->assign('title', '修改客户信息');
        // 加载模板
        $this->display('client/mod');
    }

    // 执行更新方法
    function doupdate()
    {
        // 实例化数据库对象
        $db = new BaseDao();
        $clientMark = $_POST['cid'];
        if ($db->update('client', $_POST)) {
            // 成功消息
            $this->success('/admin/client', '修改成功');
        } else {
            // 失败消息
            $this->error('/admin/client/mod/' . $clientMark, '修改失败！');
        }
    }

    // 删除方法
    function del($cid)
    {

        $db = new BaseDao();
        if ($db->delete('client', ['clientMark' => $cid])) {
            $this->success('/admin/client', '删除成功！');
        } else {
            $this->error('/admin/client/mod/', '删除失败！');
        }
    }

    function detail($cid)
    {
        // 获取数据库操作对象
        $db = new BaseDao();
        //获取全部的客户
        $clientData = $db->select('transaction', ["[<]client" => ['cid' => 'cid']], '*', ['tid[>]' => 0, 'client.cid' => $cid]);

        $this->assign('clientData', $clientData);
        // 客户详细信息视图
        $this->display('client/detail');
    }

}
