<?php
declare(strict_types = 1);

interface IComponent
{
    function Operation() : string;
}

class Component implements IComponent
{
    public function Operation() : string 
    {
        return 'I am walking';        
    }
}

class DecoratorA extends Component 
{
    private $component;
    
    public function __construct(IComponent $component)
    {
        $this->component = $component;
    } 
    
    public function Operation() : string 
    {
        return $this->component->Operation() . "and listening to Classic FM ";     
    }
}

class DecoratorB extends Component 
{
    private $component;
    public  $addedState = "";
    
    public function __construct(IComponent $component)
    {
        $this->component = $component;
        $this->addedState = "past the coffe shop ";
    } 
    
    public function Operation() : string 
    {
        return 'I am walking';        
    }
    
    public function AddedBehaviour() : string 
    {
        return 'and I bouth a capuccino ';
    }
}

class Client 
{
    static function Display(string $s, IComponent $c)
    {
        echo $s, $c->Operation(), "\n";
    }
}


$component  = new Component;
$decoratorA = new DecoratorA($component);
$decoratorB = new DecoratorB($component);

Client::Display("1. Basic component : ", $component);
Client::Display("2. A-Decorated     : ", $decoratorA);
Client::Display("3. B-Decorated     : ", $decoratorB);

$decoratorB = new DecoratorB($decoratorA);
Client::Display("4. B-A-Decorated   : ", $decoratorB);

$decoratorB = new DecoratorB($component);
$decoratorA = new DecoratorA($decoratorB);
Client::Display("4. A-B-Decorated   : ", $decoratorA);
echo "                     ", $decoratorB->addedState, $decoratorB->AddedBehaviour();