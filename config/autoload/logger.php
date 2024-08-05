<?php

declare(strict_types=1);
use function Hyperf\Support\env;

$basePath = str_starts_with(BASE_PATH, 'phar://') ? BASE_PATH . '/..' : BASE_PATH;
$basePath = BASE_PATH;

return [
    'default' => [
        'handler' => [
            'class' => Monolog\Handler\StreamHandler::class,
            'constructor' => [
                'stream' => $basePath . '/runtime/logs/hyperf.log',
                'level' => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter' => [
            'class' => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format' => null,
                'dateFormat' => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
            ],
        ],
    ],
];
