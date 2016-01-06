<?php

interface MediatorInterface
{
    function send(string $message, $colleague);
}

class Colleague 
{
    protected $mediator;
    
    public function __construct($mediator)
    {
        $this->mediator = $mediator;
    }
    
    public function send(string $message)
    {
        $this->mediator->send($message, $this);
    }
}

class ConcreteColleague1 extends Colleague
{
    public function notify(string $message)
    {
        echo "Colleague1 gets message: $message\n";
    }
}

class ConcreteColleague2 extends Colleague
{
    public function notify(string $message)
    {
        echo "Colleague2 gets message: $message\n";
    }    
}

class ConcreteMediator implements MediatorInterface
{
    public $colleague1;
    public $colleague2;
    
    function send(string $message, $colleague)
    {
        if ($colleague == $this->colleague2) {
            $this->colleague1->notify($message);
        } else {
            $this->colleague2->notify($message);
        }
    }
}

$mediator = new ConcreteMediator;
$coll1 = new ConcreteColleague1($mediator);
$coll2 = new ConcreteColleague2($mediator);

$mediator->colleague1 = $coll1;
$mediator->colleague2 = $coll2;

$coll1->send('How are you?');
$coll2->send('Fine, thanks');