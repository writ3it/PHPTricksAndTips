<?php
declare(strict_types=1);

use Demo\Utility\Profiler\Profiler;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 29.03.19
 * Time: 19:41
 */

class ProfilerTest extends TestCase
{
    public function test_time_measuring(){
        $profiler = new Profiler();
        $profiler->begin('block');
        sleep(1);
        $profiler->end();
        $this->assertGreaterThan(1000000000,$profiler->getBlockTime('block'));
        $this->assertLessThan(1500000000, $profiler->getBlockTime('block'));
    }
    public function test_time_measuring_2(){
        $profiler = new Profiler();
        $profiler->begin('block');
        sleep(2);
        $profiler->end();
        $this->assertGreaterThan(2000000000,$profiler->getBlockTime('block'));
        $this->assertLessThan(2500000000, $profiler->getBlockTime('block'));
    }
    public function test_time_reuse(){
        $profiler = new Profiler();
        $profiler->begin('block');
        sleep(1);
        $profiler->end();
        $this->assertGreaterThan(1000000000,$profiler->getBlockTime('block'));
        $this->assertLessThan(1500000000, $profiler->getBlockTime('block'));
        $profiler->begin('block');
        sleep(2);
        $profiler->end();
        $this->assertGreaterThan(2000000000,$profiler->getBlockTime('block'));
        $this->assertLessThan(2500000000, $profiler->getBlockTime('block'));
    }
}