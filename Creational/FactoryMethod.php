<?php

interface IProduct
{
    function shipFrom() : string;
}


class ProductA implements IProduct
{
    public function shipFrom() : string { 
       return "from South Africa"; 
    }
}

class ProductB implements IProduct
{
    public function shipFrom() : string { 
        return "from Spain";
    }    
}

class DefaultProduct implements IProduct
{
    public function shipFrom() : string { 
        return "not available";
    }    
}


class Creator 
{
    public function factoryMethod(int $month)
    {
        if ($month > 4 && $month <= 11)
        {
            return new ProductA();
        } 
        else if ($month == 1 || $month == 2 || $month == 12)
        {
            return new ProductB();
        }
        return new DefaultProduct;
    }
}


$creator = new Creator;

for($i  = 1; $i <= 12; ++$i) {
    $product = $creator->factoryMethod($i);
    echo  'Avokados ', $product->shipFrom();                
}