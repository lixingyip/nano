<?php

declare(strict_types=1);

return [
    'default' => [
        'handler' => [
            'class' => \App\Lib\Log\ApiFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/nano.log',
                'maxFiles' => 60,
                'level' => Monolog\Logger::INFO,
            ],
        ],
        'formatter' => [
            'class' => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format' => "\n[%datetime%] [%level_name%]%message%",
                'dateFormat' => 'Y-m-d H:i:s.u',
                'allowInlineLineBreaks' => true,
            ],
        ],
    ],
];
