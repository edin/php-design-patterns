<?php

interface LoggerInterface
{
    function error($message);
    function warning($message);
    function notice($message);
    function trace($message);
    function log($type, $message);
}

class NullLogger implements LoggerInterface
{
    public function error($message) { }
    public function warning($message) { }
    public function notice($message) { }
    public function trace($message) { }
    public function log($type, $message) { }
}

class Application
{
    private $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;    
    }
    
    public function run()
    {
        $this->logger->trace("Application started");
    }
}


$app = new Application(new NullLogger);
$app->run();