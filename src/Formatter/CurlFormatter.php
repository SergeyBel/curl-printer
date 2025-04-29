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


    private FormatterSettings $settings;

    public function __construct()
    {
        $this->settings = new FormatterSettings();
    }

    public function format(RequestData $request): string
    {
        $methodPart = $this->getMethodPart($request->getMethod());
        $urlPart = $this->getUrlPart($request->getUrl());
        $headersPart = $this->getHeadersPart($request->getHeaders());
        $bodyPart = $this->getBodyPart($request->getBody());

        $text = $this->formatCommand($methodPart, $urlPart, $headersPart, $bodyPart);

        return $this->applyReplace($text);


    }

    public function setSettings(FormatterSettings $settings): self
    {
        $this->settings = $settings;
        return $this;
    }


    protected function getMethodPart(HttpMethod $method): ?LineOption
    {
        if ($method !== HttpMethod::GET) {
            return new LineOption($method->value, self::METHOD_OPTION);
        }
        return null;
    }

    protected function getUrlPart(string $url): LineOption
    {
        return new LineOption($url);
    }

    protected function getBodyPart(string $body): ?LineOption
    {
        if (strlen($body) > 0) {
            return new LineOption($this->settings->getQuotes() . $body . $this->settings->getQuotes(), self::BODY_OPTION);

        }
        return null;
    }

    /**
     * @param string[][] $headers
     * @return array<LineOption>
     */
    protected function getHeadersPart(array $headers): array
    {
        $headersPart = [];
        foreach ($headers as $name => $value) {
            $textValue = implode(',', $value);
            $headersPart[] = new LineOption($this->settings->getQuotes() . $name . ': ' . $textValue . $this->settings->getQuotes(), self::HEADER_OPTION);

        }

        return $headersPart;
    }

    /**
     * @param array<LineOption> $headersPart
     */
    private function formatCommand(
        ?LineOption $methodPart,
        LineOption $urlPart,
        array $headersPart,
        ?LineOption $bodyPart
    ): string {
        $startPart = ['curl'];

        if (!is_null($methodPart)) {
            $startPart = array_merge($startPart, [$methodPart->getString()]);
        }

        $startPart = array_merge($startPart, [$urlPart->getString()]);

        $command = [implode(' ', $startPart)];

        foreach ($headersPart as $header) {
            $command = array_merge($command, [$header->getString()]);
        }

        if (!is_null($bodyPart)) {
            $command = array_merge($command, [$bodyPart->getString()]);
        }

        $separator = ' ';
        if ($this->settings->isMultiline()) {
            $separator = " \\\n";
        }

        return implode($separator, $command);
    }

    private function applyReplace(string $command): string
    {
        return str_replace(
            array_keys($this->settings->getReplaces()),
            array_values($this->settings->getReplaces()),
            $command
        );
    }

}
