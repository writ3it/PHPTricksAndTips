<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 27.03.19
 * Time: 17:45
 */


loadExample('buffer','01','view');


class ViewTest extends \PHPUnit\Framework\TestCase
{
    private $basePath;
    private $path;

    protected function setUp():void{
        $this->basePath = TESTDIR.DS."buffer/example_01/";
        $this->path = $this->basePath.'template.php';
    }

    public function testScopeIsolation(){
        $data = ['test'];
        $render = renderView($data,$this->basePath,'template');
        $this->assertEquals(json_encode(['data'=>$data,'path'=>$this->path]), $render);
    }

    public function testFileNotFound(){
        $data = ['test'];
        $this->expectException(ViewNotFoundException::class);
        renderView($data,$this->basePath,'template_not_found');
    }
}