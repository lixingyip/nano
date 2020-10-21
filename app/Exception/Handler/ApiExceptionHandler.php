<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\Logger\LoggerFactory;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ApiExceptionHandler extends ExceptionHandler
{
    /**
     * @var StdoutLoggerInterface|LoggerFactory
     */
    protected $logger;

    /**
     * @var FormatterInterface
     */
    protected $formatter;

    public function __construct(FormatterInterface $formatter)
    {
        if (env('APP_ENV', 'dev') == 'dev') {
            $this->logger = container()->get(StdoutLoggerInterface::class);
        } else {
            $this->logger = container()->get(LoggerFactory::class)->get();
        }
        $this->formatter = $formatter;
    }

    /**
     * @param Throwable $throwable
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error($this->formatter->format($throwable));

        $this->stopPropagation();

        return $response->withBody(new SwooleStream(json_encode([
            'status' => false,
            'code' => $throwable->getCode() ?: 400,
            'message' => $throwable->getMessage(),
        ], JSON_UNESCAPED_UNICODE)));
    }

    /**
     * @param Throwable $throwable
     * @return bool
     */
    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
