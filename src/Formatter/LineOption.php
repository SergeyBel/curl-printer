<?php

declare(strict_types=1);

namespace CurlPrinter\Formatter;

class LineOption
{
    public function __construct(
        private string $value,
        private ?string $name = null,
    ) {
    }


    public function getString(): string
    {
        $option = [];
        if (!is_null($this->name)) {
            $option[] = $this->name;
        }

        $option[] = $this->value;

        return implode(' ', $option);
    }
}
