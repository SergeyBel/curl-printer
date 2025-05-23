<?php

declare(strict_types=1);

namespace CurlPrinter\Formatter;

use CurlPrinter\RequestData;

interface FormatterInterface
{
    public function format(RequestData $request): string;

    public function setSettings(FormatterSettings $settings): self;
}
