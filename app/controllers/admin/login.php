<?php

namespace admin;

use controllers\BaseControllers;
use Gregwar\Captcha\CaptchaBuilder;
use models\BaseDao;

class login extends BaseControllers
{

    function index()
    {
        // 标题
        $this->assign('title', '管理员列表');
        // 分配模板
        $this->display('admin/login/index');

    }

    // 验证码方法
    function vcode()
    {
        // CMD命令行导入验证码依赖包：composer require gregwar/captcha
        $builder = new CaptchaBuilder;
//            $captcha = new CaptchaBuilder('hello');
        $builder->build();
        $_SESSION['code'] = strtoupper($builder->getPhrase());
        header('Content-type: image/jpeg');
        $builder->output();
    }

    // 判断登录
    function dologin()
    {
        // 判断验证码是否为正确
        if (strtoupper($_POST['code']) != $_SESSION['code']) {
            // 返回注册页面并提示
            $this->error('/admin/login', '您输入的信息不正确，请重新输入');
            // 直接退出
            exit;
        }
        // 用户提交的账户名
        $name = $_POST['name'];
        // 将用户输入的密码进行双重MD5加密，转为密文进行匹配
        $pw = md5(md5('qx_' . $_POST['pw']));
        //dd($pw);
        // 实例化数据库类
        $db = new BaseDao();
        // 将用户输入的账户和密码与数据库中的账户和密码进行匹配
        $user = $db->get('admin', ['id', 'name'], ['name' => $name, 'pw' => $pw]);
        // 如果匹配结果为真
        if ($user) {
            // 更新管理员登录时间
            $db->update('admin', ['ltime' => time()], ['id' => $user['id']]);
            // 将用户保存至SESSION
            $_SESSION = $user;
            // 设置管理员的token
            $_SESSION['admin_token'] = md5($user['id'] . $_SERVER['HTTP_HOST']);
            // 提示登录成功
            $this->success('/admin', '登录成功');

        } else {
            // 登录失败
            if ($_POST["name"] == '' || $_POST["pw"] == '') {
                $this->error('/admin/login', '用户名或密码不能为空...');
            } else {
                $this->error('/admin/login', '用户名或密码有误...');
            }

        }
    }

    // 退出管理员账号
    function logout()
    {
        // 把session保存的信息存至数组
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        // 销毁session信息
        session_destroy();
        // 成功退出
        $this->success('/admin/login', '退出登录');
    }

}