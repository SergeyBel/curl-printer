<?php

declare(strict_types=1);

namespace CurlPrinter\Formatter;

use CurlPrinter\RequestData;
use CurlPrinter\HttpMethod;

class CurlFormatter implements FormatterInterface
{
    public const METHOD_OPTION = '-X';
    public const BODY_OPTION = '-d';
    public const HEADER_OPTION = '-H';

    /**
     * @var array<string>
     */
    private array $command;

    private FormatterOptions $options;

    public function __construct()
    {
        $this->options = new FormatterOptions();
    }

    public function format(RequestData $request): string
    {
        $this->command = ['curl'];
        $this->addMethod($request->getMethod());
        $this->addUrl($request->getUrl());
        $this->addBody($request->getBody());
        $this->addHeaders($request->getHeaders());

        $text = implode(' ', $this->command);

        $replacedText = str_replace(
            array_keys($this->options->getReplaces()),
            array_values($this->options->getReplaces()),
            $text
        );
        return $replacedText;
    }

    public function setOptions(FormatterOptions $options): self
    {
        $this->options = $options;
        return $this;
    }


    protected function addMethod(HttpMethod $method): void
    {
        if ($method !== HttpMethod::GET) {
            $this->addNamedOption(self::METHOD_OPTION, $method->value);
        }
    }

    protected function addUrl(string $url): void
    {
        $this->addOption($url);
    }

    protected function addBody(string $body): void
    {
        if (strlen($body) > 0) {
            $this->addNamedOption(self::BODY_OPTION, "'" . $body . "'");
        }
    }

    /**
     * @param array<string, array<string>> $headers
     */
    protected function addHeaders(array $headers): void
    {
        foreach ($headers as $name => $value) {
            $textValue = implode(',', $value);
            $this->addNamedOption(self::HEADER_OPTION, "'" . $name . ': ' . $textValue . "'");
        }
    }

    protected function addNamedOption(string $name, string $value): void
    {
        $this->command[] = $name;
        $this->command[] = $value;
    }

    protected function addOption(string $value): void
    {
        $this->command[] = $value;
    }
}
