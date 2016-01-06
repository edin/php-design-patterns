<?php

class Product
{
    private $parts = [];
    
    public function display()
    {
        echo "Product Parts:\n";
        foreach($this->parts as $part)
        {
            echo "  ", $part, "\n";
        }
    }
    
    public function add(string $part)
    {
       $this->parts[] = $part; 
    }
}

interface IBuilder 
{
    public function buildPartA();
    public function buildPartB();
    public function getResult() : Product;
}

class Builder1 implements IBuilder
{
    private $result;
    
    public function __construct()
    {
        $this->result = new Product();
    }
    
    public function buildPartA()
    {
        $this->result->add("Part A");
    }
    
    public function buildPartB()
    {
        $this->result->add("Part B");
    }
    
    public function getResult() : Product
    {
        return $this->result;
    }
}

class Builder2 implements IBuilder
{
    private $result;
    
    public function __construct()
    {
        $this->result = new Product();
    }
    
    public function buildPartA()
    {
        $this->result->add("Part X");
    }
    
    public function buildPartB()
    {
        $this->result->add("Part Y");
    }
    
    public function getResult() : Product
    {
        return $this->result;
    }
}

class Director 
{
    public function construct(IBuilder $builder)
    {
        $builder->buildPartA();
        $builder->buildPartB();
        $builder->buildPartB();
    }
}


$director = new Director();

$b1 = new Builder1();
$b2 = new Builder2();

$director->construct($b1);
$product1 = $b1->getResult();
$product1->display();

$director->construct($b2);
$product2 = $b2->getResult();
$product2->display();