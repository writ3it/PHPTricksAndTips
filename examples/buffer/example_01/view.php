<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 27.03.19
 * Time: 17:30
 */

/**
 * Goal: splitting code to template ("view") layer and logic layer with some scope isolation
 */

class ViewNotFoundException extends \Exception {};
/**
 * Use php file as template with vars
 * @param array $data defined vars for tempalte
 * @param string $basePath
 * @param string $filename
 * @return string
 * @throws ViewNotFoundException
 */
function renderView(array $data, string $basePath, string $filename='template'):string{

    $getPath = function (string $basePath, string $fileName='template'):string{
        $someSecureFileName = str_replace('/', '_', $fileName);
        $trimmedBasePath = rtrim($basePath,'/');
        return "{$trimmedBasePath}/{$someSecureFileName}.php";
    };

    $path = $getPath($basePath, $filename);
    if (!file_exists($path)){
        throw new ViewNotFoundException("View template file not found [$path]");
    }
    $runner = function(array $data) use($path) {
        include $path;
    };
    ob_start();
    // be careful to use variables in path string
    $runner($data);
    return ob_get_clean();
}

