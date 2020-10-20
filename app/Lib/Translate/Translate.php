<?php declare(strict_types=1);

namespace App\Lib\Translate;

use Hyperf\Utils\Context;

class Translate
{
    const DEFAULT_LANG = 'zh_CN';
    const ACCEPT_LANG = ['zh_CN', 'en'];

    private static $messages = [];

    public static function getMessage(int $code): string
    {
        $lang = Context::get('lang', 'zh_CN');
        return self::$messages[$lang][$code] ?? '';
    }

    public static function setMessage(array $data): void
    {
        self::$messages = $data;
    }
}
