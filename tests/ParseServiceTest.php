<?php

class ParseServiceTest extends \PHPUnit\Framework\TestCase
{
    public function testParser()
    {
        $accessLogParseService = new Parser\Services\AccessLogParseService();

        $userAgent = 'Mozilla/5.0 (Windows NT 6.2; Win64; x64; rv:16.0)Gecko/16.0 Firefox/16.0';
        $url = '/product/31893/62100/%D8%B3%D8%B4%D9%88%D8%A7%D8%B1-%D8%AE%D8%A7%D9%86%DA%AF%DB%8C-%D9%BE%D8%B1%D9%86%D8%B3%D9%84%DB%8C-%D9%85%D8%AF%D9%84-PR257AT';
        $statusCode = '200';
        $bites = '41483';
        $method = "GET";
        $log = "91.99.72.15 - - [22/Jan/2019:03:56:17 +0330] \"$method $url HTTP/1.1\" $statusCode $bites \"-\" \"$userAgent\" \"-\"";
        $view = $accessLogParseService->parseLogLine($log);

        $this->assertEquals($userAgent, $view->userAgent());
        $this->assertEquals($method, $view->method());
        $this->assertEquals($bites, $view->bites());
        $this->assertEquals($statusCode, $view->statusCode());
        $this->assertEquals($url, $view->url());

        $referrer = "https://pp.com?qiery=j12jf03 \t1f13f2f31";
        $log = "91.99.72.15 - - [22/Jan/2019:03:56:17 +0330] \"$method $url HTTP/1.1\" $statusCode $bites \"$referrer\" \"$userAgent\" \"-\"";

        $view = $accessLogParseService->parseLogLine($log);
        $this->assertNotEmpty($view);

        $log = "WRONG ACCESS LOG FORMAT 91.99.72.15 - - [22/Jan/2019:03:56123:17 +0330] \"$method $url HTTP/1.1\" $statusCode $bites \"-\" \"$userAgent\" \"-\"";
        $view = $accessLogParseService->parseLogLine($log);
        $this->assertEmpty($view);

        $log = '';
        $view = $accessLogParseService->parseLogLine($log);
        $this->assertEmpty($view);

        $method = '\x17\x10\x05\x15JL\xAD\xDC\xCEL\xC1Ff>F';
        $statusCode = '400';
        $bites = '166';
        $userAgent = '-';
        $log = "72.52.125.78 - - [22/Jan/2019:09:55:32 +0330] \"$method\" $statusCode $bites \"-\" \"$userAgent\" \"-\"";
        $view = $accessLogParseService->parseLogLine($log);

        $this->assertEquals($userAgent, $view->userAgent());
        $this->assertEquals($method, $view->method());
        $this->assertEquals($bites, $view->bites());
        $this->assertEquals($statusCode, $view->statusCode());
        $this->assertEmpty($view->url());
    }
}
