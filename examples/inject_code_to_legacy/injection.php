<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 02.04.19
 * Time: 21:59
 */

// YOUR CODE GOES HERE

//some example

// or some improve
$prefix = '/zmienna1/';
$len = strlen($prefix);
$uri = $_SERVER['REQUEST_URI'];

if (substr($uri,0,$len)==$prefix && strlen($prefix)<strlen($uri)){
    $_SERVER['REQUEST_URI'] = '/zmienna1/zmienna99';
}

// ----

require_once 'index.php';

// THIS PLACE IS BAD IDEA FOR YOUR CODE BUT IF YOU NEED  ¯\_(ツ)_/¯