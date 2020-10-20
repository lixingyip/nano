<?php

declare(strict_types=1);

namespace App\Exception;

use App\Lib\Translate\Translate;

class ApiException extends \Exception
{
    /**
     * ApiException constructor.
     * @param int $code
     * @param string $message
     */
    public function __construct(int $code, string $message = '')
    {
        $this->code = $code;
        $translate = Translate::getMessage($this->code);
        $message = sprintf($translate, $message);

        parent::__construct($message, $code);
    }

}
