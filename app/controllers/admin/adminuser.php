<?php

namespace admin;

use models\BaseDao;

class AdminUser extends Admin
{
    public function __construct()
    {
        // 获取父类的构造方法
        parent::__construct();
        $this->assign('menumark', 'salekeeper');
    }

    /**
     * 管理员列表页面
     */
    // 管理员列表首页
    function index()
    {
        // 获取数据库操作对象
        $db = new BaseDao();
        // 获取全部的管理员
        $data = $db->select('admin', '*');
        // 将数据库数据分给模版
        $this->assign('data', $data);
        // 标题
        $this->assign('title', '管理员列表');
        // 加载管理员首页视图
        $this->display('adminuser/index');
    }

    // 添加方法
    function add()
    {
        // 如果$_POST['name']存在，并且不为空，说明是添加的动作
        if (!empty($_POST['name'])) {
            // 获取数据库操作对象
            $db = new BaseDao();
            // 最后登录时间与添加时间一致
            $_POST['atime'] = $_POST['ltime'] = time();
            // 双重MD5加密
            $_POST['pw'] = md5(md5('qx_' . $_POST['pw']));
            // 插入管理员数据
            if ($db->insert('admin', $_POST)) {
                // 添加成功并跳转
                $this->success('/admin/adminuser', '添加成功！');
            } else {
                // 添加失败并跳转
                $this->error('/admin/adminuser/add', '添加失败！');
            }
        }
        // 设置标题
        $this->assign('title', '添加管理员');
        // 加载添加视图
        $this->display('adminuser/add');
    }

    // 修改方法
    function mod($id)
    {
        // 获取数据库操作对象
        $db = new BaseDao();
        // 获取id所属的元组
        $this->assign($db->get('admin', '*', ['id' => $id]));
        // 设置标题
        $this->assign('title', '修改管理员');
        // 修改视图
        $this->display('adminuser/mod');
    }

    // 执行更新方法
    function doupdate()
    {
        // 获取ID
        $id = $_POST['id'];
        // 将ID从$_POST中取消
        unset($_POST['id']);
        // 如果密码为空，则不改变密码，反之修改密码
        if (!empty($_POST['pw'])) {
            $_POST['pw'] = md5(md5('qx_' . $_POST['pw']));
        } else {
            // 将pw从$_POST中取消
            unset($_POST['pw']);
        }

        // 获取数据库操作对象
        $db = new BaseDao();
        // 更新数据库并跳转
        if ($db->update('admin', $_POST, ['id' => $id])) {
            // 跳转并提示修改成功
            $this->success('/admin/adminuser', '修改成功');
        } else {
            // 跳转并提示修改失败
            $this->error('/admin/adminuser/mod/' . $id, '修改失败！');
        }
    }

    // 删除方法
    function del($id)
    {
        // 获取数据库操作对象
        $db = new BaseDao();

        // 超级管理员为admin，不可删除
        if ($_POST['name'] == 'admin') {
            // 跳转并提示
            $this->error('/admin/adminuser', '抱歉，超级管理员是不可以删除的...');
            // 直接退出
            return false;
//            exit;
        } elseif ($db->delete('admin', ['id' => $id])) {
            // 跳转并提示删除成功
            $this->success('/admin/adminuser', '删除成功！');
        } else {
            // 跳转并提示删除失败
            $this->error('/admin/adminuser', '删除失败！');
        }
    }
}
