<?php

namespace Parser\Models;

class View
{
    private string $method;
    private string $url;
    private int $statusCode;
    private int $bites;
    private string $userAgent;

    /**
     * @param string $method Request method
     * @param string $url Request url
     * @param int $statusCode Request return code
     * @param int $bites
     * @param string $userAgent
     */
    public function __construct(string $method, string $url, int $statusCode, int $bites, string $userAgent)
    {
        $this->method = $method;
        $this->url = $url;
        $this->statusCode = $statusCode;
        $this->bites = $bites;
        $this->userAgent = $userAgent;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function statusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function userAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @return int
     */
    public function bites(): int
    {
        return $this->bites;
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }
}
