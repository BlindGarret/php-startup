<?php
/**
 * Test page controller.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\Controllers\Pages;

use PDO;
use PHPStartup\DataServices\ISqlInfoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestController
{
    public function handleRequest(
        ISqlInfoService $dataService,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response->getBody()->write('Test world! '.$dataService->getSqlVersion());

        return $response;
    }
}
