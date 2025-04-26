<?php

declare(strict_types=1);

namespace CurlPrinter\Extractor;

use CurlPrinter\RequestData;
use Psr\Http\Message\RequestInterface;

class PsrRequestExtractor
{
    public function extract(RequestInterface $request): RequestData
    {
        $curlData = new RequestData(
            $this->extractMethod($request),
            $this->extractUrl($request),
            $this->extractHeaders($request),
            $this->extractBody($request)
        );
        return $curlData;
    }

    private function extractMethod(RequestInterface $request): string
    {
        return $request->getMethod();
    }

    private function extractHeaders(RequestInterface $request): array
    {
        return $request->getHeaders();
    }

    private function extractUrl(RequestInterface $request): string
    {
        return (string)$request->getUri();
    }

    private function extractBody(RequestInterface $request): string
    {
        return (string)$request->getBody();
    }
}
