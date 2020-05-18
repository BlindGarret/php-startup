<?php
/**
 * Simple bootstrapper setup to use slimphp.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\Bootstrapping;

use PDO;
use PHPStartup\Bootstrapping\Registrations\MainRegistrar;
use Slim\App;
use Slim\Factory\AppFactory;

class Bootstrapper
{
    private App $app;
    private PDO $pdo;

    public function initialize(): void
    {
        $this->app = AppFactory::create();
        $dsn = getenv('DATABASE_DSN');
        $user = getenv('DATABASE_USER');
        $pass = getenv('DATABASE_PASS');
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->registerHandlers();
    }

    public function run(): void
    {
        $this->app->run();
    }

    private function registerHandlers(): void
    {
        $registrars = [new MainRegistrar($this->pdo)];

        foreach ($registrars as $k => $registrar) {
            $registrar->registerHandlers($this->app);
        }
    }
}
