<?php
/**
 * Data access service for getting SQL Server information
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

declare(strict_types=1);

namespace PHPStartup\DataServices;

interface ISqlInfoService
{
    public function getSqlVersion(): string;
}
