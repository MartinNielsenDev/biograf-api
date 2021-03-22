<?php


class Server
{
    private static $settings = null;

    private static function getSettings(): array
    {
        if (self::$settings === null) {
            self::$settings = require __DIR__ . '/configs/secret.php';
        }
        return self::$settings;
    }

    public static function getDatabaseHost(): string
    {
        return self::getSettings()['db_host'];
    }

    public static function getDatabaseUser(): string
    {
        return self::getSettings()['db_username'];
    }

    public static function getDatabasePassword(): string
    {
        return self::getSettings()['db_password'];
    }
}
