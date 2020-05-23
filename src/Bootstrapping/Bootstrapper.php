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
use PHPStartup\Configuration\DbConfig;
use Psr\Container\ContainerInterface;
use Slim\App;

class Bootstrapper
{
    private App $app;
    private Container $container;

    public function initialize(): void
    {
        // Build DI Container
        $builder = new ContainerBuilder();
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

    private function registerServices(ContainerBuilder $builder): void
    {
        $builder->addDefinitions([
            DbConfig::class => create(DbConfig::class),
            PDO::class => function (ContainerInterface $container) {
                $dbConfig = $container->get(DbConfig::class);

                return new PDO($dbConfig->getDsn(), $dbConfig->getUser(), $dbConfig->getPass());
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
