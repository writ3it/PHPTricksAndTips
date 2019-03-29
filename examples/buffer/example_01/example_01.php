<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 27.03.19
 * Time: 16:50
 */



require_once 'view.php';

// Data generation part
$data = ['apple','banana','peach','grape'];
// ---

// "Render" view
$rendered = renderView($data, getcwd());

// Use html string
echo $rendered;