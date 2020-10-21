<?php declare(strict_types=1);

namespace App\Traits;

use App\Lib\Translate\Translate;

trait CommonTrait
{
    public function success(array $data = [], int $code = 200): array
    {
        $success = [
            'status' => true,
            'code' => $code,
            'message' => Translate::getMessage($code),
        ];
        !empty($data) && $success['data'] = $data;

        return $success;
    }

    public function error(int $code = 400, array $data = []): array
    {
        $error = [
            'status' => false,
            'code' => $code,
            'message' => Translate::getMessage($code),
        ];
        !empty($data) && $error['data'] = $data;

        return $error;
    }
}

