<?php

namespace Parser\Services;

use Parser\Models\View;

class AccessLogParseService
{
    /**
     * @param string $accessLogLine
     * @return View|null
     */
    public function parseLogLine(string $accessLogLine): ?View
    {
        if (empty($accessLogLine)) {
            return null;
        }

        $logMatches = [];
        preg_match('/^\S+\s-\s-\s\[[^"]+]\s"(\S+)?\s?(\S+)?\s?(?:\S+)?"\s(\S+)\s(\S+)\s"[^"]+"\s"([^"]+)"/', $accessLogLine, $logMatches);
        if (empty($logMatches)) {
            return null;
        }

        $method = $logMatches[1];
        $url = $logMatches[2];
        $statusCode = $logMatches[3];
        $bites = $logMatches[4];
        $userAgent =  $logMatches[5];

        return new View($method, $url, $statusCode, $bites, $userAgent);
    }
}
