<?php

declare(strict_types=1);

namespace CurlPrinter;

class RequestData
{
    /**
     * @var string[][]
     */
    private array $headers = [];
    /**
     * @param array<string, string|array<string>> $headers
     */
    public function __construct(
        private HttpMethod $method,
        private string $url,
        array $headers = [],
        private string $body = ''
    ) {
        $this->setHeaders($headers);

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

    /**
     * @return string[][]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array<string, string|array<string>> $headers
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $this->formatHeaders($headers);
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

    /**
     * @param array<string, string|array<string>> $headers
     * @return string[][]
     */
    private function formatHeaders(array $headers): array
    {
        $formedHeaders = [];
        foreach ($headers as $key => $value) {
            if (is_string($value)) {
                $formedHeaders[$key] = [$value];
            } else {
                $formedHeaders[$key] = $value;
            }
        }

        return $formedHeaders;
    }
}
