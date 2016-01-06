<?php

interface IState
{
    function moveUp(Context $c): int;
    function moveDown(Context $c): int;
} 

class NormalState implements IState
{
    public function moveUp(Context $c): int
    {
        if ($c->counter < Context::LIMIT) {
            $c->state = new FastState;
            echo "<Fast state>\n";
        }
        $c->counter -= 2;
        return $c->counter;        
    }
    
    public function moveDown(Context $c): int 
    {
        $c->counter += 2;
        return $c->counter;
    }    
}

class FastState implements IState
{
    public function moveUp(Context $c): int
    {
        $c->counter += 5;
        return $c->counter;            
    }
    
    public function moveDown(Context $c): int 
    {
        if ($c->counter < Context::LIMIT) {
            $c->state = new NormalState;
            echo "<Normal state>\n";
        }
        $c->counter -= 5;
        return $c->counter;  
    }    
}

class Context 
{
    const LIMIT = 10;
    
    public $state;
    public $counter;
    
    public function __construct()
    {
        $this->counter = self::LIMIT;
    }
    
    public function request(int $i) : int
    {
        if ($i == 2) {
            return $this->state->moveUp($this);
        } else {
            return $this->state->moveDown($this);
        }
    }
}

$context = new Context;
$context->state = new NormalState;

for($i = 0; 
    $i < 500; 
    ++$i)
{ 
    $r = mt_rand(1,3);    
    echo $context->request($r), "\n";
}