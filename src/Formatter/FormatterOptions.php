<?php

declare(strict_types=1);

namespace CurlPrinter\Formatter;

class FormatterOptions
{
    /**
     * @var array<string, string>
     */
    private array $replaces = [];

    /**
     * @return array<string, string>
     */
    public function getReplaces(): array
    {
        return $this->replaces;
    }

    public function addReplaced(string $value, string $replace): self
    {
        $this->replaces[$value] = $replace;
        return $this;
    }



}
