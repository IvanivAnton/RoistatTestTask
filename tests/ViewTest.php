<?php

use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testViewModel()
    {
        $method = 'GET';
        $url = '/index.php?f23jf23=123123';
        $statusCode = 200;
        $bites = 21233;
        $userAgent = "User agent hello";

        $view = new Parser\Models\View($method, $url, $statusCode, $bites, $userAgent);
        $this->assertEquals($method, $view->method());
        $this->assertEquals($url, $view->url());
        $this->assertEquals($statusCode, $view->statusCode());
        $this->assertEquals($bites, $view->bites());
        $this->assertEquals($userAgent, $view->userAgent());
    }
}
