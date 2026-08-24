<?php

declare(strict_types=1);

namespace BNT\ADODB;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\AbstractException;

class ADODBConnection
{
    private ?Connection $connection = null;
    private string $type;
    private int $errorCode = 0;
    private ?string $errorMessage = null;

    public function __construct(string $type = 'pdo_mysql')
    {
        $this->type = $type ?: 'pdo_mysql';
    }

    public function Connect(
        ?string $host,
        ?string $username,
        ?string $password,
        ?string $name,
        $port = null,
        string $charset = 'utf8mb4'
    ): bool {
        $this->errorCode = 0;
        $this->errorMessage = null;

        try {
            $driver = match (strtolower($this->type)) {
                'mysqli' => 'mysqli',
                'pdo_mysql', 'mysql', 'mariadb' => 'pdo_mysql',
                'postgres', 'postgres7', 'pgsql', 'pdo_pgsql' => 'pdo_pgsql',
                'sqlite', 'pdo_sqlite' => 'pdo_sqlite',
                default => 'pdo_mysql',
            };

            $params = [
                'dbname' => $name ?? 'bnt',
                'user' => $username ?? 'root',
                'password' => $password ?? '',
                'host' => $host ?? '127.0.0.1',
                'driver' => $driver,
                'charset' => $charset,
            ];

            if (!empty($port)) {
                $params['port'] = (int) $port;
            }

            $this->connection = DriverManager::getConnection($params);
            $this->connection->connect();

            return $this->connection->isConnected();
        } catch (\Throwable $ex) {
            $this->errorCode = (int) $ex->getCode();
            $this->errorMessage = $ex->getMessage();
            return false;
        }
    }

    public function Execute($sql): ?ADODBResult
    {
        $this->errorCode = 0;
        $this->errorMessage = null;

        try {
            if ($this->connection === null) {
                return null;
            }
            return new ADODBResult($this->connection->executeQuery($sql));
        } catch (\Throwable $ex) {
            $this->errorCode = (int) $ex->getCode();
            $this->errorMessage = $ex->getMessage();
            return null;
        }
    }


    public function ErrorNo(): int
    {
        return $this->errorCode;
    }

    public function ErrorMsg(): ?string
    {
        return $this->errorMessage;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function __get(string $name)
    {
        if ($name === 'EOF') {
            return false;
        }
        return null;
    }
}
