<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;

use Hyperf\Filesystem\Adapter\S3AdapterFactory;

use function Hyperf\Support\env;

return [
    'app_name' => env('APP_NAME', 'skeleton'),
    'app_env' => env('APP_ENV', 'dev'),
    'scan_cacheable' => env('SCAN_CACHEABLE', false),
    StdoutLoggerInterface::class => [
        'log_level' => [
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::DEBUG,
            LogLevel::EMERGENCY,
            LogLevel::ERROR,
            LogLevel::INFO,
            LogLevel::NOTICE,
            LogLevel::WARNING,
        ],
    ],
    // 'storage' => [
    //     's3' => [
    //         'driver' => S3AdapterFactory::class,
    //         'credentials' => [
    //             'key' => env('S3_KEY'),
    //             'secret' => env('S3_SECRET'),
    //         ],
    //         'region' => env('S3_REGION'),
    //         'version' => 'latest',
    //         'bucket_endpoint' => false,
    //         'use_path_style_endpoint' => false,
    //         'endpoint' => env('S3_ENDPOINT'),
    //         'bucket_name' => env('S3_BUCKET'),
    //     ],
    // ]
];
