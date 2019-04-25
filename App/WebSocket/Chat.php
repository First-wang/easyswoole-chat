<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2019-04-24
 * Time: 17:58
 */

namespace App\WebSocket;


use App\Utility\Pool\RedisPool;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\Socket\AbstractInterface\Controller;

class Chat extends Controller
{
    /**
     * 发送消息
     */
    public function sendMsg()
    {
        $arg = $this->caller()->getArgs();

        $redis = PoolManager::getInstance()->getPool(RedisPool::class)->getObj();
        $fds = $redis->SMEMBERS('fds');
        PoolManager::getInstance()->getPool(RedisPool::class)->recycleObj($redis);
        $server = ServerManager::getInstance()->getSwooleServer();
        foreach ($fds as $fd) {
            $server->push($fd, $arg['message']);
        }
    }
}