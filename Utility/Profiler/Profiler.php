<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 29.03.19
 * Time: 19:40
 */

namespace Demo\Utility\Profiler;


class Profiler
{

    private $currentBlock;
    private $tree;
    private $_stop;

    function __construct()
    {
        $this->currentBlock = 'root';
        $this->tree =  [
            'children'=>$this->createBlock($this->currentBlock)
        ];
    }

    public function begin(string $name=null)
    {
        $newBlock = $this->createBlock($name);
        $this->appendTo($this->tree,$this->currentBlock,$newBlock);
    }

    public function end()
    {
        $this->_stop = $this->getTime();
        $this->setStop($this->currentBlock);
    }

    public function getBlockTime($path){

        $this->_callback = new class implements ICallback{
            private $time;

            public function Run(array &$tree, ?string $currentBlock, string $path = '')
            {

                $this->time = $tree['time_ns'];
            }

            public function getTime(){
                return $this->time;
            }
        };
        $this->recursive($this->tree, 'root.'.$path);
        return $this->_callback->getTime();
    }

    public function summary()
    {
        while (strlen($this->currentBlock)>0){
            $this->end();
        }
        return $this->tree;
    }

    public function _getStopTime(){
        return $this->_stop;
    }

    private function createBlock(string $currentBlock)
    {
        return [
            $currentBlock=>[
                'start'=>$this->getTime(),
                'stop'=>0,
                'time_ns'=>0,
                'children'=>[]
            ]
        ];
    }

    public function getTime()
    {
        return \hrtime(true);
    }

    public function setCurrentBlock(string $path){
        $this->currentBlock = $path;
    }

    private function appendTo(array &$tree, ?string $currentBlock, array &$newBlock, string $path = '')
    {
        $this->_callback = new class($newBlock,$this) implements ICallback{
            private $newBlock;
            private $that;
            public function __construct($newBlock,$that)
            {
                $this->newBlock = $newBlock;
                $this->that = $that;
            }

            public function Run(array &$tree, ?string $currentBlock, string $path = '')
            {
                $key = array_keys($this->newBlock)[0];
                $this->that->setCurrentBlock(ltrim($path.'.'.$key,'.'));
                $tree['children']= array_merge($tree['children'],$this->newBlock);
            }
        };
        $this->recursive($tree, $currentBlock, $path);
    }
    private $_callback = null;
    private function recursive(array &$tree, ?string $currentBlock, string $path = '')
    {
        if ($currentBlock == null){

            $this->_callback->Run($tree, $currentBlock, $this->currentBlock);
            return ;
        }
        $pos = strpos($currentBlock,'.');
        if ($pos) {
            $part = substr($currentBlock, 0, $pos);
            $rest = substr($currentBlock, $pos+1);
        } else {
            $part = $currentBlock;
            $rest = null;
        }
        $this->recursive($tree['children'][$part], $rest, $path='.'.$part);
    }

    private function setStop(string $currentBlock)
    {
        $this->_callback = new class($this) implements ICallback{
            private $that;
            public function __construct($that)
            {
                $this->that = $that;
            }

            public function Run(array &$tree, ?string $currentBlock, string $path = '')
            {
             $tree['stop'] = $this->that->_getStopTime();
             $tree['time_ns'] = $tree['stop'] - $tree['start'];
             $path = substr($path, 0, strrpos($path,'.'));
             $this->that->setCurrentBlock($path);
            }
        };
        $this->recursive($this->tree, $currentBlock);
    }

    public function start(string $string)
    {
        $this->begin($string);
    }
}