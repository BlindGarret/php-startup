<?php
/**
 * Index page controller.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\Bootstrapping\Registrations;

use PDO;
use PHPStartup\Controllers\IndexController;
use PHPStartup\Controllers\TestController;
use Slim\App;

class MainRegistrar implements Registrar
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function registerHandlers(App $app): void
    {
        $app->get('/', [new IndexController($this->pdo), 'handleRequest']);
        $app->get('/test', [new TestController($this->pdo), 'handleRequest']);
    }
}
