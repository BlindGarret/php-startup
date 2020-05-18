<?php
/**
 * Index page controller.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\Controllers;

use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController
{
    public function handleRequest(
        PDO $pdo,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $stm = $pdo->query('SELECT VERSION()');

        $version = $stm->fetch();
        $response->getBody()->write('Hello world! '.$version[0]);

        return $response;
    }
}
