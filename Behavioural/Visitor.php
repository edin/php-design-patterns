<?php

interface INodeVisitor
{
    function visitNode(Node $node);
    function visitUnaryExpression(UnaryExpression $node);
    function visitBinaryExpression(BinaryExpression $node);
}

class Node 
{
   public function accept(INodeVisitor $visitor)
   {
       $visitor->visit($this);
   }
}

class ConstExpression extends Node 
{
    public $value;
    public function __construct($value)
    {
        $this->value = $value;
    }     
}

class UnaryExpression extends Node
{
    public $op;
    public $expression;
   
    public function __construct(string $op, Node $expression)
    {
        $this->op = $op;
        $this->expression  = $expression;
    } 
}

class BinaryExpression extends Node
{
    public $op;
    public $left;
    public $right;
    
    public function __construct(string $op, Node $left, Node $right)
    {
        $this->op    = $op;
        $this->left  = $left;
        $this->right = $right;
    }
}

class PrintExpressionVisitor implements INodeVisitor
{
    private $ident = 0;
    
    public function visit(Node $node)
    {
        $reflect = new ReflectionClass($node);
        $className = $reflect->getShortName();
        $method = "visit{$className}";
        $visitor = new ReflectionClass($this);
        
        
        $this->enterNode($node);
        if ($visitor->hasMethod($method)) {
            $this->{$method}($node);    
        } else {
            $this->visitNode($node);
        }
        $this->leaveNode($node);
    }
    
    protected function enterNode(Node $node)
    {
        $this->ident++;
    }
    
    protected function leaveNode(Node $node)
    {
        $this->ident--;
    }
    
    public function visitNode(Node $node)
    {
        $className = get_class($node);
        $this->write("Visiting Node ($className)");
    }    
    
    public function visitConstExpression(ConstExpression $node)
    {
        $this->write("Visiting ConstExpression Value = {$node->value}"); 
    }
    
    public function visitUnaryExpression(UnaryExpression $node)
    {
        $this->write("Visiting UnaryExpression Op: {$node->op}");
        $this->visit($node->expression);
    }
    
    public function visitBinaryExpression(BinaryExpression $node)
    {
        $this->write("Visiting BinaryExpression Op: {$node->op}");
        $this->visit($node->left);
        $this->visit($node->right);
    }    
    
    protected function write($text)
    {
        echo str_repeat(" ", $this->ident*2), $text, "\n";
    }
}


class InterpreterVisitor implements INodeVisitor
{
    private $ident = 0;
    private $stack;
    
    public function __construct()
    {
        $this->stack = new \SplStack;
    }
    
    public function getResult()
    {
        return $this->stack->top();
    }
    
    public function visit(Node $node)
    {
        $reflect = new ReflectionClass($node);
        $className = $reflect->getShortName();
        $method = "visit{$className}";
        $visitor = new ReflectionClass($this);
        
        if ($visitor->hasMethod($method)) {
            $this->{$method}($node);    
        } else {
            $this->visitNode($node);
        }
    }
       
    public function visitNode(Node $node)
    {
        $className = get_class($node);
        $this->write("Visiting Node ($className)");
    }    
    
    public function visitConstExpression(ConstExpression $node)
    {
        $this->stack->push($node->value);
    }
    
    public function visitUnaryExpression(UnaryExpression $node)
    {
        $this->visit($node->expression);
        
        $value = $this->stack->pop();
        
        switch ($node->op) {
            case '-': $this->stack->push(-$value); return;
        }
        throw new \Exception("Operator {$node->op} is not supported");
    }
    
    public function visitBinaryExpression(BinaryExpression $node)
    {
        $this->visit($node->left);
        $this->visit($node->right);
        
        $right = $this->stack->pop();
        $left  = $this->stack->pop();
        
        switch ($node->op) {
            case '+': $this->stack->push($left + $right); return;
            case '-': $this->stack->push($left - $right); return;
            case '*': $this->stack->push($left * $right); return;
            case '/': $this->stack->push($left / $right); return;
        }
        throw new \Exception("Operator {$node->op} is not supported");        
    }    
}


$x = new ConstExpression(1);
$y = new ConstExpression(2);
$z = new ConstExpression(3);

$op1 = new BinaryExpression("+", $x, $y);
$op2 = new UnaryExpression("-", $op1);
$exp = new BinaryExpression("*", $op2, $z);

$printer     = new PrintExpressionVisitor;
$interpreter = new InterpreterVisitor;

$exp->accept($printer);
$exp->accept($interpreter);

echo $interpreter->getResult();