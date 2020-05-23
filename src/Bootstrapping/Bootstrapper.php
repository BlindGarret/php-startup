<?php
/**
 * Simple bootstrapper setup to use slimphp.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\Bootstrapping;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use DI\ContainerBuilder;

use function DI\autowire;
use function DI\create;
use Middlewares\TrailingSlash;
use PDO;
use PHPStartup\DataServices\ISqlInfoService;
use PHPStartup\DataServices\MysqlServices\SqlInfoService;
use PHPStartup\Bootstrapping\Registrations\ApiRegistrar;
use PHPStartup\Bootstrapping\Registrations\MainRegistrar;
use PHPStartup\Configuration\Config;
use PHPStartup\Configuration\DbConfig;
use PHPStartup\Configuration\TwigConfig;
use Psr\Container\ContainerInterface;
use Slim\App;
use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader;

class Bootstrapper
{
    private App $app;
    private Container $container;

    public function initialize(): void
    {
        // Build DI Container
        $builder = new ContainerBuilder();
        $this->registerConfiguration($builder);
        $this->registerServices($builder);
        $this->container = $builder->build();

        // Build Slim APP
        $this->app = Bridge::create($this->container);
        $this->app->add(new TrailingSlash(true));
        // Register Route Handlers
        $this->registerHandlers();
    }

    public function run(): void
    {
        $this->app->run();
    }

    private function registerConfiguration(ContainerBuilder $builder): void
    {
        $builder->addDefinitions([
            // Root Config
            'config.environment' => getenv('DEPLOYMENT_ENV') ?? "PROD",

            // DB Config
            'config.db.dsn' => getenv('DATABASE_DSN'),
            'config.db.user' => getenv('DATABASE_USER'),
            'config.db.pass' => getenv('DATABASE_PASS'),

            // Twig Config
            'config.twig.compilationCacheDir' => getenv('TWIG_COMPILATION_CACHE_DIR') ?? false,
        ]);
    }

    private function registerServices(ContainerBuilder $builder): void
    {
        $builder->addDefinitions([
            // Database
            PDO::class => function (ContainerInterface $container) {
                return new PDO(
                    $container->get('config.db.dsn'),
                    $container->get('config.db.user'),
                    $container->get('config.db.pass')
                );
            },

            // Twig
            TwigEnvironment::class => function (ContainerInterface $container) {
                return new TwigEnvironment(new FilesystemLoader(__DIR__.'/../Views'), [
                    'cache' =>  $container->get('config.twig.compilationCacheDir'),
                    'auto_reload' => $container->get('config.environment') === 'DEV',
                    'debug' => $container->get('config.environment') === 'DEV',
                ]);
            },

            // Data Services
            ISqlInfoService::class => autowire(SqlInfoService::class)
        ]);
    }

    private function registerHandlers(): void
    {
        $registrars = [
            MainRegistrar::class,
            ApiRegistrar::class,
        ];

        foreach ($registrars as $k => $registrar) {
            $this->container->get($registrar)->registerHandlers($this->app);
        }
    }
}
