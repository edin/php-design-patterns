<?php

class Purchase
{
    public $number;
    public $amount;
    public $purpose;
    
    public function __construct(int $number, float $amount, string $purpose)
    {
        $this->number = $number;
        $this->amount = $amount; 
        $this->purpose = $purpose;
    }
}

interface IApprover 
{
    function setSuccessor(IApprover $successor);
    function processRequest(Purchase $purchase);     
}

abstract class Approver implements IApprover
{
    protected $successor;
    
    public function setSuccessor(IApprover $successor)  
    {
        $this->successor = $successor;
    }
    
    public function write($format, $number)
    {
        echo sprintf($format, $number), "\n";
    }
    
    public abstract function processRequest(Purchase $purchase);
}

class Director extends Approver
{
    public function processRequest(Purchase $purchase)
    {
        if ($purchase->amount < 10000.0) 
        {
            $this->write("Director approved request # %d", $purchase->number);
        } 
        else if ($this->successor != null) 
        {
            $this->successor->processRequest($purchase);  
        }
    }
}

class VicePresident extends Approver
{
    public function processRequest(Purchase $purchase)
    {
        if ($purchase->amount < 25000.0) 
        {
            $this->write("VicePresident approved request # %d", $purchase->number);
        } 
        else if ($this->successor != null) 
        {
            $this->successor->processRequest($purchase);  
        }
    }    
}

class President extends Approver
{
    public function processRequest(Purchase $purchase)
    {
        if ($purchase->amount < 100000.0) 
        {
            $this->write("President approved request # %d", $purchase->number);
        } 
        else
        {
            $this->write('Request# %d requires an executive meeting!', $purchase->number);  
        }
    }    
}


$director = new Director;
$vicePresident = new VicePresident;
$president = new President;

try 
{
    $director->setSuccessor($vicePresident);
    $vicePresident->setSuccessor($president);
    
    $purchase = new Purchase(2034, 350.00, 'Supplies');
    $director->processRequest($purchase);

    
    $purchase = new Purchase(2035, 32590.10, 'Project X');
    $director->processRequest($purchase);
    
    
    $purchase = new Purchase(2036, 122100.00, 'Project Y');
    $director->processRequest($purchase);    
}
catch(\Exception $e)
{
    echo "Error :", $e->getMessage();
}


