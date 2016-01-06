<?php

class Memento
{
    public $name;
    public $phone;
    public $budget;
    
    public function __construct($name, $phone, $budget)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->budget = $budget;
    }
}


class SalesProspect
{
    private $name;
    private $phone;
    private $budget;
    private $onPropertyChanged = null;

    public function setName(string $name)
    {
        $this->name = $name;
        $this->propertyChanged("name");
    } 
    
    public function getName() : string
    {
        return $this->name;    
    }
    
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
        $this->propertyChanged("phone");
    } 
    
    public function getPhone() : string
    {
        return $this->phone;    
    }
    
    public function setBudget(float $budget)
    {
        $this->budget = $budget;
        $this->propertyChanged("budget");
    } 
    
    public function getBudget() : float
    {
        return $this->budget;    
    }       
    
    private function propertyChanged($name)
    {
        $value = $this->{$name};
        if (is_callable($this->onPropertyChanged)) {
            call_user_func($this->onPropertyChanged, $name, $value);
        }
    }
    
    public function saveMemento() : Memento 
    {
        return new Memento($this->name, $this->phone, $this->budget);
    }    
    
    public function restoreMemento(Memento $memento)
    {
        $this->setName($memento->name);
        $this->setPhone($memento->phone);
        $this->setBudget($memento->budget);
    }
    
    public function setOnPropertyChanged($propertyChangedCallback)
    {
        $this->onPropertyChanged = $propertyChangedCallback;
    }
}


$s = new SalesProspect();
$s->setOnPropertyChanged(function($name, $value) {
    echo "Setting $name to $value \n"; 
});

$s->setName("Noel van Halen");
$s->setPhone("(412) 256-0990");
$s->setBudget(25000.0);

$memento = $s->saveMemento();

$s->setName("Leo Welch");
$s->setPhone("(310) 209-7111");
$s->setBudget(1000000.0);

echo "\n\nRestoring memento:\n";
$s->restoreMemento($memento);