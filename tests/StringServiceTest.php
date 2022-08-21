<?php

use Parser\Services;

class StringServiceTest extends \PHPUnit\Framework\TestCase
{
    private Services\StringService $stringService;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->stringService = new Services\StringService();
    }

    public function testStrToLower()
    {
        $string = "HelloWorld";
        $stringLower = "helloworld";
        $this->assertEquals($this->stringService->strToLower($string), $stringLower);
    }

    public function testStrPos()
    {
        $string = "HelloHello";
        $substring = "Hello";
        $position = 0;

        $this->assertEquals($this->stringService->strPos($string, $substring), $position);

        $offset = strlen($substring);
        $position = $offset;

        $this->assertEquals($this->stringService->strPos($string, $substring, $offset), $position);
    }

    public function testUpperCaseFirst()
    {
        $string = 'hello';
        $stringUpperCaseFirst = 'Hello';

        $this->assertEquals($this->stringService->uppercaseFirst($string), $stringUpperCaseFirst);
    }
}
