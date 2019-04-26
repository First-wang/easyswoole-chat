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

        // TODO 将同步改为异步

        $roomId = $arg['room_id'];

        $redis = PoolManager::getInstance()->getPool(RedisPool::class)->getObj();
        $effectiveFds = $redis->SMEMBERS('fds');

        $roomInfo = $redis->get('room:' . $roomId);
        $roomInfo = json_decode($roomInfo,  true);
        $fds = $roomInfo['fds'];

        $userName = $redis->get('fd:' . $fd = $this->caller()->getClient()->getFd());

        $server = ServerManager::getInstance()->getSwooleServer();
        foreach ($fds as $fd) {
            if (in_array($fd, $effectiveFds)) {

                $param = [
                    'user_name' => $userName,
                    'message' => $arg['message']
                ];

                $server->push($fd, json_encode($param));
            }
        }

        PoolManager::getInstance()->getPool(RedisPool::class)->recycleObj($redis);
    }
}