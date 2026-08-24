<?php

declare(strict_types=1);

namespace BNT\Test\Integration;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DriverManager;

final class DatabaseConnectionTest extends TestCase
{
    public function testDatabaseConnectionAndTableSchema(): void
    {
        $dbHost = getenv('BNT_DATABASE_HOST') ?: 'db';
        $dbName = getenv('BNT_DATABASE_NAME') ?: 'bnt';
        $dbUser = getenv('BNT_DATABASE_USERNAME') ?: 'root';
        $dbPass = getenv('BNT_DATABASE_PASSWORD') ?: 'root';
        $dbPort = (int)(getenv('BNT_DATABASE_PORT') ?: 3306);

        $connectionParams = [
            'dbname' => $dbName,
            'user' => $dbUser,
            'password' => $dbPass,
            'host' => $dbHost,
            'port' => $dbPort,
            'driver' => 'pdo_mysql',
            'charset' => 'utf8mb4',
        ];

        $connection = DriverManager::getConnection($connectionParams);
        $this->assertTrue($connection->isConnected() || $connection->connect());

        $schemaManager = $connection->createSchemaManager();
        $tables = $schemaManager->listTableNames();

        $this->assertContains('bnt_ships', $tables);
        $this->assertContains('bnt_universe', $tables);
        $this->assertContains('bnt_planets', $tables);
    }
}
