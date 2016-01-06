<?php

class Context
{
    public $input;
    public $output;
    
    public function __construct($input)
    {
        $this->input = $input;
    }
}

abstract class Expression
{
    public function interpret(Context $context)
    {
        if (strlen($context->input) == 0) 
        {
            return;
        }
        
        $first2chars = substr($context->input, 0,2);
        $char = substr($context->input, 0,1);
        
        if ($char == $this->nine() || $first2chars == $this->nine())
        {
            $context->output = $context->output + (9 * $this->multiplier());
            $context->input  = substr($context->input, 2);
        }
        else if ($char == $this->four() || $first2chars == $this->four())
        {
            $context->output = $context->output + (4 * $this->multiplier());
            $context->input  = substr($context->input, 2);
        }
        else if ($char == $this->five() || $first2chars == $this->five())
        {
            $context->output = $context->output + (5 * $this->multiplier());
            $context->input  = substr($context->input, 1);
        }
        
        while (substr($context->input, 0,1) == $this->one() || $first2chars == $this->one())
        {
            $context->output = $context->output + (1 * $this->multiplier());
            $context->input  = substr($context->input, 1);
        }
    }
    
    abstract public function one();
    abstract public function four();
    abstract public function five();
    abstract public function nine();
    abstract public function multiplier();
}

class TousandExpression extends Expression
{
    public function one()
    {
        return 'M'; 
    }
    
    public function four()
    {
        return '';
    }
    
    public function five()
    {
        return '';
    }
    
    public function nine()
    {
        return '';
    }
    
    public function multiplier()
    {
        return 1000;
    }    
}

class HundredExpression extends Expression
{
    public function one()
    {
        return 'C'; 
    }
    
    public function four()
    {
        return 'CD';
    }
    
    public function five()
    {
        return 'D';
    }
    
    public function nine()
    {
        return 'CM';
    }
    
    public function multiplier()
    {
        return 100;
    }    
}

class TenExpression extends Expression
{
    public function one()
    {
        return 'X'; 
    }
    
    public function four()
    {
        return 'XL';
    }
    
    public function five()
    {
        return 'L';
    }
    
    public function nine()
    {
        return 'XC';
    }
    
    public function multiplier()
    {
        return 10;
    }    
}

class OneExpression extends Expression
{
    public function one()
    {
        return 'I'; 
    }
    
    public function four()
    {
        return 'IV';
    }
    
    public function five()
    {
        return 'V';
    }
    
    public function nine()
    {
        return 'IX';
    }
    
    public function multiplier()
    {
        return 1;
    }    
}

function ConvertRoman($roman) 
{
    $context = new Context($roman);

    $list = [
        new TousandExpression(),
        new HundredExpression(),
        new TenExpression(),
        new OneExpression()  
    ];

    foreach ($list as $exp) {
        $exp->interpret($context);
    }

    echo sprintf("%s => %d \n", $roman, $context->output);
}


ConvertRoman('MCMXXVIII');
ConvertRoman('XLV');
ConvertRoman('MDCCC');
ConvertRoman('MMXVI');