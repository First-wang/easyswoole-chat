<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2019-04-25
 * Time: 17:59
 */

namespace App\HttpController;


use duncan3dc\Laravel\BladeInstance;
use EasySwoole\EasySwoole\Config;
use EasySwoole\Http\AbstractInterface\Controller;

abstract class ViewController extends Controller
{
    protected $view;

    /**
     * 初始化模板引擎
     * ViewController constructor.
     */
    function __construct()
    {
        $tempPath   = Config::getInstance()->getConf('TEMP_DIR');    # 临时文件目录
        $this->view = new BladeInstance(EASYSWOOLE_ROOT . '/Views', "{$tempPath}/templates_c");

        parent::__construct();
    }

    /**
     * 输出模板到页面
     * @param string $view
     * @param array  $params
     * @author : evalor <master@evalor.cn>
     */
    function render(string $view, array $params = [])
    {
        $content = $this->view->render($view, $params);
        $this->response()->write($content);
    }

}