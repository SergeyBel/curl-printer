<?php

declare(strict_types=1);

namespace CurlPrinter\Formatter;

class FormatterSettings
{
    /**
     * @var array<string, string>
     */
    private array $replaces = [];

    private bool $multiline = false;

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

    public function isMultiline(): bool
    {
        return $this->multiline;
    }

    public function setMultiline(): self
    {
        $this->multiline = true;
        return $this;
    }
}
