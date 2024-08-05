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
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');
Router::addRoute('GET', '/uploads', 'App\Controller\UploadController@list');
Router::post('/uploads', [App\Controller\UploadController::class, 'send']);
Router::delete('/uploads', [App\Controller\UploadController::class, 'delete']);
// Router::addRoute(['POST'], '/uploads', 'App\Controller\UploadController@send');

Router::get('/favicon.ico', function () {
    return '';
});
