<?php

namespace admin;

use controllers\BaseControllers;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class Admin extends BaseControllers
{

    public function __construct()
    {

        $loader = new FilesystemLoader(TEMPDIR . '/app/views/admin');
        $this->twig = new Environment($loader, [
            //  'cache' => '/path/to/compilation_cache',
        ]);

        $this->assign('session', $_SESSION);

        if (!qx_login('admin')) {
            $this->error('/admin/login', '你还没有登录，请先登录...');
        }

    }


    // 模板资源
    protected function display($template)
    {
        $url = getCurUrl();

        $this->assign('url', $url . '/app/views/admin/resource');   //自己模板下的CSS、JS、images
        $this->assign('public', $url . '/app/views/public');   //所有模板公共的前端CSS、JS、images
        $this->assign('res', $url . '/uploads');   //文件上传资源
        echo $this->twig->render($template . '.html', $this->data);

    }
}




