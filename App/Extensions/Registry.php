<?php

namespace App\Extensions;

class Registry
{
    protected static array $data = [];

    public static function setData($key, $value): void
    {
        if (!array_key_exists($key, self::$data)) {
            self::$data[$key] = $value;
        } else {
            throw new \Exception("This {$key} already used.");
        }
    }

    public static function setDataArray(array $array): void
    {
        foreach ($array as $key => $value) {
            self::$data[$key] = $value;
        }
    }

    public static function getData($key): string|int|null
    {
        return isset(self::$data[$key]) ? self::$data[$key] : null;
    }

    public static function delData($key): void
    {
        if (array_key_exists($key, self::$data)) {
            unset(self::$data[$key]);
        }
    }

}