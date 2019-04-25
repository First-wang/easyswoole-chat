<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-01-01
 * Time: 20:06
 */

return [
    'SERVER_NAME'=>"EasySwoole",
    'MAIN_SERVER'=>[
        'LISTEN_ADDRESS'=>'0.0.0.0',
        'PORT'=>9501,
        'SERVER_TYPE'=>EASYSWOOLE_WEB_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_SOCKET_SERVER
        'SOCK_TYPE'=>SWOOLE_TCP,
        'RUN_MODEL'=>SWOOLE_PROCESS,
        'SETTING'=>[
            'worker_num'=>8,
            'max_request'=>5000,
            'task_worker_num'=>8,
            'task_max_request'=>1000
        ]
    ],
    'TEMP_DIR'=>null,
    'LOG_DIR'=>null
];