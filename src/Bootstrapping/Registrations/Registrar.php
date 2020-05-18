<?php
/**
 * Index page controller.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\Bootstrapping\Registrations;

use Slim\App;

interface Registrar
{
    public function registerHandlers(App $app): void;
}
