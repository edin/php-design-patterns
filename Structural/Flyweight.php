<?php

class FlyweightDateFactory
{
    private static $dates = [];
    public static function getDate($year, $month, $day)
    {
        $dateString = "$year-$month-$day";
        if (!isset(self::$dates[$dateString])) 
        {
            $date = DateTimeImmutable::createFromFormat("Y-m-d",$dateString);
            self::$dates[$dateString] = $date;    
        }
        return self::$dates[$dateString];
    }
    
    public static function getInstanceCount()
    {
        return count(self::$dates);
    }
}

class DateFactory
{
    public static function getDate($year, $month, $day)
    {
        $dateString = "$year-$month-$day";
        $date = DateTimeImmutable::createFromFormat("Y-m-d",$dateString);
        return $date;
    }
}

class User 
{
    public $id;
    public $registrationDate;
    
    public function __construct($id, $registrationDate)
    {
        $this->id = $id;
        $this->registrationDate = $registrationDate;
    }    
}

define("MAX_INSTANCES", 10000);

function flyweightTest()
{
    $startTime = microtime(true);
    $users = [];
    for ($i=0; $i < MAX_INSTANCES; ++$i) {
        
        $month   = mt_rand(1, 12);
        $maxDays = cal_days_in_month(CAL_GREGORIAN, $month, 2015);
        $day     = mt_rand(1, $maxDays);
        $user = new User($i, FlyweightDateFactory::getDate(2015, $month, $day));
        $users[] = $user;
    }    
    
    $data = new \stdClass;
    $data->dateInstanceCount = FlyweightDateFactory::getInstanceCount();
    $data->userInstanceCount = count($users);
    $data->memoryUsage = memory_get_usage();
    $data->time = microtime(true) - $startTime;
    return $data;
}

function withoutFlyweightTest()
{
    $startTime = microtime(true);
    $users = [];
    for ($i=0; $i < MAX_INSTANCES; ++$i) {
        
        $month   = mt_rand(1, 12);
        $maxDays = cal_days_in_month(CAL_GREGORIAN, $month, 2015);
        $day     = mt_rand(1, $maxDays);
        $user = new User($i, DateFactory::getDate(2015, $month, $day));
        $users[] = $user;
    }   
     
    $data = new \stdClass;
    $data->dateInstanceCount = count($users);
    $data->userInstanceCount = count($users);
    $data->memoryUsage = memory_get_usage();
    $data->time = microtime(true) - $startTime;
    return $data;    
}

function report($usage)
{
    echo " Total number of DateTimeImmutable instances: ", $usage->dateInstanceCount, "\n";
    echo " Total number of User instances: ", $usage->userInstanceCount, "\n";
    echo " Total memory used: ",  round($usage->memoryUsage / 1000, 2), " MB\n";
    echo " Total time: ",  round($usage->time, 2), " sec\n";    
}

echo "Without flyweight factory:\n";
report(withoutFlyweightTest());
echo "\n";

echo "With flyweight factory:\n";
report(flyweightTest());

/**
Without flyweight factory:
 Total number of DateTimeImmutable instances: 100000
 Total number of User instances: 100000
 Total memory used: 42387.5 MB
 Total time: 0.77 sec

With flyweight factory:
 Total number of DateTimeImmutable instances: 365
 Total number of User instances: 100000
 Total memory used: 11329.98 MB
 Total time: 0.16 sec
*/