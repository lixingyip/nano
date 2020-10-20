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
namespace Nano\Factory;

use App\Lib\Translate\Translate;
use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use Hyperf\Config\Config;
use Hyperf\Config\ProviderConfig;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSource;
use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;
use Hyperf\HttpServer\Router\DispatcherFactory;
use Hyperf\Utils\ApplicationContext;
use Nano\App;
use Nano\BoundInterface;
use Nano\ContainerProxy;
use Nano\Preset\Preset;
use Psr\Log\LogLevel;
use Symfony\Component\Finder\Finder;

class AppFactory
{
    /**
     * Create an application.
     * @param string $host
     * @param int $port
     * @return App
     */
    public static function create(string $host = '0.0.0.0', int $port = 9501): App
    {
        $app = self::createApp();
        $app->config([
            'server' => Preset::default(),
            'server.servers.0.host' => $host,
            'server.servers.0.port' => $port,
        ]);
        $app->addExceptionHandler(HttpExceptionHandler::class);
        return $app;
    }

    /**
     * Create a single worker application in base mode, with max_requests = 0.
     * @param string $host
     * @param int $port
     * @return App
     */
    public static function createBase(string $host = '0.0.0.0', int $port = 9501): App
    {
        $app = self::createApp();
        $app->config([
            'server' => Preset::base(),
            'server.servers.0.host' => $host,
            'server.servers.0.port' => $port,
        ]);
        $app->addExceptionHandler(HttpExceptionHandler::class);
        return $app;
    }

    /**
     * @param string $host
     * @param int $port
     * @return App
     */
    public static function createWebsocket(string $host = '0.0.0.0', int $port = 9502): App
    {
        $app = self::createApp();
        $app->config([
            'server' => Preset::websocket(),
            'server.servers.0.host' => $host,
            'server.servers.0.port' => $port,
        ]);
        $app->addExceptionHandler(HttpExceptionHandler::class);
        return $app;
    }

    protected static function loadDotenv(): void
    {
        if (file_exists(BASE_PATH . '/.env')) {
            $repository = RepositoryBuilder::create()
                ->withReaders([
                    new PutenvAdapter(),
                ])
                ->withWriters([
                    new PutenvAdapter(),
                ])
                ->immutable()
                ->make();

            Dotenv::create($repository, [BASE_PATH])->load();
        }
    }

    protected static function prepareContainer(): ContainerInterface
    {
        $config = new Config(ProviderConfig::load());
        $config->set(StdoutLoggerInterface::class, [
            'log_level' => [
                LogLevel::ALERT,
                LogLevel::CRITICAL,
//                LogLevel::DEBUG,
                LogLevel::EMERGENCY,
                LogLevel::ERROR,
                LogLevel::INFO,
                LogLevel::NOTICE,
                LogLevel::WARNING,
            ],
        ]);
        $finder = new Finder();
        $finder->files()->in(BASE_PATH . '/config')->name('*.php');
        foreach ($finder as $file) {
            $key = $file->getFilenameWithoutExtension();
            $value = $config->get($file->getFilenameWithoutExtension(), []);
            $value = array_merge($value, require $file->getRealPath());
            $config->set($key, $value);
        }
        $container = new Container(new DefinitionSource($config->get('dependencies')));
        $container->set(ConfigInterface::class, $config);
        $container->define(DispatcherFactory::class, DispatcherFactory::class);
        $container->define(BoundInterface::class, ContainerProxy::class);

        ApplicationContext::setContainer($container);
        return $container;
    }

    protected static function prepareFlags(int $hookFlags = SWOOLE_HOOK_ALL)
    {
        ini_set('display_errors', 'on');
        ini_set('display_startup_errors', 'on');
        error_reporting(E_ALL);
        $reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);
        $projectRootPath = dirname($reflection->getFileName(), 3);
        ! defined('BASE_PATH') && define('BASE_PATH', $projectRootPath);
        ! defined('SWOOLE_HOOK_FLAGS') && define('SWOOLE_HOOK_FLAGS', $hookFlags);
    }

    protected static function loadTranslate()
    {
        $finder = new Finder();
        $finder->files()->in(BASE_PATH . '/storage/languages')->name('*.php');
        $data = [];
        foreach ($finder as $file) {
            $data[$file->getFilenameWithoutExtension()] = require $file->getRealPath();
        }
        Translate::setMessage($data);
    }

    /**
     * Create an application with a chosen preset.
     */
    protected static function createApp(): App
    {
        // Setting ini and flags
        self::prepareFlags();

        // Prepare env
        self::loadDotenv();

        // Prepare translate
        self::loadTranslate();

        // Prepare container
        $container = self::prepareContainer();

        return new App($container);
    }
}
