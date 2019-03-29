<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 29.03.19
 * Time: 21:29
 */

require_once 'Foo.php';
require_once dirname(__FILE__).'/../../../vendor/autoload.php';
use Demo\Utility\Profiler\Profiler;

function call($argv, $args){
    $class = Foo::class;
    switch($argv){
        case 0:
            return new $class();
        case 1:
            return new $class($args[0]);
        case 2:
            return new $class($args[0],$args[1]);
        case 3:
            return new $class($args[0],$args[1],$args[2]);
        case 4:
            return new $class($args[0],$args[1],$args[2],$args[3]);
        case 5:
            return new $class($args[0],$args[1],$args[2],$args[3],$args[4]);
        case 6:
            return new $class($args[0],$args[1],$args[2],$args[3],$args[4],$args[5]);
        case 7:
            return new $class($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6]);
        case 8:
            return new $class($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7]);
    };
    return ;
}

function call2($argv, $args){
    $reflect  = new ReflectionClass(Foo::class);
    return $reflect->newInstanceArgs($args);
}
function call3($argv, $args){
    $method = Foo::class;
    return new $method(...$args);
}

$output = [];

$profiler = new Profiler();
for($i = 1; $i<10000; $i++){
    $profiler->start('item');
    for($j = 1; $j<$i; $j++){
        call(5, [1,2,3,4,5]);
    }
    $profiler->end();
    $output[$i] = ['call'=>$profiler->getBlockTime('item')];
}

for($i = 1; $i<10000; $i++){
    $profiler->start('item');
    for($j = 1; $j<$i; $j++){
        call2(5, [1,2,3,4,5]);

    }
    $profiler->end();
    $output[$i]['reflection'] = $profiler->getBlockTime('item');
}


for($i = 1; $i<10000; $i++){
    $profiler->start('item');
    for($j = 1; $j<$i; $j++){
        call3(5, [1,2,3,4,5]);
    }
    $profiler->end();
    $output[$i]['unzip'] = $profiler->getBlockTime('item');
}

$fp = fopen('data.csv', 'w');
fputcsv($fp, ['no','call','reflection','unzip']);
foreach ($output as $i=>$fields) {
    fputcsv($fp, [$i]+$fields);
}

fclose($fp);