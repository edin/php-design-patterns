<?php

trait SingletonTrait
{
    private static $instance = null;
    private function __wakeup() {}
    private function __clone()  {}
    
    public static function sharedInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static;
        }
        return self::$instance;
    }  
}

final class Singleton 
{
    use SingletonTrait;
    private $inc = 0;
    
    private function __construct() {}
}

$instance1 = Singleton::sharedInstance();
$instance2 = Singleton::sharedInstance();

if ($instance1 === $instance2) {
    echo "Same instances\n";
} 