<?php declare(strict_types=1);

namespace App\Controller;

use Hyperf\Utils\Context;
use Hyperf\HttpServer\Contract\RequestInterface;

class IndexController
{
    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct()
    {
        $this->request = container()->get(RequestInterface::class);
    }

    public function index(): array
    {
        $data = $this->request->getParsedBody();
        /* @var BaseController $controller*/
        $controller = Context::get('controller', null);

        return $controller->process($data);
    }
}
