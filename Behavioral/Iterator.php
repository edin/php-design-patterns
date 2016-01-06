<?php

class CustomObject
{
    public $name = "";
    
    public function __construct($name)
    {
        $this->name = $name;
    }
}

class CustomList implements IteratorAggregate 
{
    private $items = [];
    
    public function add(CustomObject $object)
    {
        $this->items[] = $object;
    }
    
    public function getIterator() 
    {
        return new CustomListIterator($this->items);
    }   
}

class CustomListIterator implements Iterator 
{
    private $items;
    private $position = 0;

    public function __construct($items) 
    {
        $this->items = $items;
        $this->position = 0;
    }

    function rewind() 
    {
        $this->position = 0;
    }

    function current() 
    {
        return $this->items[$this->position];
    }

    function key() 
    {
        return $this->position;
    }

    function next() 
    {
        ++$this->position;
    }

    function valid() 
    {
        return isset($this->items[$this->position]);
    }
}


$customList = new CustomList;

for ($i = 1; $i < 10; $i++) 
{
    $customList->add(new CustomObject("Object $i"));
}

foreach($customList as $obj)
{
    echo $obj->name, "\n"; 
}