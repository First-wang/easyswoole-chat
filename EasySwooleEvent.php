<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use App\Utility\Pool\RedisObject;
use App\Utility\Pool\RedisPool;
use App\WebSocket\WebSocketParser;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Socket\Dispatcher;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');

        //注册redis连接池 注册之后会返回conf配置,可继续配置,如果返回null代表注册失败
        $redisConf2 = PoolManager::getInstance()->register(RedisPool::class, Config::getInstance()->getConf('REDIS.POOL_MAX_NUM'));
    }

    public static function mainServerCreate(EventRegister $register)
    {
        $register->add($register::onWorkerStart, function (\swoole_server $server, int $workerId) {
            if ($server->taskworker == false) {
                //每个worker进程都预创建连接
                PoolManager::getInstance()->getPool(RedisPool::class)->preLoad(2);//最小创建数量
            }
        });

        $register->add(EventRegister::onOpen, function (\swoole_websocket_server $server, $request) {
            try {
                RedisPool::invoke(function(RedisObject $redis) use ($request) {

                    $user_name = $request->get['user_name'];

                    $room_id = $request->get['room_id'];

                    $redis->sAdd('fds', $request->fd);

                    $redis->set('fd:' . $request->fd, $user_name);

                    $roomInfo = json_decode($redis->get('room:' . $room_id), true);
                    $roomInfo['fds'][] = $request->fd;

                    $redis->set('room:' . $room_id, json_encode($roomInfo));

                });

            } catch (\Throwable $throwable) {
                var_dump($throwable->getMessage());
            }
        });

        $register->add(EventRegister::onClose, function (\swoole_websocket_server $server, $fd) {
            try {
                RedisPool::invoke(function(RedisObject $redis) use ($fd) {
                    $redis->SREM('fds', $fd);
                });
            } catch (\Throwable $throwable) {
                var_dump($throwable->getMessage());
            }
        });


        /**
         * **************** websocket控制器 **********************
         */
        // 创建一个 Dispatcher 配置
        $conf = new \EasySwoole\Socket\Config();
        // 设置 Dispatcher 为 WebSocket 模式
        $conf->setType(\EasySwoole\Socket\Config::WEB_SOCKET);
        // 设置解析器对象
        $conf->setParser(new WebSocketParser());    // {"class": "Chat", "content": { "message":"abc" }}

        // 创建 Dispatcher 对象 并注入 config 对象
        $dispatch = new Dispatcher($conf);
        // 给server 注册相关事件 在 WebSocket 模式下  on message 事件必须注册 并且交给 Dispatcher 对象处理
        $register->set(EventRegister::onMessage, function (\swoole_websocket_server $server, \swoole_websocket_frame $frame) use ($dispatch) {
            $dispatch->dispatch($server, $frame->data, $frame);
        });
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        //不建议在这拦截请求,可增加一个控制器基类进行拦截
        //如果真要拦截,判断之后return false即可
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        $responseMsg = $response->getBody()->__toString();
        //响应状态码:
        var_dump($response->getStatusCode());
    }
}