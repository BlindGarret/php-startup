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
use function DI\create;
use Middlewares\TrailingSlash;
use PDO;
use PHPStartup\Bootstrapping\Registrations\MainRegistrar;
use PHPStartup\Configuration\DbConfig;
use Slim\App;

class Bootstrapper
{
    private App $app;
    private Container $container;

    public function initialize(): void
    {
        // Build DI Container
        $this->container = new Container();
        $this->registerServices();
        $this->registerControllers();

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

    private function registerServices(): void
    {
        $this->container->set(DbConfig::class, create(DbConfig::class));
        $this->container->set(PDO::class, function () {
            $dbConfig = $this->container->get(DbConfig::class);

            return new PDO($dbConfig->getDsn(), $dbConfig->getUser(), $dbConfig->getPass());
        });
    }

    private function registerControllers(): void
    {
    }

    private function registerHandlers(): void
    {
        $registrars = [
            MainRegistrar::class,
        ];

        foreach ($registrars as $k => $registrar) {
            $this->container->get($registrar)->registerHandlers($this->app);
        }
    }
}
