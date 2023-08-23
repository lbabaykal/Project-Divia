<?php

namespace App;

trait SingletonTrait
{
    protected  static ?self $instance = null;
    private function __construct() {}
    private function __clone() {}

    final public static function getInstance(): ?self
    {
//        if (self::$instance === null) {
//            self::$instance = new self;
//        }
//        return self::$instance;
        return self::$instance === null ? self::$instance = new self : self::$instance;
    }
}