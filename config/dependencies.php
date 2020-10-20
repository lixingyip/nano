<?php

declare(strict_types=1);

return [
    Hyperf\ExceptionHandler\Formatter\FormatterInterface::class => \App\Lib\Log\ApiFormatter::class,
];
