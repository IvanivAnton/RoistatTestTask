<?php

class ParserScriptTest extends \PHPUnit\Framework\TestCase
{
    public function testScript()
    {
        $parserScriptPath = __DIR__ . '/../parser.php';
        $controlAccessLogPath = __DIR__ . '/resources/access.log';
        $expectedOutput = '{"views":16,"urls":5,"traffic":187990,"crawlers":{"google":2,"bing":0,"baidu":0,"yandex":0},"statusCodes":{"200":14,"301":2},"lines":16}' . "\n";

        $output = shell_exec("php $parserScriptPath $controlAccessLogPath");

        $this->assertEquals($expectedOutput, $output);
    }
}
