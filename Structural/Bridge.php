<?php

interface IBridge
{
    function OperationImp() : string;
}

class Abstraction 
{
    private $bridge;
    
    public function __construct(IBridge $implement)
    {
        $this->bridge = $implement;
    }
    
    public function OperationImp() : string 
    {
        return 'Abstraction  <<< BRIDGE >>> ' . $this->bridge->OperationImp() . "\n";    
    }
}

class ImplementationA implements IBridge
{
    public function OperationImp() : string 
    {
        return 'Implementation A';
    }
} 

class ImplementationB implements IBridge 
{
    public function OperationImp() : string 
    {
        return 'Implementation B';
    }
} 

$abstraction = new Abstraction(new ImplementationA());
echo $abstraction->OperationImp();

$abstraction = new Abstraction(new ImplementationB());
echo $abstraction->OperationImp();