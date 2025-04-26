<?php

declare(strict_types=1);

namespace CurlPrinter\Formatter;

use CurlPrinter\RequestData;

interface FormaterInterface
{
    public function format(RequestData $request): string;
}
