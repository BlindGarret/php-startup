<?php
/**
 * Data access service for getting SQL Server information
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\DataServices\MysqlServices;

use PDO;
use PHPStartup\DataServices\ISqlInfoService;

class SqlInfoService implements ISqlInfoService
{
    private PDO $connection;
    public function __construct(PDO $pdo)
    {
        $this->connection = $pdo;
    }

    public function getSqlVersion(): string
    {
        return $this->connection->query('SELECT VERSION()')->fetch()[0];
    }
}
