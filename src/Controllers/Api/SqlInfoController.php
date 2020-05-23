<?php
/**
 * Sql Info API controller.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\Controllers\Api;

use PHPStartup\DataServices\ISqlInfoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SqlInfoController
{
    public function handleRequest(
        ISqlInfoService $infoService,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $resp = $response
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withStatus(200);
        $resp->getBody()->write(json_encode(array('version' => $infoService->getSqlVersion())));
        return $resp;
    }
}
