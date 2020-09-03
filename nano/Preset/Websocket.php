<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf Nano.
 *
 * @link     https://www.hyperf.io
 * @document https://nano.hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/nano/blob/master/LICENSE
 */
use Hyperf\Server\Server;
use Hyperf\Server\SwooleEvent;

return [
    'servers' => [
        //        [
        //            'name' => 'http',
        //            'type' => Server::SERVER_HTTP,
        //            'host' => '0.0.0.0',
        //            'port' => 9501,
        //            'sock_type' => SWOOLE_SOCK_TCP,
        //            'callbacks' => [
        //                SwooleEvent::ON_REQUEST => [Hyperf\HttpServer\Server::class, 'onRequest'],
        //            ],
        //        ],
        [
            'name' => 'ws',
            'type' => Server::SERVER_WEBSOCKET,
            'host' => '0.0.0.0',
            'port' => 9502,
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                SwooleEvent::ON_HAND_SHAKE => [Hyperf\WebSocketServer\Server::class, 'onHandShake'],
                SwooleEvent::ON_MESSAGE => [Hyperf\WebSocketServer\Server::class, 'onMessage'],
                SwooleEvent::ON_CLOSE => [Hyperf\WebSocketServer\Server::class, 'onClose'],
            ],
        ],
    ],
    //    'settings' => [
    //        'enable_coroutine' => true,
    //        'worker_num' => 1,
    //        'open_tcp_nodelay' => true,
    //        'max_coroutine' => 100000,
    //        'open_http2_protocol' => true,
    //        'max_request' => 0,
    //        'socket_buffer_size' => 2 * 1024 * 1024,
    //        'buffer_output_size' => 2 * 1024 * 1024,
    //    ],
    //    'callbacks' => [
    //        SwooleEvent::ON_BEFORE_START => [Hyperf\Framework\Bootstrap\ServerStartCallback::class, 'beforeStart'],
    //        SwooleEvent::ON_WORKER_START => [Hyperf\Framework\Bootstrap\WorkerStartCallback::class, 'onWorkerStart'],
    //        SwooleEvent::ON_WORKER_EXIT => [Hyperf\Framework\Bootstrap\WorkerExitCallback::class, 'onWorkerExit'],
    //        SwooleEvent::ON_PIPE_MESSAGE => [Hyperf\Framework\Bootstrap\PipeMessageCallback::class, 'onPipeMessage'],
    //    ],
];