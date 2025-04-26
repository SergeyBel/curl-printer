<?php

declare(strict_types=1);

namespace CurlPrinter;

use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CurlPrinterMiddleware
 * Middleware to use with Guzzle. See examples for more information
 *
 * @package CurlPrinter
 */
class CurlPrinterMiddleware
{
    /** @var LoggerInterface  */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $curlPrinter = new CurlPrinter();
            $this->logger->debug($curlPrinter->printRequest($request));
            return $handler($request, $options);
        };
    }
}
