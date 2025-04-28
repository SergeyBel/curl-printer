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

    /**
     * @return array<string>
     */
    public function getArray(): array
    {
        $option = [];
        if (!is_null($this->name)) {
            $option[] = $this->name;
        }

        $option[] = $this->value;

        return $option;
    }
}
