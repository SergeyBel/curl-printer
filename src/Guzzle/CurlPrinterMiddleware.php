<?php

declare(strict_types=1);

namespace CurlPrinter\Guzzle;

use CurlPrinter\CurlPrinter;
use CurlPrinter\Extractor\PsrRequestExtractor;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

class CurlPrinterMiddleware
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $curlPrinter = new CurlPrinter();
            $extractor = new PsrRequestExtractor();
            $this->logger->debug($curlPrinter->print($extractor->extract($request)));
            return $handler($request, $options);
        };
    }
}
