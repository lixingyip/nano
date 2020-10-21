<?php declare(strict_types=1);

namespace App\Controller;

use App\Traits\CommonTrait;

abstract class BaseController
{
    use CommonTrait;

    abstract public function process(array $data): array;
}
