<?php

namespace Parser;

require 'vendor/autoload.php';

use Parser\Helpers\FileReader;
use Parser\Services;

$result = [
    'views' => 0,
    'urls' => 0,
    'traffic' => 0,
    'crawlers' => [
        'google' => 0,
        'bing' => 0,
        'baidu' => 0,
        'yandex' => 0,
    ],
    'statusCodes' => [

    ],
    'lines' => 0
];

$reader = new FileReader($argv[1]);
$parserService = new Services\AccessLogParseService();
$arrayService = new Services\ArrayService();
$stringService = new Services\StringService();

$uniqueUrlsHashed = [];
$methodsToCalcTraffic = ['POST', 'PATCH', 'PUT'];
$crawlersKeywords = ['google', 'bing', 'baidu', 'yandex'];

$uniqueUserAgents = [];

foreach ($reader->lines() as $line) {
    $trimmedLine = trim($line);
    if (empty($trimmedLine)) {
        continue;
    }

    ++$result['lines'];

    $request = $parserService->parseLogLine($trimmedLine);
    if (empty($request))
        continue;

    $result['views'] += 1;

    if ($arrayService->inArray($request->method(), $methodsToCalcTraffic, true)) {
        $result['traffic'] += $request->bites();
    }

    $requestUrlHashed = hash('md5', $request->url());
    if (!$arrayService->inArray($requestUrlHashed, $uniqueUrlsHashed, true)) {
        $result['urls'] += 1;
        $uniqueUrlsHashed[] = $requestUrlHashed;
    }

    $requestStatusCode = $request->statusCode();
    if (!$arrayService->arrayKeyExists($requestStatusCode, $result['statusCodes'])) {
        $result['statusCodes'][$requestStatusCode] = 1;
    } else {
        $result['statusCodes'][$requestStatusCode] += 1;
    }

    $requestUserAgent = $stringService->strToLower($request->userAgent());
    foreach ($crawlersKeywords as $keyword) {
        if ($stringService->strPos($requestUserAgent, $keyword) !== false) {
            $result['crawlers'][$keyword] += 1;
            break;
        }
    }

    if (!$arrayService->inArray($requestUserAgent, $uniqueUserAgents, true)) {
        $uniqueUserAgents[] = $requestUserAgent;
    }
}

echo $arrayService->jsonEncode($result) . PHP_EOL;
