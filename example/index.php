<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf Nano.
 *
 * @link     https://www.hyperf.io
 * @document https://nano.hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/nano/blob/master/LICENSE
 */
namespace Hyperf\Nano;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\DB\DB;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Nano\Factory\AppFactory;
use Swlib\SaberGM;

require_once __DIR__ . '/../vendor/autoload.php';

class Foo
{
    public function bar()
    {
        return 'bar';
    }
}

$app = AppFactory::createBase();

$app->get('/', function () {
    $user = $this->request->input('user', 'nano');
    $method = $this->request->getMethod();
    return [
        'message' => "hello {$user}",
        'method' => $method,
    ];
});

$app->get('/test', function () {
    try {
//        $res = SaberGM::get('http://10.10.107.151:9502');var_dump($res->getBody()->getContents());
        $requests = [];
        for ($i = 6666; $i--;) {
            $requests[] = ['uri' => 'http://10.10.107.151:9502'];
        }
        $res = SaberGM::requests($requests);
        echo "use {$res->time}s\n";
        echo "success: $res->success_num, error: $res->error_num";
        return 'success';
    } catch (\Exception $e) {
        var_dump($e->getMessage());
        return 'error';
    }

});

$app->addGroup('/route', function () use ($app) {
    $app->addRoute(['GET', 'POST'], '/{id:\d+}', function ($id) {
        return '/route/' . $id;
    });
    $app->put('/{name:.+}', function ($name) {
        return '/route/' . $name;
    });
});

$app->get('/di', function () {
    /** @var ContainerProxy $this */
    $foo = $this->get(Foo::class);
    return $foo->bar();
});

$app->get('/middleware', function () {
    return $this->request->getAttribute('key');
});

$app->addMiddleware(function ($request, $handler) {
    $request = $request->withAttribute('key', 'value');
    return $handler->handle($request);
});

$app->get('/exception', function () {
    throw new \Exception();
});

$app->addExceptionHandler(function ($throwable, $response) {
    return $response->withStatus('418')->withBody(new SwooleStream('I\'m a teapot'));
});

$app->addCommand('echo', function () {
    $this->get(StdoutLoggerInterface::class)->info('A new command called echo!');
});

$app->addListener(BootApplication::class, function ($event) {
    $this->get(StdoutLoggerInterface::class)->info('App started');
});

//$app->addProcess(function () {
//    while (true) {
//        sleep(1);
//        $this->get(StdoutLoggerInterface::class)->info('Processing...');
//    }
//});
//
//$app->addCrontab('* * * * * *', function () {
//    $this->get(StdoutLoggerInterface::class)->info('execute every second!');
//});

$app->config([
    'db.default' => [
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', 3306),
        'database' => env('DB_DATABASE', 'hyperf'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
    ],
]);

$app->get('/db', function () {
    return DB::query('SELECT * FROM `user` WHERE gender = ?;', [1]);
});

$app->run();
