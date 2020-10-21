<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\BaseController;

class GetInfo extends BaseController
{
    public function process(array $data): array
    {
       return $this->success($data);
    }
}
