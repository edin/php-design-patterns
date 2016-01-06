<?php
declare(strict_types = 1);

interface IComponent
{
    public function Add(IComponent $component);
    public function Remove(IComponent $component) : IComponent;
    public function Display(int $depth) : string;
    public function Find(IComponent $component);
    public function GetName() : string;
    public function SetName(string $value);
}

class Single implements IComponent
{
    private $name;
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    public function Add(IComponent $component)
    {
        echo "Cannot add to an item\n";
    }
    
    public function Remove(IComponent $component) : IComponent
    {
        echo "Cannot remove directly\n";
        return $this;
    }
    
    public function Display(int $depth) : string
    {
        return str_repeat("  ", $depth) . $this->GetName();
    }
    
    public function Find(IComponent $component) 
    {
        if ($component->GetName() == $this->GetName()) {
            return $component;
        }
        return null;
    }
    
    public function GetName() : string
    {
        return $this->name;
    }
    
    public function SetName(string $value)
    {
        $this->name = $value;
    }
}


class Composite implements IComponent
{
    private $name;
    private $items;
    
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->items = [];
    }
    
    public function Add(IComponent $component)
    {
        $this->items[$component->GetName()] = $component; 
    }
    
    public function Remove(IComponent $component) : IComponent
    {
        unset($this->items[$component->GetName()]); 
    }
    
    public function Display(int $depth) : string
    {
        $result = str_repeat("  ", $depth) . 
                 "Set ". $this->GetName() . 
                 " length: " . count($this->items) . "\n";
                 
        foreach ($this->items as $c) {
            $result .= $c->Display($depth + 1) . "\n";
        }
       
        return $result;
    }
    
    public function Find(IComponent $component) 
    {
        if (isset($this->items[$component->GetName()]))
        {
            return $this->items[$component->GetName()];
        }
        return null;
    }
    
    public function GetName() : string
    {
        return $this->name;
    }
    
    public function SetName(string $value)
    {
        $this->name = $value;
    }
}


$product  = new Composite("Product");
$a = new Composite("Part A");
$b = new Composite("Part B");
$c = new Composite("Part C");

$a->Add(new Single("Sub Part A-1"));
$a->Add(new Single("Sub Part A-2"));
$a->Add(new Single("Sub Part A-3"));
$a->Add(new Single("Sub Part A-4"));

$b->Add(new Single("Sub Part B-1"));
$b->Add(new Single("Sub Part B-2"));

$c->Add(new Single("Sub Part C-1"));
$c->Add(new Single("Sub Part C-2"));
$c->Add(new Single("Sub Part C-3"));

$product->Add($a);
$product->Add($b);
$product->Add($c);

echo $product->Display(0);
