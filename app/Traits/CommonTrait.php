<?php declare(strict_types=1);

namespace App\Traits;

trait CommonTrait
{
    public function success(array $data = []): array
    {
        $success = [
            'status' => true,
            'code' => 200,
            'message' => 'Success Request',
        ];
        !empty($data) && $success['data'] = $data;

        return $success;
    }

    public function error(int $code, array $data = []): array
    {
        $error = [
            'status' => false,
            'code' => $code,
            'message' => 'Bad Request',
        ];
        !empty($data) && $error['data'] = $data;

        return $error;
    }
}

