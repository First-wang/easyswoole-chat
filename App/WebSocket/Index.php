<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2019-04-22
 * Time: 16:49
 */

namespace App\WebSocket;

use App\Utility\Pool\RedisObject;
use App\Utility\Pool\RedisPool;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\EasySwoole\Swoole\Task\TaskManager;
use EasySwoole\Socket\AbstractInterface\Controller;

class Index extends Controller
{
//    function hello()
//    {
//        $this->response()->setMessage('call hello with arg:'. json_encode($this->caller()->getArgs()));
//    }

//    public function who(){
////        $fd = $this->caller()->getClient()->getFd();
////        $this->response()->setMessage('your fd is '. $fd);
//
//        $param = $this->caller()->getArgs();
//
//        var_dump($param);
//
////        $message = $param['message'];   // 发送过来的消息
//
//        $redis = PoolManager::getInstance()->getPool(RedisPool::class)->getObj();
//
//        $fds = $redis->SMEMBERS('fds');
//
////            print_r($fds);
//
//        var_dump('4444444', $fds);
//
//        PoolManager::getInstance()->getPool(RedisPool::class)->recycleObj($redis);
//
//        $server = ServerManager::getInstance()->getSwooleServer();
//        foreach ($fds as $fd) {
//
//            $server->push($fd, $param['message']);
//
////            $this->response()->
//
////            $this->response()->setMessage($fd, $param['message']);
//        }
//    }


//    function delay()
//    {
//        $this->response()->setMessage('this is delay action');
//        $client = $this->caller()->getClient();
//
//        // 异步推送, 这里直接 use fd也是可以的
//        TaskManager::async(function () use ($client){
//            $server = ServerManager::getInstance()->getSwooleServer();
//            $i = 0;
//            while ($i < 5) {
//                sleep(1);
//                $server->push($client->getFd(),'push in http at '. date('H:i:s'));
//                $i++;
//            }
//        });
//    }

}