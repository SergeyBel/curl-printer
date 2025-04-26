<?php

declare(strict_types=1);

namespace CurlPrinter\Formatter;

use CurlPrinter\RequestData;
use CurlPrinter\HttpMethod;

class CurlFormatter implements FormaterInterface
{
    public const METHOD_OPTION = '-X';
    public const BODY_OPTION = '-d';
    public const HEADER_OPTION = '-H';

    private array $command;

    public function __construct()
    {
    }

    public function format(RequestData $request): string
    {
        $this->command = ['curl'];
        $this->addMethod($request->getMethod());
        $this->addUrl($request->getUrl());
        $this->addBody($request->getBody());
        $this->addHeaders($request->getHeaders());

        return implode(' ', $this->command);
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
        ;
        if (strlen($body) > 0) {
            $this->addNamedOption(self::BODY_OPTION, "'" . $body . "'");
        }
    }

    protected function addHeaders(array $headers): void
    {

        foreach ($headers as $name => $header) {
            $this->addNamedOption(self::HEADER_OPTION, "'" . $name . ': ' . $header[0] . "'");
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
