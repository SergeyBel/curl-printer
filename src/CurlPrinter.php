<?php

declare(strict_types=1);

namespace CurlPrinter;

use CurlPrinter\Formatter\CurlFormatter;

class CurlPrinter
{
    private CurlFormatter $formatter;

    public function __construct()
    {
        $this->formatter = new CurlFormatter();
    }

    public function print(RequestData $curlData): string
    {
        return $this->formatter->format($curlData);
    }


    public function setFormatter(CurlFormatter $formatter)
    {
        $this->formatter = $formatter;
        return $this;
    }
}
