<?php

class Adaptee 
{
    public function specificRequest(float $a, float $b) : float 
    {
        return $a / $b;   
    }
}

interface ITarget
{
    function request(int $i) : string;
}

class Adapter extends Adaptee implements ITarget
{
    public function request(int $i) : string
    {
         return (int)($this->specificRequest($i, 3)); 
    }
}


$adaptee = new Adaptee;
echo "Before the new standard:  ", $adaptee->specificRequest(5,3), "\n";

function testAdapter(ITarget $target) 
{
    echo "Moving to new standard: ";
    echo $target->request(5);     
}

$target = new Adapter;
testAdapter($target);