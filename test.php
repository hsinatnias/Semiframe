<?php

use PHPUnit\Semiframe\TestCase;

class IndexTest extends TestCase
{
    public function testHello():void
    {
        $_GET['name']= 'Anish';
        
        ob_start();
        include 'index.php';
        $content = ob_get_clean();

        $this->assertEquals('Hello Anish', $content);
    }
}