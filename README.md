# easyswoole-chat

基于easyswoole的简单聊天室

## 快速开始

#### 克隆代码

```bash
https://github.com/First-wang/easyswoole-chat.git
```

#### docker搭建项目环境

```bash
docker-compose up
```

```bash
进入容器:
docker exec -it php-swoole /bin/bash

使用composer中文镜像
composer config -g repo.packagist composer https://packagist.laravel-china.org
进入容器:
安装composer包
composer install
```

#### 项目启动

```bash
环境搭建完毕后,执行
php easyswoole start

成功后,控制台输出文本信息,表示服务开启成功
  ______                          _____                              _
 |  ____|                        / ____|                            | |
 | |__      __ _   ___   _   _  | (___   __      __   ___     ___   | |   ___
 |  __|    / _` | / __| | | | |  \___ \  \ \ /\ / /  / _ \   / _ \  | |  / _ \
 | |____  | (_| | \__ \ | |_| |  ____) |  \ V  V /  | (_) | | (_) | | | |  __/
 |______|  \__,_| |___/  \__, | |_____/    \_/\_/    \___/   \___/  |_|  \___|
                          __/ |
                         |___/
main server                   SWOOLE_WEB_SOCKET
listen address                0.0.0.0
listen port                   9501
sub server1                   CONSOLE => SWOOLE_TCP@127.0.0.1:9500
ip@eth0                       172.25.0.3
worker_num                    2
max_request                   300
task_worker_num               2
task_max_request              300
document_root                 /application/Public
enable_static_handler         1
pid_file                      /application/Temp/pid.pid
log_file                      /application/Log/swoole.log
run at user                   root
daemonize                     false
swoole version                4.3.0
php version                   7.1.28
easy swoole                   3.1.20-dev
develop/produce               develop
temp dir                      /application/Temp
log dir                       /application/Log
```

#### 浏览器访问

```bash
http://127.0.0.1:8080/
```

#### 效果展示

![](http://wdy-blog-file.test.upcdn.net/images/chat_xg1.png)

![](http://wdy-blog-file.test.upcdn.net/images/chat_xg2.png)
