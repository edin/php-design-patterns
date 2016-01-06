<?php

class Calculator
{
    private $curr;
    
    public function __construct()
    {
        $this->curr = 0;
    }
    
    public function operation(string $oper, int $operand)
    {
        switch ($oper) {
            case '+': $this->curr = $this->curr + $operand; break;
            case '-': $this->curr = $this->curr - $operand; break;
            case '*': $this->curr = $this->curr * $operand; break;
            case '/': $this->curr = $this->curr / $operand; break;
        }
        echo sprintf('Current Value = %f (following %s, %d)', $this->curr, $oper, $operand), "\n";
    }
}

interface CommandInterface
{
    function execute();
    function unExecute();
}

class CalculatorCommand implements CommandInterface
{
    private $operator;
    private $operand;
    private $calculator;
    
    public function __construct(Calculator $calc, string $oper, int $operand)
    {
        $this->calculator = $calc;
        $this->operator = $oper;
        $this->operand = $operand;
    }
    
    public function execute()
    {
        $this->calculator->operation($this->operator, $this->operand);
    }
    
    public function unExecute()
    {
        $operator = $this->undo($this->operator);
        $this->calculator->operation($operator, $this->operand);
    }
    
    public function undo(string $oper) : string
    {
        switch($oper)
        {
            case '+': return '-';
            case '-': return '+';
            case '*': return '/';
            case '/': return '*';
        }        
        throw new \Exception("$oper is not valid operator");
    }
}

class User 
{
    private $calculator;
    private $commands;
    private $current;
    
    public function __construct()
    {
        $this->calculator = new Calculator;
        $this->commands = [];
        $this->current = 0;
    }
    
    public function Redo(int $levels)
    {
        echo "Redo $levels levels\n";
        for ($i = 0; $i < $levels; $i++)
        {
            if ($this->current < count($this->commands) - 1)
            {
                $command = $this->commands[$this->current];
                $command->execute();
                $this->current += 1;
            }
        }        
    }
    
    public function Undo(int $levels)
    {
        echo "Undo $levels levels\n";
        for ($i = 0; $i < $levels; $i++)
        {
            if ($this->current > 0)
            {
                $this->current -= 1;
                $command = $this->commands[$this->current];
                $command->unExecute();
            }
        }
    }
    
    public function compute(string $oper, int $operand)
    {
        $command = new CalculatorCommand($this->calculator, $oper, $operand);
        $command->execute();
        $this->commands[] = $command;
        $this->current = $this->current + 1;
    }
}


$user = new User;

$user->compute('+', 100);
$user->compute('-', 50);
$user->compute('*', 10);
$user->compute('/', 2);

$user->undo(4);
$user->redo(3);