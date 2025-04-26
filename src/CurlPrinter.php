<?php

declare(strict_types=1);

namespace CurlPrinter;

use CurlPrinter\Formatter\CurlFormatter;
use CurlPrinter\Formatter\FormatterInterface;

class CurlPrinter
{
    private FormatterInterface $formatter;

    public function __construct()
    {
        $this->formatter = new CurlFormatter();
    }

    public function print(RequestData $curlData): string
    {
        return $this->formatter->format($curlData);
    }

    public function setFormatter(FormatterInterface $formatter): self
    {
        $this->formatter = $formatter;
        return $this;
    }
}
