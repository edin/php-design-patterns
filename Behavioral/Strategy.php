<?php

interface IStrategy
{
    function Move(Context $context) : int;
}

class Strategy1 implements IStrategy
{
    function Move(Context $context) : int
    {
        $context->counter += 1;
        return $context->counter;
    }
}

class Strategy2 implements IStrategy
{
    function Move(Context $context) : int
    {
        $context->counter -= 1;
        return $context->counter;
    }
}

class Context
{
    private $strategy;
    public $counter = 0;
    
    public function setStrategy(IStrategy $strategy)
    {
        $this->strategy = $strategy;
    }
    
    public function Algorithm() : int
    {
        return $this->strategy->Move($this); 
    }
}


$context = new Context;

$strategy1 = new Strategy1;
$strategy2 = new Strategy2;

$context->setStrategy($strategy1);

for ($i = 0; $i < 30; $i ++)
{
    if ($i == 15) {
        $context->setStrategy($strategy2);
    }    
    echo "Counter = ", $context->Algorithm(), "\n";
}
