<?php declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;
use App\Controller\IndexController;

Router::addRoute(['POST'], '/', [IndexController::class, 'index']);
