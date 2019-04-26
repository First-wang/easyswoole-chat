<?php
/**
 * Created by PhpStorm.
 * User: wdy
 * Date: 2019-04-26
 * Time: 11:46
 */

namespace App\Process;


use App\Utility\Pool\RedisObject;
use App\Utility\Pool\RedisPool;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\Component\Process\AbstractProcess;

class ProcessRedis extends AbstractProcess
{
    public function run($arg)
    {
        $tickId = $this->addTick(10000, function () {
            RedisPool::invoke(function (RedisObject $redis) {
                $effectiveFds = $redis->SMEMBERS('fds');
                $roomKeys = $redis->keys('room:*');
                foreach ($roomKeys as $roomKey) {
                    $roomInfo = $redis->get($roomKey);
                    $roomInfo = json_decode($roomInfo, true);
                    $roomInfo['fds'] = array_intersect($effectiveFds, $roomInfo['fds']);
                    $redis->set($roomKey, json_encode($roomInfo));
                }
            });
        });

        var_dump('$tickId=' . $tickId);
    }

    public function onShutDown()
    {
        // TODO: Implement onShutDown() method.
    }

    public function onReceive(string $str)
    {
        // TODO: Implement onReceive() method.
    }
}