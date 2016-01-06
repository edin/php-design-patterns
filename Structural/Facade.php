<?php

class SystemA
{
    function A1() : string
    {
        return "SystemA , Method A1\n";
    }
}

class SystemB
{
    function B1() : string 
    {
        return "SystemB , Method B1\n";
    }
}

class SystemC
{
    function C1() : string 
    {
        return "SystemC , Method C1\n";
    }
}

class Facade 
{
    static function Operation1()
    {
        $a = new SystemA();
        $b = new SystemB();
        $c = new SystemC();
        
        echo "Operation 1 \n";
        echo " ", $a->A1();
        echo " ", $b->B1();
        echo " ", $c->C1();
    }
    
    static function Operation2()
    {
        $b = new SystemB();
        $c = new SystemC();
        
        echo "Operation 2 \n";
        echo " ", $b->B1();
        echo " ", $c->C1();        
    }
}


Facade::Operation1();
Facade::Operation2();