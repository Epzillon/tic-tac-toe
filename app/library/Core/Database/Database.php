<?php

namespace App\Core\Database;

use App\Core\Config;

class Database
{
    private static ?DatabaseInterface $database = null;

    public static function getDatabase(): DatabaseInterface
    {
        if (self::$database === null) {
            $config = Config::getConfig();
            self::$database = new MariaDatabase($config);
        }

        return self::$database;
    }
}
