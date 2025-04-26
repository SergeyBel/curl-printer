<?php

declare(strict_types=1);

namespace CurlPrinter;

class RequestData
{
    /**
     * @param string $method
     * @param string[][] $headers
     */
    public function __construct(
        private HttpMethod $method,
        private string $url,
        private array $headers = [],
        private string $body = ''
    ) {

    }


    public function getMethod(): HttpMethod
    {
        return $this->method;
    }


    public function setMethod(HttpMethod $method): self
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
