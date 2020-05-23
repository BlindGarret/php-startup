<?php
/**
 * API Registrar for registering controllers.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\Bootstrapping\Registrations;

use PHPStartup\Controllers\Api\SqlInfoController;
use Slim\App;

class ApiRegistrar implements Registrar
{
    public function registerHandlers(App $app): void
    {
        $app->get('/api/sql/version/', [SqlInfoController::class, 'handleRequest']);
    }
}
