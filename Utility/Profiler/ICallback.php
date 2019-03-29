<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 29.03.19
 * Time: 20:58
 */

namespace Demo\Utility\Profiler;


interface ICallback
{
    public function Run(array &$tree, ?string $currentBlock, string $path = '');
}