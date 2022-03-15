<?php

namespace Appwrite\Extend;

use Swoole\Coroutine\PostgreSQL as PostgreSQLNative;

class PostgreSQL extends PostgreSQLNative
{
    /**
     * @var PostgreSQLNative
     */
    protected $pdo;

    protected string $dsn;
    protected string $host;
    protected int $port;
    protected string $db;
    protected string $username;
    protected string $password;
    protected string $options;

    protected int $counter = 0;

    /**
     * Create A Proxy PostgreSQL Object
     */
    public function __construct(string $host, int $port, string $db, string $username = null, string $password = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->db = $db;
        $this->username = $username;
        $this->password = $password;
        $this->dsn = "host={$host} port={$port} dbname={$db}";

        if ($this->username) {
            $this->dsn .= " user={$username}";

            if ($this->password) {
                $this->dsn .= " password={$password}";
            }
        }

        $this->pdo = new PostgreSQLNative($this->dsn);
    }

    public function prepare(string $statement)
    {
        return new PostgreSQLStatement($this->pdo, $this->counter++, $statement);
    }

    public function quote($string, $parameter_type = 1)
    {
        return $this->pdo->escape($string);
    }

    public function beginTransaction()
    {
        return $this->pdo->query('BEGIN;');
    }

    public function rollBack()
    {
        return $this->pdo->query('ROLLBACK;');
    }

    public function commit()
    {
        return $this->pdo->query('COMMIT;');
    }
}
