<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 27.03.19
 * Time: 17:53
 */

define('TESTDIR',dirname(__FILE__));
define('EXAMPLESDIR',realpath(TESTDIR.'/../'));
define('DS', DIRECTORY_SEPARATOR);


function clearName(string &$name){
    $name = preg_replace('/[^a-zA-Z0-1]/','', $name);
}
class ExampleNotFound extends \Exception{};
function loadExample(string $module, string $no,string $name){
    clearName($module);
    clearName($no);
    clearName($name);
    $path = EXAMPLESDIR.DS.$module.DS."example_{$no}".DS.$name.".php";
    if (!file_exists($path)){
        throw new ExampleNotFound("example not found in [$path]");
    }
    return require_once $path;
}