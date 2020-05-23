<?php
/**
 * Index page controller.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\Controllers\Pages;

use DateTime;
use PDO;
use PHPStartup\DataServices\ISqlInfoService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class IndexController
{
    public function handleRequest(
        ISqlInfoService $dataService,
        Environment $environment,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response->getBody()->write($environment->render('IndexView.twig', [
            'name' => 'world',
            'version' => $dataService->getSqlVersion(),
            'renderedAt' => (new DateTime())->format('Y-m-d H:i:s')
        ]));

        return $response;
    }
}
