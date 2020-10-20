<?php

declare(strict_types=1);

namespace App\Lib\Log;

use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Throwable;

class ApiFormatter implements FormatterInterface
{
    public function format(Throwable $throwable): string
    {
        return sprintf(
            "(%s)%s in %s:%s",
            $throwable->getCode(),
            $throwable->getMessage(),
            $throwable->getFile(),
            $throwable->getLine()
        );
    }
}
