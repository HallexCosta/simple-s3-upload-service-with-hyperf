<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Server\Exception\ServerException; 
use Hyperf\ExceptionHandler\Annotation\ExceptionHandler as RegisterHandler;
use Throwable;


#[RegisterHandler(server: 'http', priority: 0)]
class HttpExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if (!($throwable instanceof ServerException)) {
            return;
        }
        $this->stopPropagation();
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());
        return $response->withHeader('Server', 'SimpleServiceUploadS3')->withStatus($throwable->getCode())->withBody(new SwooleStream($throwable->getMessage()));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
