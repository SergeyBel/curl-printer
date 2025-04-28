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


    private FormatterSettings $options;

    public function __construct()
    {
        $this->options = new FormatterSettings();
    }

    public function format(RequestData $request): string
    {
        $methodPart = $this->getMethodPart($request->getMethod());
        $urlPart = $this->getUrlPart($request->getUrl());
        $headersPart = $this->getHeadersPart($request->getHeaders());
        $bodyPart = $this->getBodyPart($request->getBody());

        $text = $this->formatCommand($methodPart, $urlPart, $headersPart, $bodyPart);

        $replacedText = str_replace(
            array_keys($this->options->getReplaces()),
            array_values($this->options->getReplaces()),
            $text
        );
        return $replacedText;
    }

    public function setOptions(FormatterSettings $options): self
    {
        $this->options = $options;
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
            return new LineOption("'" . $body . "'", self::BODY_OPTION);

        }
        return null;
    }

    /**
     * @param string[][] $headers
     * @return array<LineOption> $headers
     */
    protected function getHeadersPart(array $headers): array
    {
        $headersPart = [];
        foreach ($headers as $name => $value) {
            $textValue = implode(',', $value);
            $headersPart[] = new LineOption("'" . $name . ': ' . $textValue . "'", self::HEADER_OPTION);

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
        $command = ['curl'];

        if (!is_null($methodPart)) {
            $command = array_merge($command, $methodPart->getArray());
        }

        $command = array_merge($command, $urlPart->getArray());

        foreach ($headersPart as $header) {
            $command = array_merge($command, $header->getArray());
        }

        if (!is_null($bodyPart)) {
            $command = array_merge($command, $bodyPart->getArray());
        }

        return implode(' ', $command);
    }

}
