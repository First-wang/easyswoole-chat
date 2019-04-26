<?php
/**
 * Created by PhpStorm.
 * User: Tioncico
 * Date: 2019/3/18 0018
 * Time: 9:40
 */

namespace App\HttpController;


use App\Utility\Pool\RedisObject;
use App\Utility\Pool\RedisPool;
use App\Utility\TrackerManager;
use EasySwoole\Component\Pool\PoolManager;
use EasySwoole\EasySwoole\Logger;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Trace\Bean\Tracker;
use EasySwoole\Utility\SnowFlake;

class Index extends ViewController
{
    function index()
    {
//        $this->response()->write('666');

        // Blade View
//        $this->render('aaa');     # 对应模板: Views/aaa.blade.php

        $this->render('index');
    }

    /**
     * 输入昵称，开始骚聊
     */
    public function start()
    {
        $params = $this->request()->getRequestParam();
        $user_name = $params['user_name'] ?? '游客' . time();
        $current_room_id = $params['room_id'] ?? '';

        // redis操作==============================================
        $redis = PoolManager::getInstance()->getPool(RedisPool::class)->getObj();

        $room_keys = $redis->KEYS('room:*');

        $rooms = [];

        if (!empty($room_keys)) {
            foreach ($room_keys as $room_key) {
                $room_name = $redis->get($room_key);
                $rooms[substr($room_key, -13, 13)] = $room_name;
            }
        }

        // 默认进入第一个房间
        if (!$current_room_id && !empty($rooms)) {
            $current_room_id = substr($room_keys[0], -13, 13);
        }

        PoolManager::getInstance()->getPool(RedisPool::class)->recycleObj($redis);
        // redis操作结束===========================================

        $this->render('chat', compact('user_name', 'rooms', 'current_room_id'));
    }

    /**
     * 创建房间
     */
    public function createRoom()
    {
        $params = $this->request()->getRequestParam();

        $name = $params['room_name'];
        $user_name = $params['user_name'];

        $redis = PoolManager::getInstance()->getPool(RedisPool::class)->getObj();

        $data = [
            'name' => $name,
            'fds' => []
        ];

        try {
            $key = time() . random_int(100, 999);
            $redis->set('room:' . $key, json_encode($data));
        } catch (\Exception $e) {
            var_dump($e);
        }

        PoolManager::getInstance()->getPool(RedisPool::class)->recycleObj($redis);

        $this->response()->redirect("/start?user_name={$user_name}&room_id={$key}");
    }

    /**
     * 进入房间
     */
    public function intoRoom()
    {
        $params = $this->request()->getRequestParam();

        $roomId = $params['room_id'];


    }

}