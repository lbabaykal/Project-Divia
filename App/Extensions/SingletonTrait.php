<?php

namespace App\Extensions;

trait SingletonTrait
{
    protected  static ?self $instance = null;
    private function __construct() {}
    private function __clone() {}

    final public static function getInstance(): ?self
    {
        return self::$instance === null ? self::$instance = new self : self::$instance;
    }
}