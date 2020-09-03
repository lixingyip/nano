<?php

declare(strict_types=1);

namespace Hyperf\Nano;

use App\Controller\WebsocketController;
use Hyperf\Nano\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::createWebsocket();

$app->addServer('ws', function () use ($app) {
    $app->get('/', WebsocketController::class);
});

//$app->get('/', WebsocketController::class);

$app->run();
