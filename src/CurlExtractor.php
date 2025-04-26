<?php

declare(strict_types=1);

namespace CurlPrinter;

use Psr\Http\Message\RequestInterface;

/**
 * Class CurlExtractor
 * Extract request data from RequestInterface to CurlData
 *
 * @package CurlPrinter
 */
class CurlExtractor
{
    public function extract(RequestInterface $request): CurlData
    {
        $curlData = new CurlData();
        $curlData
            ->setMethod($this->extractMethod($request))
            ->setUrl($this->extractUrl($request))
            ->setHeaders($this->extractHeaders($request))
            ->setBody($this->extractBody($request));
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
