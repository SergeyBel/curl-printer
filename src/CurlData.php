<?php

declare(strict_types=1);

namespace CurlPrinter;

/**
 * Class CurlData
 * Dto for curl request parameters
 *
 * @package CurlPrinter
 */
class CurlData
{
    /** @var string */
    private $method;

    /** @var string */
    private $url;

    /** @var string[][] */
    private $headers;

    /** @var string */
    private $body;


    public function getMethod(): string
    {
        return $this->method;
    }


    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }


    public function getUrl(): string
    {
        return $this->url;
    }


    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }


    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param \string[][] $headers
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }


    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }
}
