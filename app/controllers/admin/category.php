<?php

namespace admin;

use lmonkey\CatTree as CT;
use models\BaseDao;

class Category extends Admin
{
    public function __construct()
    {
        // 获取父类的构造方法
        parent::__construct();
        // 实例化数据库对象
        $db = new BaseDao();
        // 获取全部的商品分类, 并能按ord排序
        $data = $db->select('category', ['id', 'catname', 'pid', 'ord']);
        // 引入无限分类插件
        $tree = CT::getlist($data);
        // 分配分类数据
        $this->assign('cats', $tree);
        $this->assign('menumark', 'category');

    }

    /**
     * 商品分类列表页面
     */
    function index()
    {
        // 标题
        $this->assign('title', '商品分类');
        //导入模版
        $this->display('category/index');

    }

    // 添加方法
    function add()
    {
        //如果$_POST['do_submit']存在，说明是添加的动作
        if (isset($_POST['do_submit'])) {
            // 实例化数据库对象
            $db = new BaseDao();
            // 将do_submit从$_POST中删除
            unset($_POST['do_submit']);
            // 执行添加目录并跳转
            if ($db->insert('category', $_POST)) {
                $this->success('/admin/category', '添加成功！');
            } else {
                $this->error('/admin/category/add', '添加失败！');
            }
        }
        // 设置标题
        $this->assign('title', '添加分类');
        // 分配模板
        $this->display('category/add');
    }

    // 编辑方法
    function mod($id)
    {
        // 实例化数据库对象
        $db = new BaseDao();
        // 分配子类目
        $this->assign('childs', $_GET['childs']);
        // 分配ID所属的各个分类目录
        $this->assign($db->get('category', '*', ['id' => $id]));
        // 展示模板
        $this->display('category/mod');
    }

    // 执行更新方法
    function doupdate()
    {
        // 获取ID
        $id = $_POST['id'];
        unset($_POST['id']);
        // 获取子类目
        $_POST['childs'] .= "," . $id;
        // 不能将分类修改到自己或自己的子类中
        if (in_array($_POST['pid'], explode(",", $_POST['childs']))) {
            $this->error('/admin/category', "不能将分类修改到自己或自己的子类中...");
            exit;
        }
        // 实例化数据库对象
        $db = new BaseDao();
        // 将childs从$_POST中删除
        unset($_POST['childs']);
        // 执行数据库更新并跳转
        if ($db->update('category', $_POST, ['id' => $id])) {
            $this->success('/admin/category', '修改成功');
        } else {
            $this->error('/admin/category/mod/' . $id, '修改失败！');
        }
    }

    // 删除方法
    function del($id)
    {
        // 如果子类不为空，则不能删除
        if ($_GET['childs'] != '') {
            $this->error('/admin/category', "不能删除非空分类...");
            exit;
        }
        // 实例化数据库对象
        $db = new BaseDao();
        // 删除并跳转
        if ($db->delete('category', ['id' => $id])) {
            $this->success('/admin/category', '删除成功！');
        } else {
            $this->error('/admin/category', '删除失败！');
        }
    }

}
