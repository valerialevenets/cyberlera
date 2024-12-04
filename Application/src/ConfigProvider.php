<?php

namespace Application;
class ConfigProvider
{
    private static array $config = [];
    private static function initConfig(): void
    {
        if(empty(static::$config)) {
            self::$config = json_decode(
                file_get_contents(__DIR__ . '/../config/config.json'),
                true
            );
        }
    }
    public static function getTelegramToken(): string
    {
        self::initConfig();
        return self::$config['telegram-token'];
    }
    public static function getDestinationChannel(): string
    {
        self::initConfig();
        return self::$config['destination-channel'];
    }
    public static function getAdminId(): string
    {
        self::initConfig();
        return self::$config['admin-id'];
    }
}