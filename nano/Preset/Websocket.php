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
//    'servers' => [
//        [
//            'name' => 'ws',
//            'type' => Server::SERVER_WEBSOCKET,
//            'host' => '0.0.0.0',
//            'port' => 9502,
//            'sock_type' => SWOOLE_SOCK_TCP,
//            'callbacks' => [
//                SwooleEvent::ON_HAND_SHAKE => [Hyperf\WebSocketServer\Server::class, 'onHandShake'],
//                SwooleEvent::ON_MESSAGE => [Hyperf\WebSocketServer\Server::class, 'onMessage'],
//                SwooleEvent::ON_CLOSE => [Hyperf\WebSocketServer\Server::class, 'onClose'],
//            ],
//        ],
//    ],
];
