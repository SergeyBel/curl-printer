<?php
namespace CurlPrinter;

/**
 * Class CurlFormatter
 * Format CurlData to curl command line string
 *
 * @package CurlPrinter
 */
class CurlFormatter
{
    /** @var string[] */
    private $command;

    /** @var string[] */
    private $skippedHeaders;

    public function __construct()
    {
        $this->skippedHeaders = [
          HttpHeaders::HEADER_HOST,
        ];
    }

    public function format(CurlData $curlData): string
    {
        $this->command = ['curl'];
        $this->addMethodOption($curlData);
        $this->addBody($curlData);
        $this->addHeaders($curlData);

        return implode(' ', $this->command);
    }

    private function addMethodOption(CurlData $curlData): void
    {
        $method = strtoupper($curlData->getMethod());

        if ($method != HttpMethods::GET) {
            $this->addNamedOption(CurlOptions::OPTION_METHOD, $method);
        }

        $this->addOption($curlData->getUrl());
    }

    private function addBody(CurlData $curlData): void
    {
        $body = $curlData->getBody();
        if (!empty($body)) {
            $this->addNamedOption(CurlOptions::OPTION_BODY, "'".$curlData->getBody()."'");
        }
    }

    private function addHeaders(CurlData $curlData): void
    {
        $headers = $curlData->getHeaders();

        foreach ($headers as $name => $header) {
            if (!in_array($name, $this->skippedHeaders)) {
                $this->addNamedOption(CurlOptions::OPTION_HEADER, "'".$name.': '.$header[0]."'");
            }
        }
    }

    private function addNamedOption(string $name, string $value): void
    {
        $this->command[] = $name;
        $this->command[] = $value;
    }

    private function addOption(string $value): void
    {
        $this->command[] = $value;
    }
}
