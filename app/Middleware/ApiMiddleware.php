<?php declare(strict_types=1);

namespace App\Middleware;

use App\Exception\ApiException;
use App\Lib\Translate\Translate;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApiMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = $request->getParsedBody();
        $lang = $data['lang'] ?? '';
        !in_array($lang, Translate::ACCEPT_LANG) && $lang = Translate::DEFAULT_LANG;
        $method = $data['method'] ?? '';
        if (empty($method)) {
            throw new ApiException(404);
        }
        //user.info
        $controller = 'App\\Controller';
        $split = explode('.', $method);
        foreach ($split as $key => $value)
        {
            $controller .= '\\' . ucfirst($value);
        }
        if (!class_exists($controller)) {
            throw new ApiException(404);
        }

        Context::set('lang', $lang);
        Context::set('method', $method);
        Context::set('controller', new $controller($data));

        return $handler->handle($request);
    }
}
