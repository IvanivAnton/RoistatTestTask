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
    $lineTrimmed = trim($line);
    if (empty($lineTrimmed)) {
        continue;
    }

    ++$result['lines'];

    $view = $parserService->parseLogLine($lineTrimmed);
    if (empty($view))
        continue;

    $result['views'] += 1;

    if ($arrayService->inArray($view->method(), $methodsToCalcTraffic, true)) {
        $result['traffic'] += $view->bites();
    }

    $viewUrlHashed = hash('md5', $view->url());
    if (!$arrayService->inArray($viewUrlHashed, $uniqueUrlsHashed, true)) {
        $result['urls'] += 1;
        $uniqueUrlsHashed[] = $viewUrlHashed;
    }

    $viewStatusCode = $view->statusCode();
    if (!$arrayService->arrayKeyExists($viewStatusCode, $result['statusCodes'])) {
        $result['statusCodes'][$viewStatusCode] = 1;
    } else {
        $result['statusCodes'][$viewStatusCode] += 1;
    }

    $viewUserAgent = $stringService->strToLower($view->userAgent());
    foreach ($crawlersKeywords as $keyword) {
        if ($stringService->strPos($viewUserAgent, $keyword) !== false) {
            $result['crawlers'][$keyword] += 1;
            break;
        }
    }

    if (!$arrayService->inArray($viewUserAgent, $uniqueUserAgents, true)) {
        $uniqueUserAgents[] = $viewUserAgent;
    }
}

foreach ($crawlersKeywords as $keyword) {
    $result['crawlers'][$stringService->uppercaseFirst($keyword)] = $result['crawlers'][$keyword];
    unset($result['crawlers'][$keyword]);
}

echo $arrayService->jsonEncode($result) . PHP_EOL;
