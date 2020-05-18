<?php
/**
 * Main Registrar for registering controllers.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\Bootstrapping\Registrations;

use PHPStartup\Controllers\IndexController;
use PHPStartup\Controllers\TestController;
use Slim\App;

class MainRegistrar implements Registrar
{
    public function registerHandlers(App $app): void
    {
        $app->get('/', [IndexController::class, 'handleRequest']);
        $app->get('/test/', [TestController::class, 'handleRequest']);
    }
}
