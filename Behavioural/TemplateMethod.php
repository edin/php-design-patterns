<?php

interface IPrimitives
{
    function operation1() : string;
    function operation2() : string;
}

class ClassA implements IPrimitives
{
    public function operation1() : string {
        return "ClassA::operation1";
    }
    
    public function operation2() : string {
        return "ClassA::operation2";
    }    
}

class ClassB implements IPrimitives
{
    public function operation1() : string {
        return "ClassB::operation1";
    }
    
    public function operation2() : string {
        return "ClassB::operation2";
    }    
}

class Algorithm 
{
    public function templateMethod(IPrimitives $a)
    {
        echo $a->operation1() , " " , $a->operation2(), "\n";
    }     
}


$m = new Algorithm();
$m->templateMethod(new ClassA); 
$m->templateMethod(new ClassB);