<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/8/15
 * Time: 上午10:39
 */
namespace App\HttpController;
use EasySwoole\Http\AbstractInterface\AbstractRouter;
use FastRoute\RouteCollector;
class Router extends AbstractRouter
{
    function initialize(RouteCollector $routeCollector)
    {
//        $this->setGlobalMode(true);
//        $this->setGlobalMode(false);
//        $this->setMethodNotAllowCallBack(function (Request $request,Response $response){
//            $response->write('未找到处理方法');
//        });
//        $this->setRouterNotFoundCallBack(function (Request $request,Response $response){
//            $response->write('未找到路由匹配');
//        });

//        $routeCollector->get('/user','/Test/user');
//        $routeCollector->get('/test','/Index/test');

        $routeCollector->get('/aaa', 'Index/aaa');

    }
}