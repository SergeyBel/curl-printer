<?php

declare(strict_types=1);

namespace CurlPrinter;

use Psr\Http\Message\RequestInterface;

/**
 * Class CurlPrinter
 * Main class. Convert RequestInterface to curl command line string
 *
 * @package CurlPrinter
 */
class CurlPrinter
{
    /** @var CurlExtractor */
    private $extractor;

    /** CurlFormatter */
    private $formatter;

    public function __construct()
    {
        $this->extractor = new CurlExtractor();
        $this->formatter = new CurlFormatter();
    }


    public function printRequest(RequestInterface $request): string
    {
        $curlData = $this->extractor->extract($request);
        return $this->formatter->format($curlData);
    }



    public function setExtractor(CurlExtractor $extractor): self
    {
        $this->extractor = $extractor;
        return $this;
    }


    public function setFormatter(CurlFormatter $formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }
}
