<?php

use Parser\Services;

class ArrayServiceTest extends \PHPUnit\Framework\TestCase
{
    private Services\ArrayService $arrayService;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->arrayService = new  Services\ArrayService();
    }

    public function testInArray()
    {
        $value = '123';
        $haystack = [$value];

        $this->assertTrue($this->arrayService->inArray($value, $haystack));
    }

    public function testNotInArray()
    {
        $value = '123';
        $haystack = [];

        $this->assertFalse($this->arrayService->inArray($value, $haystack));
    }

    public function testInArrayStrict()
    {
        $value = '123';
        $haystack = ['123'];

        $this->assertTrue($this->arrayService->inArray($value, $haystack, true));
    }

    public function testNotInArrayStrict()
    {
        $value = '123';
        $haystack = [123];

        $this->assertFalse($this->arrayService->inArray($value, $haystack, true));
    }

    public function testArrayKeyExists()
    {
        $key = '123123';
        $array = [$key => 'hello'];

        $this->assertTrue($this->arrayService->arrayKeyExists($key, $array));
    }

    public function testArrayKeyNotExists()
    {
        $key = '123123';
        $array = [];

        $this->assertFalse($this->arrayService->arrayKeyExists($key, $array));
    }

    public function testJsonEncode()
    {
        $array = ['hello' => 'world', 'foo' => 123, 'bar' => 12.3123];

        $arrayJson = '{"hello":"world","foo":123,"bar":12.3123}';

        $this->assertEquals($this->arrayService->jsonEncode($array), $arrayJson);
    }
}
