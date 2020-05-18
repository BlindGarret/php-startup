<?php
/**
 * Simple Config object for injecting environment variables into classes.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

namespace PHPStartup\Configuration;

class DbConfig
{
    private string $dsn;
    private string $user;
    private string $pass;

    public function __construct()
    {
        $this->dsn = getenv('DATABASE_DSN');
        $this->user = getenv('DATABASE_USER');
        $this->pass = getenv('DATABASE_PASS');
    }

    /**
     * Get the value of dsn.
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * Get the value of user.
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the value of pass.
     */
    public function getPass()
    {
        return $this->pass;
    }
}
