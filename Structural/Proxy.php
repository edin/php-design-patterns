<?php

interface ISubject 
{
    function request() : string;
}

interface IProtected 
{
    function authenticate(string $supplied) : string;
}

class Subject
{
    public function request() : string 
    {
        return "Subject Request Choose left door";
    }
}

class Proxy implements ISubject
{
    private $subject = null;
    
    public function request() : string 
    {
        if ($this->subject == null) {
            echo "Subject inactive\n";
            $this->subject = new Subject;
        }
        echo "Subject active\n";
        return "Proxy: Call to " . $this->subject->request(); 
    }    
}

class ProtectionProxy implements ISubject, IProtected
{
    private $subject;
    private $password = "Abracadabra";
    
    public function authenticate(string $supplied) : string 
    {
        if ($supplied <> $this->password) {
            return "Protection Proxy: No Access!";
        } 
        $this->subject = new Subject;
        return "Protection Proxy: Authenticated";
    }
    
    public function request() : string 
    {
        if ($this->subject == null) {
            return 'Protection Proxy: Authenticate first!'; 
        } 
        return 'Protection Proxy: Call to ' . $this->subject->request(); 
    }
}

$subject = new Proxy;
echo $subject->request(), "\n";
echo $subject->request(), "\n";

$subject = new ProtectionProxy;
echo $subject->request(), "\n";

if ($subject instanceof IProtected) {
    echo $subject->authenticate("Secret"), "\n";
    echo $subject->authenticate("Abracadabra"), "\n";
}
echo $subject->request(), "\n";