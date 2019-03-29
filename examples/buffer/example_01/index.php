<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 27.03.19
 * Time: 16:50
 */


/**
 * This function isolate template.php apart from rest of code
 * @param array $rows
 * @param string $
 * @return string
 */
function renderView(array $rows):string{
    ob_start();
    // be careful to use variables in path string
    include 'template.php';
    return ob_get_clean();
}

$data = ['apple','banana','peach','grape'];

$rendered = renderView($data);

echo $rendered;