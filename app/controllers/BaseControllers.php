<?php

namespace controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseControllers
{
    // 模板引擎
    protected $twig;
    protected $data = [];

    public function __construct()
    {
        // 模板加载路径
        $loader = new FilesystemLoader(TEMPDIR . '/app/views');
        $this->twig = new Environment($loader, []);
    }

    protected function display($template)
    {
        $url = getCurUrl();
        $this->assign('uri', $url);
        echo $this->twig->render($template . '.html', $this->data);
    }

    protected function assign($var, $value = null)
    {
        // 如果为数组
        if (is_array($var)) {
            $this->data = array_merge($this->data, $var);
        } else {
            $this->data[$var] = $value;
        }
    }

    /**
     * @param $url
     * @param $mess
     * 成功跳转
     */
    protected function success($url, $mess)
    {
        echo "<script>";
        echo "alert('{$mess}');";

        if (!empty($url)) {
            echo "location.href='{$url}';";
        }

        echo "</script>";
    }

    /**
     * @param $url
     * @param $mess
     * 失败跳转
     */
    protected function error($url, $mess)
    {
        echo "<script>";
        echo "alert('{$mess}');";

        if (!empty($url)) {
            echo "location.href='{$url}';";
        }

        echo "</script>";
    }
}