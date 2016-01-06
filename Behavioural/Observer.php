<?php

class Stock implements SplSubject 
{
    public $symbol;
    public $price;
    private $investors;
    
    public function __construct(string $symbol, float $price)
    {
        $this->symbol = $symbol;
        $this->price = $price;
        
        $this->investors = new SplObjectStorage();
    }
    
    public function __set($name, $value)
    {
        if ($name == "price") {
            $this->setPrice($value);
        }
    }    
    
    private function setPrice($value)
    {
        if ($this->price <> $value) {
            $this->price = $value;
            $this->notify();
        }
    }
    
    public function __get($name)
    {
        switch ($name){
            case "symbol": return $this->symbol;
            case "price" : return $this->price;
        }
    }        
      
    public function attach(SplObserver $observer)
    {
        $this->investors->attach($observer);
    }
    
    public function detach(SplObserver $observer)
    {
        $this->investors->detach($observer);
    }
    
    public function notify()
    {
        foreach($this->investors as $observer) {
            $observer->update($this);
        }
    }    
}

class Investor implements SplObserver
{
    private $name;
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    public function update(SplSubject $subject)
    {
        $stock = $subject;
        echo "Notified {$this->name} of {$stock->symbol} change to {$stock->price}\n"; 
    }
}

$stock = new Stock('IBM', 120.0);
$investor1 = new Investor('Sorros');
$investor2 = new Investor('Berkshire');


$stock->attach($investor1);
$stock->attach($investor2);

$stock->price = 120.10;
$stock->price = 121.0;
$stock->price = 120.50;
$stock->price = 120.750;

$stock->detach($investor2);

$stock->price = 120.10;
$stock->price = 121.0;
$stock->price = 120.50;
$stock->price = 120.750;