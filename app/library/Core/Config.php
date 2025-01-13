<?php

namespace App\Core;

use LogicException;

class Config
{
    private static ?Config $instance = null;

    private string $databaseHost = 'localhost';
    private int $databasePort = 3306;
    private string $databaseName = 'tic_tac_toe';
    private string $databaseUsername = 'tic_tac_toe';
    private string $databasePassword = 'tic_tac_toe';
    private string $databaseCharset = 'utf8mb4';

    private function __construct(string $configPath)
    {
        include $configPath;
    }

    public static function initConfig(string $configPath): void
    {
        self::$instance = new Config($configPath);
    }

    public static function getConfig(): Config
    {
        if (self::$instance) {
            return self::$instance;
        }

        throw new LogicException('Config was not initialized. Call Config::initConfig() first.');
    }

    public function getDatabaseHost(): string
    {
        return $this->databaseHost;
    }

    public function getDatabasePort(): int
    {
        return $this->databasePort;
    }

    public function getDatabaseName(): string
    {
        return $this->databaseName;
    }

    public function getDatabaseUsername(): string
    {
        return $this->databaseUsername;
    }

    public function getDatabasePassword(): ?string
    {
        return $this->databasePassword;
    }

    public function getDatabaseCharset(): string
    {
        return $this->databaseCharset;
    }
}
