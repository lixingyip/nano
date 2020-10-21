<?php declare(strict_types=1);

namespace App\Lib\Translate;

use Hyperf\Utils\Context;

class Translate
{
    const DEFAULT_LANG = 'zh_CN';
    const ACCEPT_LANG = ['zh_CN', 'en'];

    private static $messages = [];

    public static function getMessage(int $code, string $message = ''): string
    {
        $lang = Context::get('lang', 'zh_CN');
        $messages = explode('|', $message);
        return sprintf(self::$messages[$lang][$code] ?? '', ...$messages);
    }

    public static function setMessage(array $data): void
    {
        self::$messages = $data;
    }
}
